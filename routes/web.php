<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\UserManagementController;
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
})->name('login'); // ini buat ngasih nama route, 
// biar gampang aksesnya, bisa juga pake url() atau route() di blade

Route::post('/', [AuthController::class, 'login'] );


Route::get('/admin/dashboard', function () {
    return view('admin.dashboard.admin');
})->middleware('auth'); // ini untuk mastiin user yang bener udah login, 
// nanti kita bisa tambahin middleware 
// buat role admin, desainer, akuntan biar gak bisa diakses sama user yang bukan sesuai rolenya
// entah apa lah ini
Route::get('/desainer/dashboard', function () {
    return view('desainer.dashboard.desainer');
})->middleware('auth');

Route::get('/akuntan/dashboard', function () {
    return view('akuntan.dashboard.akuntan');
})->middleware('auth');

Route::middleware(['auth', 'role:admin'])->prefix('admin')
->name('admin.')        
->group(function () {
    Route::resource('users', UserManagementController::class); 
    // ini buat ngasih resource route untuk user management, 
    // nanti kita bakal buat controller dan viewnya buat manage user, kayak tambah user, edit user, hapus user, dll
});
