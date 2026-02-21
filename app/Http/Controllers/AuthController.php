<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function login(Request $request){
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:6', // bisa ditambah min:6 atau max:255 sesuai kebutuhan
    ]);

//     $user = \App\Models\User::where('email', $request->email)->first();
// dd($user);

    // $user = \App\Models\User::where('email', $request->email)->first();

// dd([
//     'input_password' => $request->password,
//     'hashed_password_db' => $user?->password,
//     'user_found' => $user ? true : false,
// ]);


    if (Auth::attempt($request->only('email', 'password'))){
        $request->session()->regenerate(); // ini buat regenerasi session setelah login, biar lebih aman

        $role = Auth::user()->role; // ini buat ngambil role user yang login

        if ($role === 'admin'){
            return redirect()->intended('/admin/dashboard');
        } elseif ($role === 'desainer'){
            return redirect()->intended('/desainer/dashboard/');
        }
        elseif($role ==="akuntan"){
            return redirect()->intended('/akuntan/dashboard/');
        }

        

        return redirect()->intended('/'); // ini buat redirect ke dashboard setelah login
    }
    return back()->withErrors([
        'email'=> 'Email atau password salah', // ini buat ngasih error message kalau login gagal
    ])->onlyInput('email'); // ini buat ngasih old value ke input email, biar gak usah ketik lagi


    // return 'Masuk controller login';
    // dd($request->all()); // ini buat ngecek data yang dikirim dari 
    // form login, nanti kita bakal ganti dengan logika buat ngecek username dan password di database
    // nanti kita bakal buat validasi login disini,
}
}
