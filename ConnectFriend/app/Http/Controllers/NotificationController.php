<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Wishlist;
use App\Models\Chat;

class NotificationController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $friendRequests = Wishlist::where('wishlist_user_id', $userId)
            ->whereDoesntHave('reverseWishlist', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->with('user')
            ->get();

        $unreadMessages = Chat::where('receiver_id', $userId)
            ->where('read', false) 
            ->with('sender')
            ->latest('created_at')
            ->get();

        return view('notification', compact('friendRequests', 'unreadMessages'));
    }

        public function notifications()
    {
        $friendRequests = Wishlist::where('wishlist_user_id', Auth::id())->get();

        return view('notification', compact('friendRequests'));
    }
    public function getNotificationsCount()
    {
        $authUserId = Auth::id();
    
        // Count friend requests
        $friendRequestsCount = Wishlist::where('wishlist_user_id', $authUserId)
            ->whereDoesntHave('reverseWishlist', function ($query) use ($authUserId) {
                $query->where('user_id', $authUserId);
            })
            ->count();
    
        $unreadMessagesCount = Chat::where('receiver_id', $authUserId)
            ->where('read', false)
            ->count();
    
        // Total notification count
        $totalCount = $friendRequestsCount + $unreadMessagesCount;
    
        return response()->json(['count' => $totalCount]);
    }
    // public function getNotificationsCount()
    // {
    //     $unreadMessagesCount = Chat::where('receiver_id', Auth::id())
    //         ->where('read', false)
    //         ->count();
    //     $friendRequestsCount = Wishlist::where('wishlist_user_id', Auth::id())
    //         ->whereDoesntHave('reverseWishlist', function ($query) {
    //             $query->where('user_id', Auth::id());
    //         })
    //         ->count();

    //     $totalCount = $unreadMessagesCount + $friendRequestsCount;

    //     return response()->json(['count' => $totalCount]);
    // }

    public function unreadMessages()
    {
        $unreadMessages = Chat::where('receiver_id', Auth::id())
            ->where('read', false)
            ->with('sender') // Eager load sender details
            ->get();

        return view('notification', compact('unreadMessages'));
    }


}
