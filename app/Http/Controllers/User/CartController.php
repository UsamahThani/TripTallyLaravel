<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Place;

class CartController extends Controller
{
    public function create(Request $request)
    {

        $validateData = $request->validate([
            'place_id' => 'required|string',
            'place_name' => 'required|string',
            'place_location' => 'required|string', // Add validation for place_location
            'price' => 'required|numeric',
            'place_type' => 'required|string'
        ]);

        // get trip id from session
        $trip_id = session()->get('tripData.trip_id', null);

        //merge data for place
        $data = array_merge($validateData, ['trip_id' => $trip_id]);

        $cart = Place::create($data);

        if ($cart) {
            return redirect()->back()->with('success', 'Place added to cart successfully!');
        } else {
            return redirect()->back()->with('error', 'Place added to cart failed!');
        }
    }
}
