<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\CartController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\User\TripController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// landing page
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Google OAuth and login Routes
Route::controller(AuthController::class)->group(function () {
    // Google OAuth routes
    Route::get('auth/google', 'redirect')->name('auth.google');
    Route::get('auth/google-callback', 'callback')->name('auth.google-callback');

    // login route
    Route::get('/login', function () {
        return view('auth/login');
    })->name('getLogin');

    Route::post('/login', 'login')->name('login');

    // register route
    Route::get('/register', function () {
        return view('auth/register');
    })->name('getRegister');

    Route::post('/register', 'register')->name('register');

    // logout route
    Route::get('/logout', function () {
        Auth::logout();
        session()->flush();
        return redirect('/');
    })->name('logout');

    // User Index Route
    Route::get('/index', 'index')->middleware('auth')->name('index');
});

// Email Verification Routes
Route::controller(VerificationController::class)->group(function () {
    // email verification route
    Route::get('/email/verify', 'notice')->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', 'verify')->name('verification.verify');
    Route::post('/email/resend', 'resend')->name('verification.resend');
});

// Trip Finder Route
Route::controller(TripController::class)->group(function () {
    // trip finder route
    Route::post('/trip/place', 'searchPlace')->name('trip.place');

    // search place function route
    Route::get('/search/place', 'fetchPlaceData')->name('search.place');

    // trip hotel view route
    Route::get('/trip/place/hotel', function () {
        session(['searchType' => 'Hotels']);
        return redirect()->route('search.place');
    })->name('trip.hotel');

    // trip place view route
    Route::get('/trip/place/poi', function () {
        session(['searchType' => 'Attractions']);
        return redirect()->route('search.place');
    })->name('trip.poi');

})->middleware('auth');

// Cart Route
Route::controller(CartController::class)->group(function () {
    // cart view route
    Route::get('/trip/cart/index', 'index')->name('cart.index');

    // add to cart route
    Route::post('/trip/cart/create', 'create')->name('cart.create');

    // delete cart item route
    Route::post('/trip/cart/delete', 'deleteItem')->name('cart.delete');
});

// Error Route
Route::get('/error', function () {
    return view('error.fail');
})->middleware('auth');

Route::get('/session-data', function () {
    return response()->json(session()->all());
});
?>