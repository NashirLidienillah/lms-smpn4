@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Dashboard Administrator</h2>
            <p class="text-sm text-gray-500 mt-1">Pantau statistik dan kelola data utama LMS SMPN 4 Kota Serang.</p>
        </div>
        <div class="bg-white px-4 py-2 rounded-xl shadow-sm border border-gray-100 text-sm font-medium text-gray-600 w-full md:w-auto text-center">
            <i class="far fa-calendar-alt mr-2 text-blue-500"></i> {{ now()->translatedFormat('l, d F Y') }}
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
        
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4 transition hover:shadow-md">
            <div class="w-14 h-14 flex items-center justify-center rounded-xl bg-blue-50 text-blue-600 text-2xl shrink-0">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Total Siswa</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $totalSiswa }}</h3> 
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4 transition hover:shadow-md">
            <div class="w-14 h-14 flex items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 text-2xl shrink-0">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Total Guru</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $totalGuru }}</h3>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4 transition hover:shadow-md">
            <div class="w-14 h-14 flex items-center justify-center rounded-xl bg-purple-50 text-purple-600 text-2xl shrink-0">
                <i class="fas fa-school"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Total Kelas</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $totalKelas }}</h3>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4 transition hover:shadow-md">
            <div class="w-14 h-14 flex items-center justify-center rounded-xl bg-amber-50 text-amber-600 text-2xl shrink-0">
                <i class="fas fa-book"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Mata Pelajaran</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $totalMapel }}</h3>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 md:gap-6">
        
        <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100 lg:col-span-2 relative overflow-hidden">
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-blue-50 rounded-full opacity-50"></div>
            
            <h3 class="text-xl font-bold text-gray-800 mb-2 relative z-10">Selamat Datang di Portal Admin! 👋</h3>
            <p class="text-gray-600 leading-relaxed relative z-10 mb-6">
                Ini adalah pusat kendali untuk mengatur seluruh data Master di LMS SMPN 4 Kota Serang. Pastikan <span class="font-semibold text-blue-600">Tahun Akademik</span> yang aktif sudah sesuai sebelum guru dan siswa mulai menggunakan sistem ini.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-3 relative z-10">
                <a href="/admin/users" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-sm font-medium transition flex items-center justify-center gap-2">
                    <i class="fas fa-plus"></i> Tambah Pengguna
                </a>
                </div>
        </div>

        <div class="bg-gradient-to-br from-blue-700 to-blue-900 p-6 md:p-8 rounded-2xl shadow-sm text-white flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold">Info Akademik Aktif</h3>
                    <i class="fas fa-calendar-check text-3xl opacity-30"></i>
                </div>
                <p class="text-blue-100 text-sm mb-6">Pastikan pengaturan ini sudah sesuai sebelum KBM dimulai.</p>
                
                <div class="space-y-4">
                    @if($tahunAktif)
                        <div class="flex justify-between items-center border-b border-blue-500/50 pb-2">
                            <span class="text-sm text-blue-200">Tahun Ajaran</span>
                            <span class="font-bold text-sm">{{ $tahunAktif->nama_tahun }}</span>
                        </div>
                        <div class="flex justify-between items-center border-b border-blue-500/50 pb-2">
                            <span class="text-sm text-blue-200">Semester</span>
                            <span class="font-bold text-sm bg-white text-blue-800 px-2 py-0.5 rounded text-xs shadow-sm capitalize">{{ $tahunAktif->semester }}</span>
                        </div>
                    @else
                        <div class="bg-red-500/20 border border-red-500/50 p-3 rounded-lg">
                            <p class="text-xs text-red-200"><i class="fas fa-exclamation-triangle mr-1"></i> Belum ada Tahun Akademik yang diaktifkan!</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <a href="/admin/tahun-akademik" class="mt-6 text-sm text-center bg-white/10 hover:bg-white/20 border border-blue-400/30 py-2.5 rounded-xl transition flex items-center justify-center gap-2">
                <i class="fas fa-edit"></i> Atur Tahun Akademik
            </a>
        </div>

    </div>
</div>
@endsection