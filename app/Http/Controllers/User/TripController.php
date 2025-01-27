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

        $cordinate = $geocodeData['results'][0]['geometry']['location'];

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
        $radius = 5000; // Search radius in meters
        $tripData = session('tripData');
        $location = $tripData['cordinate'];
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

        $placeData = Http::get('https://maps.googleapis.com/maps/api/place/nearbysearch/json', [
            'location' => "{$location['lat']},{$location['lng']}",
            'radius' => $radius,
            'type' => $placeType,
            'key' => $this->googleKey,
        ])->json();

        if (!$placeData || empty($placeData['results'])) {
            Log::error('Error occured while fetching data from Google Place API');
            return view('error.fail')->with('error', 'Error occured while fetching data from Google Place API. Code: ' . $placeType);
        }

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
                'place_location' => $place['vicinity'] ?? 'N/A'

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


}
