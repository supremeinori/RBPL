<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal 6 karakter.',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();

            $role = Auth::user()->role;

            return match ($role) {
                'superadmin' => redirect()->intended('/admin/dashboard'),
                'admin'      => redirect()->intended('/admin/dashboard'),
                'desainer'   => redirect()->intended('/desainer/dashboard'),
                'akuntan'    => redirect()->intended('/akuntan/dashboard'),
                default      => redirect()->intended('/'),
            };
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }
}
