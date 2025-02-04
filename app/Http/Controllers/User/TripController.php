<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Place;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Trip;

class TripController extends Controller
{
    protected $user, $googleKey;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = $request->user();
            $this->googleKey = config('services.google.api_key');

            return $next($request);
        });
    }

    /**
     * Using Google API to find hotels and POIs in JSON format
     */
    public function searchPlace(Request $request)
    {
        // Validate the requests
        $validatedData = $request->validate([
            'from_location' => 'required|string',
            'dest_location' => 'required|string',
            'depart_date' => 'required|date',
            'return_date' => 'required|date',
            'budget' => 'required|numeric',
            'person_num' => 'required|numeric',
        ]);

        // Fetch geocode data
        $geocodeData = $this->findGeoCode($validatedData['dest_location']);

        if (!$geocodeData || empty($geocodeData['results'])) {
            Log::error('Error occurred while fetching data from Google Geocoding API');
            return view('error.fail')->with('error', 'Error occurred while fetching data from Google Geocoding API. API: Geocode Data');
        }
        $cordinate = $geocodeData['results'][0]['geometry']['viewport'];

        // Create a new Trip
        $trip = Trip::create(array_merge($validatedData, ['user_id' => Auth::id()]));

        // save trip in the session
        session()->put('tripData', array_merge($trip->toArray(), ['cordinate' => $cordinate]));

        return redirect()->route('trip.hotel');
    }

    /**
     * Fetch geocode data from Google API
     */
    private function findGeoCode(string $destLocation): array
    {
        return HTTP::get('https://maps.googleapis.com/maps/api/geocode/json', [
            'address' => $destLocation,
            'key' => $this->googleKey,
        ])->json();
    }

    /**
     * Find places near given coordinates
     */
    public function fetchPlaceData()
    {
        $tripData = session('tripData');
        $placeType = '';
        if (session('searchType') === 'Hotels') {
            $placeType = 'lodging';
        } elseif (session('searchType') === 'Attractions') {
            $placeType = 'museum|tourist_attraction|point_of_interest';
        } else {
            Log::error('Error occured while fetching session data');
            return view('error.fail')->with('error', 'Error occured while fetching session data');
        }

        // Check if a hotel has already been booked
        $hotelBooked = Place::where('trip_id', $tripData['trip_id'])
            ->where('place_type', 'Hotels')
            ->exists();

        // Get list of booked places
        $bookedPlaces = Place::where('trip_id', $tripData['trip_id'])
            ->pluck('place_id')
            ->toArray();

        $placeData = Http::get('https://maps.googleapis.com/maps/api/place/textsearch/json', [
            'query' => "{$placeType},{$tripData['dest_location']}",
            'components' => 'administrative_area',
            'key' => $this->googleKey,
        ])->json();

        if (!$placeData || empty($placeData['results'])) {
            Log::error('Error occured while fetching data from Google Place API');
            return view('error.fail')->with('error', 'Error occured while fetching data from Google Place API. Code: ' . $placeType);
        }
        // dd($placeData);

        // find hotel image and insert into hotel object
        $placeList = [];
        foreach ($placeData['results'] as $place) {
            $photoURL = isset($place['photos'][0]['photo_reference'])
                ? $this->findPlacePhoto($place['photos'][0]['photo_reference'])
                : 'https://img.freepik.com/premium-vector/error-404-page-found-vector-concept-icon-internet-website-down-simple-flat-design_570429-4168.jpg?w=1380';
            $spot = new Place([
                'place_id' => $place['place_id'],
                'place_name' => $place['name'],
                'price' => $this->generatePOIPrice($tripData['budget'], $placeType),
                'place_location' => $place['formatted_address'] ?? 'N/A'

            ]);
            $placeList[] = array_merge($spot->toArray(), [
                'user_rating_total' => $place['user_ratings_total'] ?? 'N/A',
                'photo_url' => $photoURL,
                'rating' => $place['rating'] ?? 'N/A',

            ]);
        }

        return view('user.place', ['placeList' => $placeList, 'hotelBooked' => $hotelBooked, 'bookedPlaces' => $bookedPlaces]);
    }


    /**
     * Find place image
     */
    private function findPlacePhoto($img_ref)
    {
        $response = Http::get('https://maps.googleapis.com/maps/api/place/photo', [
            'maxwidth' => 400,
            'photoreference' => $img_ref,
            'key' => $this->googleKey,
        ]);

        return $response->effectiveUri();
    }

    /**
     * Generate hotel and poi price bcos google did not provide
     */
    private function generatePOIPrice($budget, $placeType)
    {
        if ($placeType == 'lodging') {
            $hotel_budget = $budget * 0.25;
            return rand(100, $hotel_budget);
        } else {
            $poi_budget = $budget * 0.6;
            if (rand(1, 100) <= 10) {
                return rand(101, $poi_budget);
            }

            return rand(3, min(100, $poi_budget));
        }
    }

    /**
     * View place detail
     */
    public function details(Request $request)
    {
        $place_id = $request->place_id;
        $price = $request->price;
        $place = $this->fetchPlaceDetail($place_id, $price);
        if (!$place) {
            Log::error('Error occured while fetching data from Google Place Detail API');
            return view('error.fail')->with('error', 'Error occured while fetching data from Google Place Detail API');
        }
        // find photos
        $placePhotos = $place['photos'] ?? [];
        $firstPhoto = "";
        $otherPhoto = [];
        foreach ($placePhotos as $index => $photo) {
            if ($index == 0) {
                $firstPhoto = $this->findPlacePhoto($photo['photo_reference']);
            } else {
                $otherPhoto[] = $this->findPlacePhoto($photo['photo_reference']);
            }
        }
        // dd($otherPhoto);
        return view('user.placedetails')->with('placeData', $place)->with('firstPhoto', $firstPhoto)->with('otherPhoto', $otherPhoto);
    }

    /**
     * fetch place details
     */
    public function fetchPlaceDetail($place_id, $price)
    {
        $response = Http::get('https://maps.googleapis.com/maps/api/place/details/json', [
            'place_id' => $place_id,
            'key' => $this->googleKey
        ]);

        // Check if the response is successful
        if ($response->successful()) {
            // Extract the 'result' data from the response
            $placeDetail = $response->json()['result'] ?? null;

            // Check if the result exists and extract specific data
            if ($placeDetail) {
                // Extract the required fields
                $placeData = [
                    'address' => $placeDetail['formatted_address'] ?? 'Address not available',
                    'current_opening_hours' => $placeDetail['current_opening_hours'] ?? null,
                    'geometry' => $placeDetail['geometry'] ?? null,
                    'name' => $placeDetail['name'] ?? 'Name not available',
                    'opening_hours' => $placeDetail['opening_hours'] ?? null,
                    'photos' => $placeDetail['photos'] ?? [],
                    'rating' => $placeDetail['rating'] ?? null,
                    'reviews' => $placeDetail['reviews'] ?? [],
                    'types' => $placeDetail['types'] ?? [],
                    'user_ratings_total' => $placeDetail['user_ratings_total'] ?? 0,
                    'phone_num' => $placeDetail['formatted_phone_number'] ?? null,
                    'website' => $placeDetail['website'] ?? null,
                    'price' => $price
                ];
                dd($placeData['reviews']);
                // Return the specific data in JSON format
                return $placeData;
            } else {
                return response()->json(['error' => 'Place details not found'], 404);
            }
        } else {
            // If the request failed, return an error message
            return response()->json(['error' => 'Failed to fetch place details'], 400);
        }
    }

}
