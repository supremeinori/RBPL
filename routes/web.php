<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('home');
// });

// Route::get('/about', function () {
//     return view('about' , ['x' => "Saito" ] );
// });                          //passing data ke view dengan array, bisa juga dengan compact() atau with()

// Route::get('/blog', function () {
//     return view('blog');
// });

// Route::get('/contact', function () {
//     return view('contact');
// });

Route::get('/', function () {
    return view('login');
});

Route::get('/dashboard', function () {
    return view('Dashboard\admin');
});
