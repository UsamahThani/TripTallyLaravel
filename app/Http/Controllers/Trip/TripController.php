<?php

namespace App\Http\Controllers\Trip;

use App\Http\Controllers\Controller;
use App\Models\Place;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
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

        // create new Trip
        $trip = new Trip([
            'from_location' => $validatedData['from_location'],
            'dest_location' => $validatedData['dest_location'],
            'depart_date' => $validatedData['depart_date'],
            'return_date' => $validatedData['return_date'],
            'budget' => $validatedData['budget'],
            'person_num' => $validatedData['person_num'],
            'user_id' => Auth::id(),
        ]);

        // Fetch geocode data
        $geocodeData = $this->findGeoCode($validatedData['dest_location']);
        // dd($geocodeData);

        if (!$geocodeData || empty($geocodeData['results'])) {
            Log::error('Error occurred while fetching data from Google Geocoding API');
            return view('error.fail')->with('error', 'Error occurred while fetching data from Google Geocoding API. API: Geocode Data');
        }

        // Find hotel using geocode data
        $hotelData = $this->findPlace($geocodeData['results'][0]['geometry']['location'], 'lodging');


        if (!$hotelData || empty($hotelData['results'])) {
            Log::error('Error occured while fetching data from Google Place API');
            return view('error.fail')->with('error', 'Error occured while fetching data from Google Place API. API: Hotel Data');
        }

        // find hotel image and insert into hotel object
        $hotelsList = [];
        foreach ($hotelData['results'] as $place) {
            $photoURL = isset($place['photos'][0]['photo_reference'])
                ? $this->findPlacePhoto($place['photos'][0]['photo_reference'])
                : null;
            $hotel = new Place([
                'trip_id' => $trip->get('trip_id'),
                'place_name' => $place['name'],
                'address' => $place['vicinity'] ?? 'N/A',
                'rating' => $place['rating'] ?? 'N/A',
                'price' => $this->generatePOIPrice($validatedData['budget'], 'lodging'),
                'user_rating_total' => $place['user_ratings_total'] ?? 'N/A',
                'photo_url' => $photoURL
            ]);
            $hotelsList[] = $hotel;
        }


        // Find poi using geocode data
        $poiData = $this->findPlace($geocodeData['results'][0]['geometry']['location'], 'museum|tourist_attraction|point_of_interest');


        if (!$poiData || empty($poiData['results'])) {
            Log::error('Error occured while fetching data from Google Place API');
            return view('error.fail')->with('error', 'Error occured while fetching data from Google Place API');
        }

        // find poi image and insert into hotel object
        $poiList = [];
        foreach ($poiData['results'] as $place) {
            $photoURL = isset($place['photos'][0]['photo_reference'])
                ? $this->findPlacePhoto($place['photos'][0]['photo_reference'])
                : null;
            $poi = new Place([
                'trip_id' => $trip->get('trip_id'),
                'place_name' => $place['name'],
                'address' => $place['vicinity'] ?? 'N/A',
                'rating' => $place['rating'] ?? 'N/A',
                'price' => $this->generatePOIPrice($validatedData['budget'], 'museum|tourist_attraction|point_of_interest'),
                'user_rating_total' => $place['user_ratings_total'] ?? 'N/A',
                'photo_url' => $photoURL
            ]);
            $poiList[] = $poi;
        }

        // Store hotelsList and poiList in the session
        session(['hotelsList' => $hotelsList]);
        session(['poiList' => $poiList]);

        dd(session());

        // return redirect('/trip/hotel');
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
    private function findPlace(array $location, $placeType): array
    {
        $radius = 5000; // Search radius in meters

        return Http::get('https://maps.googleapis.com/maps/api/place/nearbysearch/json', [
            'location' => "{$location['lat']},{$location['lng']}",
            'radius' => $radius,
            'type' => $placeType,
            'key' => $this->googleKey,
        ])->json();
    }

    /**
     * Find place image
     */
    private function findPlacePhoto($img_ref)
    {

        return Http::get('https://maps.googleapis.com/maps/api/place/photo', [
            'maxwidth' => 400,
            'photoreference' => $img_ref,
            'key' => $this->googleKey,
        ]);
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
