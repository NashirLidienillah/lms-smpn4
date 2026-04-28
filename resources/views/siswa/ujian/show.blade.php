@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl shadow-md overflow-hidden border border-gray-200">
        <div class="bg-emerald-600 p-6 text-white text-center">
            <i class="fas fa-file-signature text-5xl mb-4"></i>
            <h1 class="text-2xl font-bold font-serif">{{ $ujian->judul }}</h1>
        </div>
        
        <div class="p-8">
            {{-- Alert Jika Sudah Mengerjakan (Pencegahan Visual) --}}
            @php
                $sudah = \App\Models\JawabanUjian::where('user_id', auth()->id())->where('ujian_id', $ujian->id)->exists();
            @endphp

            <div class="grid grid-cols-2 gap-6 mb-8">
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                    <p class="text-gray-500 text-xs uppercase font-bold mb-1">Durasi</p>
                    <p class="text-lg font-bold text-gray-800">{{ $ujian->durasi }} Menit</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                    <p class="text-gray-500 text-xs uppercase font-bold mb-1">Jumlah Soal</p>
                    <p class="text-lg font-bold text-gray-800">{{ $ujian->soals->count() }} Butir</p>
                </div>
            </div>

            <div class="bg-amber-50 border-l-4 border-amber-500 p-4 mb-8 text-amber-800">
                <h4 class="font-bold mb-1"><i class="fas fa-exclamation-triangle mr-2"></i> Peraturan Ujian:</h4>
                <ul class="text-sm list-disc ml-5 space-y-1">
                    <li>Jangan menyegarkan (refresh) halaman saat ujian berlangsung.</li>
                    <li>Waktu akan terus berjalan meskipun Anda menutup browser.</li>
                    <li>Pastikan koneksi internet stabil.</li>
                </ul>
            </div>

            <div class="flex flex-col space-y-3">
                @if($sudah)
                    <div class="bg-red-100 text-red-700 p-4 rounded-xl text-center font-bold">
                        <i class="fas fa-check-double mr-2"></i> Anda sudah mengerjakan ujian ini.
                    </div>
                    <a href="/siswa/dashboard" class="text-center text-blue-600 hover:underline text-sm font-medium">
                        Kembali ke Dashboard
                    </a>
                @else
                    {{-- Tombol diubah menjadi Link (a) agar bisa diklik menuju route kerjakan --}}
                    <a href="/siswa/ujian/{{ $ujian->id }}/kerjakan" 
                       class="w-full bg-emerald-600 hover:bg-emerald-700 text-white text-center font-bold py-4 rounded-xl transition shadow-lg text-lg">
                        MULAI KERJAKAN SEKARANG
                    </a>
                    
                    <a href="/siswa/dashboard" class="text-center text-gray-500 hover:text-gray-700 text-sm font-medium">
                        Nanti Saja, Kembali ke Dashboard
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection