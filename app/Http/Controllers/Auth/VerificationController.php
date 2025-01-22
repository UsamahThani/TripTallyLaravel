<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

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

        // Store google_id and avatar if available
        $user = $request->user();
        if ($user->google_id && $user->avatar) {
            $user->update([
                'google_id' => $user->google_id,
                'avatar' => $user->avatar,
            ]);
        }

        return redirect()->route('index');
    }

    /**
     * Resend the email verification notification.
     */
    public function resend(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('success', 'Email verification link sent!');
    }
}
