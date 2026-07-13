@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    
    {{-- HERO HEADER UTAMA --}}
    <div class="relative overflow-hidden bg-gradient-to-br from-emerald-600 to-teal-800 rounded-[2.5rem] p-8 md:p-12 text-white shadow-2xl">
        <div class="absolute -right-10 -top-10 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute left-1/4 bottom-0 w-32 h-32 bg-emerald-400/20 rounded-full blur-2xl"></div>

        <div class="relative z-10 flex flex-col items-center text-center">
            <div class="w-20 h-20 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center mb-6 border border-white/30 shadow-inner">
                <i class="fas fa-file-signature text-4xl text-white"></i>
            </div>
            <span class="bg-white/20 backdrop-blur-md text-[10px] font-black px-4 py-1.5 rounded-full uppercase tracking-[0.2em] border border-white/30 mb-4">
                Computer Based Test
            </span>
            <h1 class="text-3xl md:text-5xl font-black tracking-tight leading-tight">{{ $ujian->judul }}</h1>
        </div>
    </div>

    @php
        $hasil = \App\Models\HasilUjian::where('siswa_id', auth()->id())->where('ujian_id', $ujian->id)->first();
        $isSelesai = $hasil && in_array($hasil->status, ['selesai', 'diblokir']);
        $isMengerjakan = $hasil && $hasil->status === 'mengerjakan';
    @endphp

    {{-- KONDISIONAL INCLUDE KOMPONEN --}}
    @if($isSelesai)
        @include('siswa.ujian.components._show_laporan')
    @else
        @include('siswa.ujian.components._show_ready')
    @endif

</div>
@endsection