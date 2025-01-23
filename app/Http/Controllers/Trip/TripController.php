<?php

namespace App\Http\Controllers\Trip;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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
        $trip = Trip::create([
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

        if (!$geocodeData || empty($geocodeData['results'])) {
            abort(500, 'Error occurred while fetching data from Google Geocoding API');
        }

        // Find places using geocode data
        $placeData = $this->findPlace($geocodeData['results'][0]['geometry']['location']);

        if (!$placeData || empty($placeData['results'])) {
            abort(500, 'Error occured while fetching data from Google Place API');
        }

        foreach ($placeData['results'] as $place) {
            $photoURL = $this->findPlacePhoto($place['photos'][0]['photo_reference']) ?? null;
        }
        
        dd($placeData);

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
    private function findPlace(array $location): array
    {
        $radius = 5000; // Search radius in meters
        $type = 'lodging'; // Place type for hotels

        return Http::get('https://maps.googleapis.com/maps/api/place/nearbysearch/json', [
            'location' => "{$location['lat']},{$location['lng']}",
            'radius' => $radius,
            'type' => $type,
            'key' => $this->googleKey,
        ])->json();
    }

    /**
     * Find place image
     */
    private function findPlacePhoto($img_ref) {

        return Http::get('https://maps.googleapis.com/maps/api/place/photo', [
            'maxwidth' => 400,
            'photoreference' => $img_ref,
            'key' => $this->googleKey,
        ]);
    }

}
