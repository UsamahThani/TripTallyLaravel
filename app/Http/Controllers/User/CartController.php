<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Place;
use App\Models\Trip;

class CartController extends Controller
{
    public function create(Request $request)
    {

        $validateData = $request->validate([
            'place_id' => 'required|string',
            'place_name' => 'required|string',
            'place_location' => 'required|string', // Add validation for place_location
            'price' => 'required|numeric',
            'photo_url' => 'required|string',
            'place_type' => 'required|string|in:Hotels,Attractions'
        ]);

        // get trip id from session
        $trip_id = session()->get('tripData.trip_id', null);

        // Check if place_type is Hotels and if there is already a hotel for the current trip_id
        if ($validateData['place_type'] == 'Hotels') {
            $existingHotel = Place::where('trip_id', $trip_id)
                ->where('place_type', 'Hotels')
                ->first();
            if ($existingHotel) {
                session()->flash('error', 'Only one hotel can be added to the cart for the current trip.');
                return response()->json(['error' => 'Only one hotel can be added to the cart for the current trip.'], 400);
            }
        }

        //merge data for place
        $data = array_merge($validateData, ['trip_id' => $trip_id]);

        $cart = Place::create($data);

        if ($cart) {
            session()->flash('success', 'Place added to cart successfully!');

            if (session('searchType') == 'Hotels') {
                return redirect(route('trip.poi'))->with('success', 'Place added to cart successfully!');;
            } else {
                return response()->json(['success' => 'Place added to cart successfully!']);
            }
        } else {
            session()->flash('error', 'Place added to cart failed!');
            if (session('searchType') == 'Hotels') {
                return redirect(route('trip.poi'))->with('error', 'Place added to cart failed!');;
            } else {
                return response()->json(['error' => 'Place added to cart failed!'], 500);
            }
            
        }
    }

    public function index()
    {
        $userTrip = $this->getTripForUser();
        if (!$userTrip) {
            return redirect()->route('index')->with('error', 'Trip not found');
        }
        $userCart = $this->getUserCart($userTrip['trip_id']) ?? [];
        // check if cart empty
        if (!$userCart) {
            return redirect()->route('index')->with('error', 'Cart not found');
        }

        $poiTotal = 0.00;
        $grandTotal = 0;
        // Initialize as empty arrays
        $hotelsCart = [];
        $attractionsCart = [];
        // Separate hotels and attractions
        foreach ($userCart as $item) {
            if ($item['place_type'] === 'Hotels') {
                $hotelsCart = $item;
            } elseif ($item['place_type'] === 'Attractions') {
                $attractionsCart[] = $item;
                $poiTotal += $item['price'];
            }
            $grandTotal += $item['price'];
        }

        $poiTotal = number_format($poiTotal, 2, '.', '');
        $grandTotal = number_format($grandTotal, 2, '.', '');

        $updateTrip = Trip::findOrFail($userTrip['trip_id']);
        $updateTrip->update([
            'grand_total' => $grandTotal,
        ]);

        return view('user.cart', [
            'trip' => $userTrip,
            'poiTotal' => $poiTotal,
            'grandTotal' => $grandTotal,
            'hotelsCart' => $hotelsCart,
            'attractionsCart' => $attractionsCart
        ]);
    }

    public function getTripForUser()
    {
        $user_id = auth()->id(); // Get the authenticated user's ID
        $trip = Trip::where('user_id', $user_id)->first(); // Fetch the trip for the user

        if ($trip) {
            return $trip->toArray();
        } else {
            return [];
        }
    }

    public function getUserCart($trip_id)
    {
        $cart = Place::where('trip_id', $trip_id)->get();

        if ($cart) {
            return $cart->toArray();
        } else {
            return back()->with('error', 'Cart not found');
        }
    }

    public function deleteItem(Request $request)
    {
        $cart_id = $request->input('cart_id');
        Log::info('Attempting to delete item with cart_id: ' . $cart_id); // Add this line for logging

        $deleteItem = Place::where('cart_id', $cart_id)->first();

        if ($deleteItem) {
            $deleteItem->delete();
            Log::info('Item deleted successfully with cart_id: ' . $cart_id); // Add this line for logging
            return redirect()->back()->with('success', 'Item deleted successfully!');
        } else {
            Log::error('Delete item failed for cart_id: ' . $cart_id); // Add this line for logging
            return redirect()->back()->with('error', 'Delete item failed');
        }
    }
}
