<?php

namespace App\Http\Controllers\Auth;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Throwable;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use AiFaiz\Malaysia\MyStates;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{

    /**
     * Show the index.
     */
    public function index() {
        $state = MyStates::getStates();
        
        return view('user/index', ['states' => $state]);
    }

    /**
     * Redirect the user to Google’s OAuth page.
     */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle the callback from Google.
     */
    public function callback()
    {
        try {
            // Get the user information from Google
            $user = Socialite::driver('google')->user();
        } catch (Throwable $e) {
            return redirect('/')->with('error', 'Google authentication failed.');
        }

        // Check if the user already exists in the database
        $existingUser = User::where('email', $user->email)->first();

        if ($existingUser) {
            $existingUser->update([
                'google_id' => $user->id,
                'avatar' => $user->avatar
            ]);
            // Log the user in if they already exist
            Auth::login($existingUser);
        } else {
            // Otherwise, create a new user and log them in
            $newUser = User::updateOrCreate([
                'email' => $user->email
            ], [
                'name' => $user->name,
                'password' => Hash::make(Str::random(16)), // Set a random password
                'email_verified_at' => now(),
                'avatar' => $user->avatar,
                'google_id' => $user->id
            ]);
            Auth::login($newUser);
        }
        // set session
        request()->session()->put('username', Auth::user()->name);
        request()->session()->put('userID', Auth::user()->id);

        // Redirect the user to the dashboard or any other secure page
        return redirect('/index');
    }

    /**
     * Handle the registration request.
     */
    public function register(Request $request)
    {
        // Handle the registration request here
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8'
        ]);

        $user = $this->create($request->all());

        event(new Registered($user));

        $credentials = $request->only('email', 'password');
        Auth::attempt($credentials);
        $request->session()->regenerate();
        return redirect()->route('verification.notice');

    }

    /**
     * Create a new user instance after a valid registration.
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
    }

    /**
     * Handle the login request.
     */
    public function login(Request $request)
    {
        // Handle the login request here
        $this->validate($request, [
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();
            $request->session()->put('username', Auth::user()->name);
            $request->session()->put('userID', Auth::user()->id);
            
            return redirect('/index');
        }

        return redirect('/login')->with('error', 'Invalid login credentials.');
    }

    /**
     * Handle the logout request.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
