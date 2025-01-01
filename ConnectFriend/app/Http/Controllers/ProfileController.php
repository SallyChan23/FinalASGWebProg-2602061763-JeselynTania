<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    //
    public function showProfile()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('profile_picture')) {
            // Retrieve the file
            $file = $request->file('profile_picture');
            $filename = time() . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('uploads/profile_pictures'), $filename);

            // Save to the user's profile
            $user = Auth::user();
            $user->profile_picture = $filename;
            $user->save();

            if ($user->wasChanged('profile_picture')) {
                return back()->with('success', 'Profile updated successfully.');
            } else {
                return back()->with('error', 'Profile picture update failed.');
            }
        }

        return back()->with('error', 'No file selected or invalid file.');
    }
}
