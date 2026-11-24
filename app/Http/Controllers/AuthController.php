<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan halaman login

    public function showlogin()
    {
        return view('auth.login');
    }

    // Memproses Login
    public function login(Request $request)
    {
        // Validasi data login
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // coba login menggunakan email dan password
        if (Auth::attempt($credentials)) {

            // Buat ulang session setelah berhasil login
            $request->session()->regenerate();

            return redirect('/tickets');
        }
        return back()->withEror([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}