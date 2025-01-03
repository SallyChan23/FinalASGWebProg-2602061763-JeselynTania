<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    // Show the login form
    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('home');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
            'password' => 'Wrong Password',
        ]);
    }

    // Show the registration form
    public function showRegisterForm()
    {
        $registration_fee = rand(100000, 125000); // Generate random registration fee
        return view('auth.register', compact('registration_fee'));
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:user',
            'password' => 'required|string|min:6|confirmed',
            'gender' => 'required|in:Male,Female',
            'field_of_work' => 'required|array|min:3',
            'field_of_work.*' => 'required|string',
            'profession' => 'required|in:Creative,Developer,Manager,Marketing,Designer',
            'linkedin_username' => 'required|url|regex:/https:\/\/www.linkedin.com\/in\/[a-zA-Z0-9-]+/',
            'mobile_number' => 'required|regex:/^\+62[0-9]{9,12}$/',
            'registration_fee' => 'required|integer',
        ]);

        try {
            User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'gender' => $validatedData['gender'],
                'field_of_work' => json_encode($validatedData['field_of_work']),
                'linkedin_username' => $validatedData['linkedin_username'],
                'mobile_number' => $validatedData['mobile_number'],
                'registration_fee' => $validatedData['registration_fee'],
                'profession' => $validatedData['profession'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            session(['registration_fee' => $validatedData['registration_fee']]);

            return redirect()->route('payment')->with('message', 'Registration successful! Proceed to payment.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    
    public function payment()
    {
        $registration_fee = session('registration_fee', null);

        if (is_null($registration_fee)) {
            return redirect()->route('register')->with('message', 'You must register first.');
        }

        return view('payment', compact('registration_fee'));
    }

    public function processPayment(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);
    
        $amount = $request->input('amount');
        $registration_fee = session('registration_fee', 0);
    
        if ($amount < $registration_fee) {
            $underpaid = $registration_fee - $amount;
            return back()->with('message', "You are still underpaid by $underpaid.");
        } elseif ($amount > $registration_fee) {
            $overpaid = $amount - $registration_fee;
            session()->put('overpaid_amount', $overpaid);
            return redirect()->route('payment.confirmation')->with('message', "You overpaid by $overpaid. Would you like to add it to your wallet balance?");
        }
    
        // Payment successful
        return redirect()->route('home')->with('message', 'Payment successful!');
    }

    public function showPaymentConfirmation()
    {
        return view('payment_confirmation');
    }

    public function confirmPayment(Request $request)
    {
        $action = $request->input('action');
        $overpaidAmount = session('overpaid_amount', 0);

        if ($action === 'yes') {
            // Simulate adding the overpaid amount to the user's wallet balance
            // (This assumes a Wallet or User model update)
            session()->forget('overpaid_amount');
            return redirect()->route('home')->with('message', 'Overpaid amount added to your wallet balance.');
        } elseif ($action === 'no') {
            session()->forget('overpaid_amount');
            return redirect()->route('payment')->with('message', 'Please re-enter the correct payment amount.');
        }

        return redirect()->route('home')->with('error', 'Invalid action.');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        return redirect()->route('login');
    }
}