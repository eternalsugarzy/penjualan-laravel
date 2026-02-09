<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin() {
        return view('auth.login');
    }

    public function login(Request $request) {
    $credentials = $request->validate([
        'username' => 'required',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        
        // AMBIL LEVEL USER
        $level = Auth::user()->level;

        if ($level === 'admin') {
            return redirect('/dashboard'); // Admin ke Dashboard
        } else {
            return redirect('/kasir'); // Kasir/Petugas langsung ke Mesin Kasir
        }
    }

    return back()->with('loginError', 'Username atau password salah!')->withInput();
}

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}