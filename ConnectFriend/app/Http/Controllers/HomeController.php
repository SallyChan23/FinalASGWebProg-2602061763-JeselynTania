<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $currentUserId = Auth::id();

        // Fetch all users except the authenticated user
        $users = User::where('id', '!=', $currentUserId)->get();
    
        return view('home', compact('users'));
    }
}
