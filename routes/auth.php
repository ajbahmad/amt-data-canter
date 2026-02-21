
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::middleware(['guest'])->group(function () {
    // Route untuk menampilkan form login
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    // Route untuk proses login
    Route::post('/login', [AuthController::class, 'login']);
    // Route untuk menampilkan form registrasi
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    // Route untuk proses registrasi
    Route::post('/register', [AuthController::class, 'register']);
    // Route untuk menampilkan form lupa password
    Route::get('/password/reset', [AuthController::class, 'showResetForm'])->name('password.request');
    // Route untuk proses reset password
    Route::post('/password/email', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
    // Route untuk menampilkan form ganti password
    Route::get('/password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
    // Route untuk proses ganti password
    Route::post('/password/reset', [AuthController::class, 'reset'])->name('password.update');
});

// Route untuk logout (harus bisa diakses user yang sudah login)
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
