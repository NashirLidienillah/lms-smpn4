<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\UserController;

// Halaman Login
Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Grouping Route berdasarkan Role
Route::middleware(['auth'])->group(function () {
    
    // Khusus Admin
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', function () { return view('admin.dashboard'); });
        Route::get('/admin/users', [UserController::class, 'index']);
        Route::get('/admin/users/create', [UserController::class, 'create']);
        Route::post('/admin/users', [UserController::class, 'store']);
        Route::get('/admin/users/{id}/edit', [UserController::class, 'edit']);
        Route::put('/admin/users/{id}', [UserController::class, 'update']);
        Route::delete('/admin/users/{id}', [UserController::class, 'destroy']);
    });

    // Khusus Guru
    Route::middleware('role:guru')->group(function () {
        Route::get('/guru/dashboard', function () { return view('guru.dashboard'); });
    });

    // Khusus Siswa
    Route::middleware('role:siswa')->group(function () {
        Route::get('/siswa/dashboard', function () { return view('siswa.dashboard'); });
    });

});
