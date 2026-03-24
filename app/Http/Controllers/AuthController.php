<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // login dashboard
    public function showLogin()
    {
        return view('auth.login');
    }

    // proceessing login
    public function login(Request $request)
    {
        // Validation inputs
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // checking data in database
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            //tier login auth
            if (Auth::user()->role === 'admin') {
               
                return redirect()->route('admin.dashboard');
            } 
            
            
            return redirect()->route('parking.index');
        }

        // email/password auth errors
        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    // Proses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}