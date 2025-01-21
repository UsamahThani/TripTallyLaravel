<?php

use App\Http\Controllers\Auth\GoogleAuthController;
use Illuminate\Support\Facades\Route;

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
});

// Google OAuth Routes
Route::controller(GoogleAuthController::class)->group(function () {
    Route::get('auth/google', 'redirect')->name('auth.google');
    Route::get('auth/google-callback', 'callback')->name('auth.google-callback');
});


// User Index Route
Route::get('/index', function () {
    return view('user/index');
})->middleware('auth')->name('index');

Route::get('/login', function () {
    return view('auth/login');
})->name('login');

?>