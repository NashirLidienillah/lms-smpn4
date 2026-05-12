@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    
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
    @endphp

    @if($hasil)
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-8 md:p-12 text-center relative overflow-hidden">
            <div class="absolute top-0 right-0 p-10 opacity-5">
                <i class="fas fa-award text-9xl text-emerald-600"></i>
            </div>

            <h3 class="text-xl font-black text-gray-800 uppercase tracking-widest mb-10">Laporan Hasil Ujian</h3>

            <div class="inline-block relative mb-12">
                <div class="w-56 h-56 rounded-full border-[14px] {{ $hasil->nilai >= 75 ? 'border-emerald-500' : 'border-red-500' }} flex flex-col items-center justify-center bg-white shadow-2xl relative z-10 p-4">
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Nilai Anda</span>
    
                <span class="text-7xl font-black {{ $hasil->nilai >= 75 ? 'text-emerald-600' : 'text-red-600' }} leading-none tracking-tighter">
                    {{ round($hasil->nilai) }}
            </span>
        </div>
                
                <div class="absolute inset-0 {{ $hasil->nilai >= 75 ? 'bg-emerald-400/20' : 'bg-red-400/20' }} rounded-full blur-3xl scale-125"></div>
            </div>

            <div class="grid grid-cols-2 gap-4 max-w-md mx-auto mb-10">
                <div class="bg-emerald-50 p-6 rounded-3xl border border-emerald-100 group hover:bg-emerald-100 transition-colors">
                    <span class="block text-[10px] font-black text-emerald-400 uppercase tracking-widest mb-1">Benar</span>
                    <span class="text-3xl font-black text-emerald-700">{{ $hasil->jumlah_benar }}</span>
                </div>
                <div class="bg-red-50 p-6 rounded-3xl border border-red-100 group hover:bg-red-100 transition-colors">
                    <span class="block text-[10px] font-black text-red-400 uppercase tracking-widest mb-1">Salah</span>
                    <span class="text-3xl font-black text-red-700">{{ $hasil->jumlah_salah }}</span>
                </div>
            </div>

            <a href="/siswa/dashboard" class="inline-flex items-center justify-center gap-3 bg-gray-900 hover:bg-black text-white font-black py-4 px-10 rounded-2xl transition shadow-xl active:scale-95 uppercase tracking-widest text-xs">
                <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-xl shrink-0"><i class="fas fa-hourglass-half"></i></div>
                <div>
                    <span class="block text-[9px] font-black text-gray-400 uppercase">Durasi</span>
                    <span class="text-lg font-black text-gray-800">{{ $ujian->durasi }} Menit</span>
                </div>
            </div>
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-center gap-4">
                <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center text-xl shrink-0"><i class="fas fa-list-ol"></i></div>
                <div>
                    <span class="block text-[9px] font-black text-gray-400 uppercase">Jumlah Soal</span>
                    <span class="text-lg font-black text-gray-800">{{ $ujian->soals->count() }} Butir</span>
                </div>
            </div>
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-center gap-4">
                <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-xl shrink-0"><i class="fas fa-check-double"></i></div>
                <div>
                    <span class="block text-[9px] font-black text-gray-400 uppercase">Tipe</span>
                    <span class="text-lg font-black text-gray-800">Pilihan Ganda</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-8 md:p-10">
            <h4 class="text-sm font-black text-gray-800 uppercase tracking-[0.2em] mb-6 flex items-center gap-2">
                <i class="fas fa-exclamation-circle text-amber-500"></i> Peraturan Penting:
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-10">
                <div class="flex items-start gap-3 p-4 bg-gray-50 rounded-2xl border border-gray-100">
                    <i class="fas fa-sync-alt mt-1 text-blue-500"></i>
                    <p class="text-xs text-gray-600 font-medium">Dilarang me-refresh halaman atau menekan tombol 'Back' saat ujian berlangsung.</p>
                </div>
                <div class="flex items-start gap-3 p-4 bg-gray-50 rounded-2xl border border-gray-100">
                    <i class="fas fa-wifi mt-1 text-emerald-500"></i>
                    <p class="text-xs text-gray-600 font-medium">Pastikan koneksi internet stabil hingga semua jawaban terkirim ke server.</p>
                </div>
            </div>

            <a href="/siswa/ujian/{{ $ujian->id }}/kerjakan" 
               class="w-full bg-emerald-600 hover:bg-emerald-700 text-white text-center font-black py-5 rounded-[1.5rem] transition shadow-xl shadow-emerald-100 text-sm uppercase tracking-[0.3em] active:scale-[0.98] flex items-center justify-center gap-3">
                Mulai Ujian Sekarang <i class="fas fa-play text-xs"></i>
            </a>
            <a href="/siswa/dashboard" class="block text-center mt-6 text-[10px] font-black text-gray-400 uppercase tracking-widest hover:text-gray-800 transition">
                Batal, Kembali ke Dashboard
            </a>
        </div>
    @endif
</div>
@endsection