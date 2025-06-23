<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    { //where to redirect for 
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $email = $googleUser->getEmail();

            $user = User::where('email', $email)->first();
            if ($user) {
                $user->update([
                    'name' => $googleUser->getName(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                ]);
            } else {
                // create new user.
                $user = new User();
                $user->name = $googleUser->getName();
                $user->email = $googleUser->getEmail();
                $user->google_id = $googleUser->getId();
                $user->avatar = $googleUser->getAvatar();

                //required fields;
                $user->gender = 1; // male
                $user->role = 'user';
                $user->phone = Str::rand(1000000000,999999999);
                $user->password = Hash::make(Str::random(12));
                $user->save();
            }

            Auth::login($user); // make him login

            return redirect()->route('users.dashboard');
        } catch (\Exception $e) {
            Log::error('Error occred while sign-in with google.'.$e->getMessage());
            return redirect()->route('welcome')->with(['message' => 'Error occured while logging in '.$e->getMessage()]);
        }
    }
}
