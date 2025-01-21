<?php

use App\Http\Controllers\Auth\AuthController;
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
        return redirect('/');
    })->name('logout');
});


// User Index Route
Route::get('/index', function () {
    return view('user/index');
})->middleware('auth')->name('index');



?>