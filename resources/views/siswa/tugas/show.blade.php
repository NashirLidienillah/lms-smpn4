@extends('layouts.app')

@section('content')

<div class="space-y-6">
    {{-- 1. ACTION BAR / TOMBOL KEMBALI KELAS --}}
    <div class="flex items-center justify-between">
        <a href="/siswa/kelas/{{ $tugas->guru_mapel_id }}" class="group inline-flex items-center text-sm font-bold text-gray-400 hover:text-purple-600 transition">
            <div class="w-8 h-8 rounded-lg bg-gray-100 group-hover:bg-purple-50 flex items-center justify-center mr-3 transition">
                <i class="fas fa-arrow-left text-xs"></i>
            </div>
            Kembali ke Ruang Kelas
        </a>
    </div>

    {{-- GRID TATA LETAK UTAMA --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- 2. PANEL KIRI: KOMPONEN INSTRUKSI DETAIL SOAL --}}
        @include('siswa.tugas.components._detail_tugas')

        {{-- 3. PANEL KANAN: KOMPONEN VALIDASI STATUS PENGUMPULAN JAWABAN --}}
        @include('siswa.tugas.components._status_tugas')
        
    </div>
</div>

@endsection