<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Wishlist;

class HomeController extends Controller
{
    public function index()
    {
        $authUserId = Auth::id();
        $users = User::where('id', '!=', $authUserId)->get();

        foreach ($users as $user) {
            // Check if both users have mutual friendship
            $user->isMutual = Wishlist::where('user_id', $authUserId)
                ->where('wishlist_user_id', $user->id)
                ->exists() &&
                Wishlist::where('user_id', $user->id)
                ->where('wishlist_user_id', $authUserId)
                ->exists();
        }

        return view('home', compact('users'));
        // $authUserId = Auth::id();
        // $users = User::where('id', '!=', $authUserId)->get();

        // foreach ($users as $user) {
        //     $user->isMutual = Wishlist::where('user_id', $authUserId)
        //         ->where('wishlist_user_id', $user->id)
        //         ->exists() &&
        //         Wishlist::where('user_id', $user->id)
        //         ->where('wishlist_user_id', $authUserId)
        //         ->exists();
        // }

        // return view('home', compact('users'));
    }
}
