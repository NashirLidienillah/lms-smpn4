@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <a href="/guru/kelas/{{ $ujian->guru_mapel_id }}" class="inline-flex items-center text-sm text-gray-500 hover:text-emerald-600 transition mb-4 font-medium">
        <i class="fas fa-arrow-left mr-2"></i> Batal & Kembali
    </a>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-emerald-600 px-6 py-4">
            <h2 class="text-xl font-bold text-white"><i class="fas fa-edit mr-2"></i> Edit Pengaturan Ujian CBT</h2>
        </div>
        
        <form action="/guru/ujian/{{ $ujian->id }}" method="POST" class="p-6 space-y-5">
            @csrf
            @method('PUT')
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Judul Ujian <span class="text-red-500">*</span></label>
                <input type="text" name="judul" value="{{ $ujian->judul }}" required class="w-full p-2.5 border border-gray-300 rounded-lg text-sm bg-gray-50 focus:ring-emerald-500 focus:border-emerald-500">
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Durasi Pengerjaan <span class="text-red-500">*</span></label>
                <div class="relative">
                    <input type="number" name="durasi" value="{{ $ujian->durasi }}" required min="5" class="w-full p-2.5 border border-gray-300 rounded-lg text-sm bg-gray-50 pr-16 focus:ring-emerald-500 focus:border-emerald-500">
                    <span class="absolute right-3 top-2.5 text-gray-400 text-sm font-bold">Menit</span>
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Waktu Dibuka <span class="text-red-500">*</span></label>
                <input type="datetime-local" name="mulai" value="{{ $ujian->mulai->format('Y-m-d\TH:i') }}" required class="w-full p-2.5 border border-gray-300 rounded-lg text-sm bg-emerald-50 text-emerald-700 font-medium">
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Waktu Ditutup <span class="text-red-500">*</span></label>
                <input type="datetime-local" name="selesai" value="{{ $ujian->selesai->format('Y-m-d\TH:i') }}" required class="w-full p-2.5 border border-gray-300 rounded-lg text-sm bg-red-50 text-red-700 font-medium">
            </div>

            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 rounded-lg shadow-md mt-4 transition">
                Simpan Pengaturan <i class="fas fa-save ml-1"></i>
            </button>
        </form>
    </div>
</div>
@endsection