<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    
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

    public function showProfile()
    {
        $authUser = Auth::user();
    
        // Ambil daftar teman mutual
        $mutualFriends = User::whereIn('id', function ($query) use ($authUser) {
            $query->select('wishlist_user_id')
                ->from('wishlists')
                ->where('user_id', $authUser->id)
                ->whereIn('wishlist_user_id', function ($subQuery) use ($authUser) {
                    $subQuery->select('user_id')
                        ->from('wishlists')
                        ->where('wishlist_user_id', $authUser->id);
                });
        })->get();
    
        return view('profile', compact('authUser', 'mutualFriends'));
    }
    
    public function removeFriend($friendId)
    {

        Log::info('Remove friend called with ID: ' . $friendId);
        $authUserId = Auth::id();

        Wishlist::where('user_id', $authUserId)->where('wishlist_user_id', $friendId)->delete();
        Wishlist::where('user_id', $friendId)->where('wishlist_user_id', $authUserId)->delete();
    
        return redirect()->route('profile')->with('message', 'Friend removed successfully.');
    }
}
