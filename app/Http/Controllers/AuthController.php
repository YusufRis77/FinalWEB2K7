<?php

namespace App\Http\Controllers;

use App\Models\User; // Import Model User
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Untuk otentikasi
use Illuminate\Support\Facades\Hash; // Untuk hashing password
use Illuminate\Validation\ValidationException; // Untuk validasi

class AuthController extends Controller
{
    // Menampilkan form registrasi anggota
    public function showRegisterForm()
    {
        return view('auth.register'); // View: resources/views/auth/register.blade.php
    }

    // Memproses registrasi anggota baru
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone_number' => 'nullable|string|max:20',
            'member_id' => 'nullable|string|unique:users|max:255',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'member_id' => $request->member_id,
            'role' => 'member', // Otomatis set role sebagai 'member'
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    // Menampilkan form login
    public function showLoginForm()
    {
        return view('auth.login'); // View: resources/views/auth/login.blade.php
    }

    // Memproses login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            // Cek role user dan arahkan sesuai dashboard
            if (Auth::user()->role === 'admin') {
                return redirect()->intended(route('admin.dashboard')); // Akan kita buat nanti
            } else {
                return redirect()->intended(route('books.index')); // Halaman daftar buku untuk member
            }
        }

        // Jika login gagal
        throw ValidationException::withMessages([
            'email' => ['Email atau password salah.'],
        ]);
    }

    // Memproses logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}