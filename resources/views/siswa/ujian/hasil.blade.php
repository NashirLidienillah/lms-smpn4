@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto text-center">
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
        <div class="p-8 bg-gradient-to-b from-blue-50 to-white">
            <div class="w-24 h-24 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner">
                <i class="fas fa-check-double text-4xl"></i>
            </div>
            
            <h1 class="text-3xl font-extrabold text-gray-800 mb-2">Ujian Selesai!</h1>
            <p class="text-gray-500 mb-8">Terima kasih telah mengerjakan <strong>{{ $ujian->judul }}</strong> dengan jujur bray.</p>

            {{-- INCLUDE RINCIAN SKOR --}}
            @include('siswa.ujian.components._hasil_score')

            <div class="flex flex-col space-y-3">
                <a href="/siswa/dashboard" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-2xl transition shadow-lg shadow-blue-200">
                    Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
</div>
@endsection