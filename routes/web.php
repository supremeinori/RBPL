<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\CustomerManagementController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\OrderManagementController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\DesainController;
use App\Http\Controllers\Desainer\DesainerDashboardController;
use App\Http\Controllers\Desainer\DesainerOrderController;
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


Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'] )
->middleware(['auth', 'role:admin'])
->name('admin.dashboard'); 




// ini untuk mastiin user yang bener udah login, 
// nanti kita bisa tambahin middleware 
// buat role admin, desainer, akuntan biar gak bisa diakses sama user yang bukan sesuai rolenya
// entah apa lah ini

Route::get('/desainer/dashboard', [DesainerDashboardController::class, 'index'])
    ->middleware(['auth', 'role:desainer'])
    ->name('desainer.dashboard');
Route::get('/desainer/orders/{id}', [DesainerOrderController::class, 'show'])
    ->middleware(['auth', 'role:desainer'])
    ->name('desainer.orders.show');
Route::post('/desainer/orders/{id}/upload', [DesainerOrderController::class, 'upload'])
    ->middleware(['auth', 'role:desainer'])
    ->name('desainer.orders.upload');



Route::get('/akuntan/dashboard', function () {
    return view('akuntan.dashboard.akuntan');
})->middleware(['auth', 'role:akuntan']);

Route::middleware(['auth', 'role:admin'])->prefix('admin')
->name('admin.')        
->group(function () {
    Route::get('customers/search', [CustomerManagementController::class, 'searchApi'])->name('customers.search');
    Route::resource('users', UserManagementController::class); 
    Route::resource('customers', CustomerManagementController::class);
    Route::resource('orders', OrderManagementController::class);
    Route::get('/admin/desain/create/{id}', [DesainController::class, 'create'])->name('desain.create');
    Route::post('/admin/desain/store/{id}', [DesainController::class, 'store'])->name('desain.store');
});


// LOGOUT
Route::post('/logout', function () {
    Auth::logout();

    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('login');
})->name('logout');


