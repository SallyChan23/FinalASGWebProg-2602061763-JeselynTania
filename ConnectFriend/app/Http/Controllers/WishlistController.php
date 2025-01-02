<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Wishlist;

class WishlistController extends Controller
{
    public function addToWishlist(Request $request)
    {
        $user = Auth::user();
        $wishlistUserId = $request->input('wishlist_user_id');

        if ($wishlistUserId && $wishlistUserId != $user->id) {
            DB::table('wishlists')->insert([
                'user_id' => $user->id,
                'wishlist_user_id' => $wishlistUserId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            return back()->with('success', 'User added to wishlist.');
        }

        return back()->with('error', 'Invalid user.');
    }

    public function showWishlist()
    {
        $user = Auth::user();
        $wishlists = DB::table('wishlists')
            ->join('user', 'wishlists.wishlist_user_id', '=', 'user.id')
            ->where('wishlists.user_id', $user->id)
            ->get(['user.name', 'user.profile_picture', 'user.profession', 'user.field_of_work']);

        return view('wishlist', compact('wishlists'));
    }

    public function checkMutual(Request $request)
    {
        $mutualUsers = Wishlist::where('user_id', Auth::id())
            ->whereHas('reverseWishlist', function ($query) {
                $query->where('friend_id', Auth::id());
            })
            ->get();

        return view('mutual-friends', compact('mutualUsers'));
    }

    
    public function acceptRequest($id)
    {
        $user = Auth::user();
    
        // Cek apakah ada permintaan teman dari User 1 ke User 2
        $incomingRequest = Wishlist::where('user_id', $id)
            ->where('wishlist_user_id', $user->id)
            ->first();
    
        if ($incomingRequest) {
            // Buat koneksi dua arah
            Wishlist::updateOrCreate(
                ['user_id' => $user->id, 'wishlist_user_id' => $id],
                ['created_at' => now(), 'updated_at' => now()]
            );
    
            Wishlist::updateOrCreate(
                ['user_id' => $id, 'wishlist_user_id' => $user->id],
                ['created_at' => now(), 'updated_at' => now()]
            );
    
            // Hapus permintaan teman asli
            $incomingRequest->delete();
    
            return redirect()->route('notifications')->with('success', 'Friend request accepted.');
        }
    
        return redirect()->route('notifications')->with('error', 'Friend request not found.');
    }

    // public function acceptRequest($id)
    // {
    //     $user = Auth::user();
    
    //     // Check if a request exists from the given user
    //     $incomingRequest = Wishlist::where('user_id', $id)
    //         ->where('wishlist_user_id', $user->id)
    //         ->first();
    
    //     if ($incomingRequest) {
    //         // Add the reciprocal connection
    //         Wishlist::updateOrCreate(
    //             ['user_id' => $user->id, 'wishlist_user_id' => $id],
    //             ['created_at' => now(), 'updated_at' => now()]
    //         );
    
    //         // Remove the original friend request
    //         $incomingRequest->delete();
    
    //         // Redirect with success message
    //         return redirect()->route('notifications')->with('success', 'Friend request accepted.');
    //     }
    
    //     return redirect()->route('notifications')->with('error', 'Friend request not found.');
    // }
}
