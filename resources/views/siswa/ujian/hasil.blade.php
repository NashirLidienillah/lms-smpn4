@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto text-center">
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
        <div class="p-8 bg-gradient-to-b from-blue-50 to-white">
            <div class="w-24 h-24 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner">
                <i class="fas fa-check-double text-4xl"></i>
            </div>
            
            <h1 class="text-3xl font-extrabold text-gray-800 mb-2">Ujian Selesai!</h1>
            <p class="text-gray-500 mb-8">Terima kasih telah mengerjakan <strong>{{ $ujian->judul }}</strong> dengan jujur.</p>

            <div class="grid grid-cols-3 gap-4 mb-10">
                <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
                    <p class="text-xs text-gray-400 uppercase font-bold mb-1">Benar</p>
                    <p class="text-2xl font-black text-emerald-600">{{ $jawabanBenar }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
                    <p class="text-xs text-gray-400 uppercase font-bold mb-1">Salah</p>
                    <p class="text-2xl font-black text-red-500">{{ $totalSoal - $jawabanBenar }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
                    <p class="text-xs text-gray-400 uppercase font-bold mb-1">Total Soal</p>
                    <p class="text-2xl font-black text-blue-600">{{ $totalSoal }}</p>
                </div>
            </div>

            <div class="mb-10">
                <p class="text-sm text-gray-400 mb-1 font-bold uppercase tracking-widest">Skor Akhir</p>
                <div class="text-7xl font-black text-blue-800">{{ $nilai }}</div>
            </div>

            <div class="flex flex-col space-y-3">
                <a href="/siswa/dashboard" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-2xl transition shadow-lg shadow-blue-200">
                    Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
</div>
@endsection