<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showCustomerLoginForm()
    {
        return view('customer.login');
    }

    public function customerLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            // Use redirect()->intended() without a fallback to respect the stored intended URL
            return redirect()->intended();
        }
        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function showCustomerRegisterForm()
    {
        return view('customer.register');
    }

    public function customerRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('customer.login')->with('success', 'Registration successful. Please log in.');
    }

   public function customerLogout()
{
    Auth::logout();
   return redirect()->intended();
}
}
