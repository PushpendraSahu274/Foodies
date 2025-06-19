<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Otp\OtpGetRequest;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\Otp\OtpSentMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;
use App\Exceptions\AjaxException;



class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create()
    {
        return redirect()->route('welcome');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        if (Auth::user()->role == 'user')
            return redirect()->intended(route('users.dashboard', absolute: false));
        else
            return redirect()->intended(route('admins.dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function get_otp(OtpGetRequest $request)
    {
        try {
            $email = $request->email;
            $user = User::where("email", $email)->first();

            //generate a opt
            $otp = rand(100000, 999999);
            $user_otp = Otp::firstOrNew(['email' => $email]);
            $user_otp->user_id = $user->id;
            $user_otp->expires_at = now()->addMinute(5);
            $user_otp->otp = $otp;
            $user_otp->save();

            // now sent the otp to the user
            Mail::to($email)->send(new OtpSentMail($otp));

            return response()->json([
                'success' => true,
                'message' => 'Opt sent successfully',
                'data' => [
                    'email' => $email,
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => 'error',
                'message' => 'Error Occured! ' . $e->getMessage(),
            ], 500);
        }
    }

    public function verify_otp(OtpGetRequest $request)
    {
        try {
            $email = $request->email;
            $otp = $request->otp;

            //verify otp
            $otp = Otp::where('email', $email)->where('otp', $otp)->first();

            //check whether opt found or not
            if (!$otp) {
                throw new AjaxException('Invalid Opt', 422);
            }

            if ($otp->expires_at < now()) {
                throw new AjaxException('Otp Expired....');
            }

            //opt verified and not expired.
            $user = User::where('email', $request->email)->orWhere('id', $otp->user_id)->first();
            Auth::login($user);

            return response()->json([
                'success' => true,
                'message' => 'OTP verified — you are now logged in!',
                'redirect' => route($user->role === 'admin' ? 'admins.dashboard' : 'users.dashboard')
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => 'error',
                'message' => 'Error Occured! ' . $e->getMessage(),
            ], 500);
        }
    }
    
}
