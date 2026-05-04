<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\MapelController;
use App\Http\Controllers\Admin\RombelController;
use App\Http\Controllers\Admin\GuruMapelController;
use App\Http\Controllers\Admin\TahunAkademikController;

use App\Http\Controllers\Guru\DashboardController as GuruDashboard;
use App\Http\Controllers\Guru\MateriController;
use App\Http\Controllers\Guru\TugasController;
use App\Http\Controllers\Guru\UjianController;
use App\Http\Controllers\Guru\SoalController;

use App\Http\Controllers\Siswa\DashboardController as SiswaDashboard;
use App\Http\Controllers\Siswa\KelasController as SiswaKelas;
use App\Http\Controllers\Siswa\TugasController as SiswaTugas;
use App\Http\Controllers\Siswa\UjianController as SiswaUjian;

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
    Route::get('/guru/dashboard', [GuruDashboard::class, 'index']);
    // Rute Ruang Kelas & Materi
    Route::get('/guru/kelas/{id}', [MateriController::class, 'show']);
    Route::post('/guru/kelas/{id}/materi', [MateriController::class, 'store']);
    Route::get('/guru/materi/{id}/edit', [MateriController::class, 'edit']);
    Route::put('/guru/materi/{id}', [MateriController::class, 'update']);
    Route::delete('/guru/materi/{id}', [MateriController::class, 'destroy']);
    // Rute Tugas 
    Route::post('/guru/kelas/{id}/tugas', [TugasController::class, 'store']);
    Route::get('/guru/tugas/{id}/edit', [TugasController::class, 'edit']);
    Route::put('/guru/tugas/{id}', [TugasController::class, 'update']);
    Route::delete('/guru/tugas/{id}', [TugasController::class, 'destroy']);
    // Rute Koreksi Tugas & Simpan Nilai
    Route::get('/guru/tugas/{id}/koreksi', [TugasController::class, 'koreksi']);
    Route::post('/guru/tugas/nilai/{pengumpulan_id}', [TugasController::class, 'simpanNilai']);
    // Rute Ujian CBT
    Route::post('/guru/kelas/{id}/ujian', [UjianController::class, 'store']);
    Route::get('/guru/ujian/{id}/edit', [UjianController::class, 'edit']);
    Route::put('/guru/ujian/{id}', [UjianController::class, 'update']);
    Route::delete('/guru/ujian/{id}', [UjianController::class, 'destroy']);
    // ini rute publish soal cbt
    Route::patch('/guru/ujian/{id}/publish', [\App\Http\Controllers\Guru\UjianController::class, 'togglePublish']);
    // Rute Kelola Soal CBT
    Route::get('/guru/ujian/{id}', [UjianController::class, 'show']);
    Route::post('/guru/ujian/{id}/soal', [SoalController::class, 'store']);
    Route::get('/guru/soal/{id}/edit', [SoalController::class, 'edit']);
    Route::put('/guru/soal/{id}', [SoalController::class, 'update']);
    Route::delete('/guru/soal/{id}', [SoalController::class, 'destroy']);
    // Rute rekap nilai
    Route::get('/guru/ujian/{id}/rekap', [UjianController::class, 'rekapNilai']);
    
    });

    // Khusus Siswa
    Route::middleware('role:siswa')->group(function () {
    Route::get('/siswa/dashboard', [SiswaDashboard::class, 'index']);
    Route::get('/siswa/kelas/{id}', [SiswaKelas::class, 'show']);
    Route::get('/siswa/tugas/{id}', [SiswaTugas::class, 'show']);
    Route::post('/siswa/tugas/{id}/kumpul', [SiswaTugas::class, 'kumpulTugas']);
    Route::get('/siswa/ujian/{id}', [SiswaUjian::class, 'show']);
    Route::get('/siswa/ujian/{id}/kerjakan', [SiswaUjian::class, 'kerjakan']);
    Route::post('/siswa/ujian/{id}/simpan', [SiswaUjian::class, 'simpanJawaban']);
    Route::get('/siswa/ujian/{id}/hasil', [SiswaUjian::class, 'hasil']);
    });

});
