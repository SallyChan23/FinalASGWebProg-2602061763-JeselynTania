<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Wishlist;

class HomeController extends Controller
{

    public function index(Request $request)
    {

        $authUserId = Auth::id();
        $search = $request->input('search');
        $gender = $request->input('gender');
    
        $users = User::where('id', '!=', $authUserId)
            ->when($search, function ($query, $search) {
                $query->whereRaw('LOWER(field_of_work) LIKE ?', ['%' . strtolower($search) . '%']);
            })
            ->when($gender, function ($query, $gender) {
                $query->where('gender', '=', $gender);
            })
            ->get();
    
        // foreach ($users as $user) {
        //     $user->isMutual = Wishlist::where('user_id', $authUserId)
        //         ->where('wishlist_user_id', $user->id)
        //         ->exists() &&
        //         Wishlist::where('user_id', $user->id)
        //         ->where('wishlist_user_id', $authUserId)
        //         ->exists();
        // }

        // foreach ($users as $user) {
        //     $user->isMutual = Wishlist::where('user_id', $authUserId)
        //         ->where('wishlist_user_id', $user->id)
        //         ->exists() &&
        //         Wishlist::where('user_id', $user->id)
        //         ->where('wishlist_user_id', $authUserId)
        //         ->exists();
        
        //     $user->isFollowing = Wishlist::where('user_id', $authUserId)
        //         ->where('wishlist_user_id', $user->id)
        //         ->exists() && !$user->isMutual; 
        // }

        foreach ($users as $user) {
            // Periksa apakah hubungan sudah mutual
            $isMutual = Wishlist::where('user_id', $authUserId)
                ->where('wishlist_user_id', $user->id)
                ->exists() &&
                Wishlist::where('user_id', $user->id)
                ->where('wishlist_user_id', $authUserId)
                ->exists();
        
            // Tentukan status user
            $user->isMutual = $isMutual;
            $user->isFollowing = !$isMutual && Wishlist::where('user_id', $authUserId)
                ->where('wishlist_user_id', $user->id)
                ->exists();
        }
    
        return view('home', compact('users', 'search', 'gender'));
    }

    public function searchByFieldOfWork(Request $request)
    {
        $search = $request->input('search');

        $users = User::select('id', 'name', 'profile_picture', 'profession', 'field_of_work')
                    ->where('field_of_work', 'LIKE', '%' . $search . '%')
                    ->get();

        return view('search.result', compact('users', 'search'));
    }

    public function filterByGender()
    {
        $users = User::select('id', 'name', 'gender', 'profile_picture', 'profession', 'field_of_work')->get();

        return view('filter.gender', compact('users'));
    }

}
