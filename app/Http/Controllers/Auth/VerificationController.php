<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class VerificationController extends Controller
{
    /**
     * Instantiate a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * Display the email verification notice.
     */
    public function notice(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
        ? redirect()->route('index') : view('auth.verify-email');
    }

    /**
     * User's email verification.
     */
    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();

        // should redirect to a page with saying account verified and have a button to redirect to login page
        return redirect()->route('login')->with('success', 'Your account have been verified. You can log in now.');
    }

    /**
     * Resend the email verification notification.
     */
    public function resend(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        // should redirect to login page
        return redirect('login')->with('success', 'Email verification link sent!');
        
    }
}
