<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\ProfileUpdateRequest;
use App\Models\User;
use App\Traits\UploadImageTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    use UploadImageTrait;
    /**
     * Display the user's profile form.
     */
    public function show(Request $request){
        $user_id = Auth::user()->id;
        $profile = User::find($user_id);
        return redirect()->back()->with(['profile'=>$profile]);
    }

    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request){
        $user_id = Auth::user()->id;
        $profile = User::find($user_id); 
        $profile->name = $request->name ?? $profile->name;
        $profile->email = $request->email ?? $profile->email;
        $profile->phone = $request->phone ?? $profile->phone;
        $profile->alternate_phone = $request->alternate_phone ?? $profile->alternate_phone;
        $profile->gender = $request->gender ?? 1;
        $profile->description = $request->description ?? $profile->description;
        if($request->hasFile('photo')){
            if($profile->profile_path){
                unlink($profile->profile_path);
            }
            $file = $request->file('photo');
            $image_url = $this->UploadImage($file, 'avatar');
            $profile->profile_path = $image_url;   
        }
        if($request->has('password')){
            $profile->password = bcrypt($request->password);
        }
        $profile->save();
        return response()->json([
            'success' => true,
            'message' => 'Profile Updated Successfully!',
            'data' => $profile,
        ],200);
    }
    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);
        $user = $request->user();
        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return Redirect::to('/');
    }
}
