<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\MapelController;
use App\Http\Controllers\Admin\RombelController;
use App\Http\Controllers\Admin\GuruMapelController;
use App\Http\Controllers\Admin\TahunAkademikController;

// Halaman Login
Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Grouping Route berdasarkan Role
Route::middleware(['auth'])->group(function () {
    
    // Khusus Admin
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', function () { return view('admin.dashboard'); });
        // route buat kelola user
        Route::get('/admin/users', [UserController::class, 'index']);
        Route::get('/admin/users/create', [UserController::class, 'create']);
        Route::post('/admin/users', [UserController::class, 'store']);
        Route::get('/admin/users/{id}/edit', [UserController::class, 'edit']);
        Route::put('/admin/users/{id}', [UserController::class, 'update']);
        Route::delete('/admin/users/{id}', [UserController::class, 'destroy']);
        // route buat data kelas
        Route::get('/admin/kelas', [KelasController::class, 'index']);
        Route::post('/admin/kelas', [KelasController::class, 'store']);
        Route::delete('/admin/kelas/{id}', [KelasController::class, 'destroy']);
        // route buat data mapel
        Route::get('/admin/mapel', [MapelController::class, 'index']);
        Route::post('/admin/mapel', [MapelController::class, 'store']);
        Route::delete('/admin/mapel/{id}', [MapelController::class, 'destroy']);
        // Manajemen Rombongan Belajar (Rombel)
        Route::get('/admin/rombel', [RombelController::class, 'index']);
        Route::post('/admin/rombel/add', [RombelController::class, 'addStudent']);
        Route::post('/admin/rombel/remove/{id}', [RombelController::class, 'removeStudent']);
        // Data Guru Mapel
        Route::get('/admin/guru-mapel', [GuruMapelController::class, 'index']);
        Route::post('/admin/guru-mapel', [GuruMapelController::class, 'store']);
        Route::delete('/admin/guru-mapel/{id}', [GuruMapelController::class, 'destroy']);
        // Tahun akademik
        Route::get('/admin/tahun-akademik', [TahunAkademikController::class, 'index']);
        Route::post('/admin/tahun-akademik', [TahunAkademikController::class, 'store']);
        Route::patch('/admin/tahun-akademik/{id}/aktif', [TahunAkademikController::class, 'setAktif']);
        Route::delete('/admin/tahun-akademik/{id}', [TahunAkademikController::class, 'destroy']);
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
