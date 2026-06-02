@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto mb-20">
    <a href="/guru/kelas/{{ $ujian->guru_mapel_id }}" class="inline-flex items-center text-xs font-black text-gray-400 hover:text-emerald-600 transition-all mb-6 uppercase tracking-widest bg-white px-4 py-2 rounded-xl border border-gray-100 shadow-sm">
        <i class="fas fa-arrow-left mr-2"></i> Batal & Kembali
    </a>

    {{-- Bento Form Card --}}
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100">
        <div class="bg-emerald-600 px-6 py-5 rounded-t-3xl flex items-center shadow-inner">
            <div class="w-10 h-10 rounded-xl bg-white/20 text-white flex items-center justify-center mr-4 backdrop-blur-sm">
                <i class="fas fa-edit text-lg"></i>
            </div>
            <div>
                <h2 class="text-xl font-black text-white tracking-tight">Edit Pengaturan Kuis / Ujian</h2>
                <p class="text-emerald-100 text-xs mt-0.5 font-medium">Perbarui judul, durasi, atau jadwal pelaksanaan kuis / ujian.</p>
            </div>
        </div>
        
        <form action="/guru/ujian/{{ $ujian->id }}" method="POST" class="p-6 md:p-8 space-y-6">
            @csrf
            @method('PUT')
            
            {{-- Input Judul Ujian --}}
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Judul Kuis / Ujian <span class="text-red-500">*</span></label>
                <input type="text" name="judul" value="{{ $ujian->judul }}" required 
                    class="w-full p-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 focus:bg-white transition-all outline-none">
            </div>
            
            {{-- Input Durasi --}}
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Durasi Pengerjaan <span class="text-red-500">*</span></label>
                <div class="relative flex items-center">
                    <input type="number" name="durasi" value="{{ $ujian->durasi }}" required min="1" 
                        class="w-full p-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 pr-16 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 focus:bg-white transition-all outline-none">
                    <span class="absolute right-4 text-gray-400 text-[10px] font-black uppercase tracking-widest pointer-events-none">Menit</span>
                </div>
            </div>
            
            {{-- Box Waktu Mulai & Selesai (Bento Grid) --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                {{-- Waktu Dibuka --}}
                <div class="bg-emerald-50 border border-emerald-100 p-5 rounded-2xl">
                    <label class="block text-[10px] font-black text-emerald-800 uppercase tracking-widest mb-3 flex items-center">
                        <i class="fas fa-play-circle mr-1.5 text-emerald-600"></i> Waktu Dibuka <span class="text-red-500 ml-1">*</span>
                    </label>
                    <input type="datetime-local" name="mulai" value="{{ $ujian->mulai->format('Y-m-d\TH:i') }}" required 
                        class="w-full p-3 bg-white border border-emerald-200 rounded-xl text-sm font-black text-emerald-700 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 cursor-pointer shadow-sm transition-all outline-none uppercase tracking-wide">
                </div>
                
                {{-- Waktu Ditutup --}}
                <div class="bg-red-50 border border-red-100 p-5 rounded-2xl">
                    <label class="block text-[10px] font-black text-red-800 uppercase tracking-widest mb-3 flex items-center">
                        <i class="fas fa-stop-circle mr-1.5 text-red-600"></i> Waktu Ditutup <span class="text-red-500 ml-1">*</span>
                    </label>
                    <input type="datetime-local" name="selesai" value="{{ $ujian->selesai->format('Y-m-d\TH:i') }}" required 
                        class="w-full p-3 bg-white border border-red-200 rounded-xl text-sm font-black text-red-700 focus:ring-2 focus:ring-red-500 focus:border-red-500 cursor-pointer shadow-sm transition-all outline-none uppercase tracking-wide">
                </div>
            </div>

            <div class="pt-4 border-t border-gray-100 mt-6">
                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-black py-4 rounded-xl shadow-lg shadow-emerald-200 transition-all uppercase tracking-widest text-[11px] flex items-center justify-center gap-2">
                    <i class="fas fa-save"></i> Simpan Pengaturan Kuis / Ujian
                </button>
            </div>
        </form>
    </div>
</div>
@endsection