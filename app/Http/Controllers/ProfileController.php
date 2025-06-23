<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\ProfileUpdateRequest;
use App\Models\Address;
use App\Models\User;
use App\Traits\UploadImageTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    use UploadImageTrait;
    /**
     * Display the user's profile form.
     */
    public function show(Request $request)
    {
        $user = Auth::user();
        $profile = User::find($user->id);
        if($user->role =='admin')
        return redirect()->back()->with(['profile' => $profile]);

        else{
            $addresses = Address::where('user_id',$user->id)->get();
            return view('user.profile.index',compact('profile','addresses'));
        }
        
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
    public function update(ProfileUpdateRequest $request)
    {
    
        $user_id = Auth::user()->id;
        $profile = User::find($user_id);
        $profile->name = $request->name ?? $profile->name;
        $profile->email = $request->email ?? $profile->email;
        $profile->phone = $request->phone ?? $profile->phone;
        $profile->alternate_phone = $request->alternate_phone ?? $profile->alternate_phone;
        $profile->gender = $request->gender ?? 1;
        $profile->description = $request->description ?? $profile->description;
        $image_url = '';
        if ($request->hasFile('photo')) {
            
            if ($profile->profile_path && $this->isCloudinaryResourceExists($profile->profile_path)) {
                $this->deleteResourceFromCloudinary($profile->profile_path);
            }
            $file = $request->file('photo');
            $image_url = $this->uploadToCloudinary($file, 'avatar');
            $profile->profile_path = $image_url;
        }
        if ($request->has('password')) {
            $profile->password = Hash::make($request->password);
        }
        $profile->save();
        // 19-06-2025_6854280c2740f.jpg
        $profile = [
            'id' => $profile->id,
            'profile' => $this->isCloudinaryResourceExists($profile->profile_path) ? $this->getCloudinaryResourceUrl($profile->profile_path) : null,
            'name' => $profile->name,
            'phone' => $profile->phone,
            'description' => $profile->about,
            'avatar' => $profile->avatar ? $profile->avatar : null,
        ];
        return response()->json([
            'success' => true,
            'message' => 'Profile Updated Successfully!',
            'data' => $profile,
        ], 200);
    }
    /**
     * Delete the user's account.
     */
    public function destroy(Request $request)
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
