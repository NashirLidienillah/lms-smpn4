@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <a href="/guru/kelas/{{ $tugas->guru_mapel_id }}" class="inline-flex items-center text-sm text-gray-500 hover:text-purple-600 transition mb-4 font-medium">
        <i class="fas fa-arrow-left mr-2"></i> Batal & Kembali
    </a>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-purple-600 px-6 py-4">
            <h2 class="text-xl font-bold text-white"><i class="fas fa-edit mr-2"></i> Edit Tugas Esai</h2>
        </div>
        
        <form action="/guru/tugas/{{ $tugas->id }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
            @csrf
            @method('PUT')
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Judul Tugas <span class="text-red-500">*</span></label>
                <input type="text" name="judul" value="{{ $tugas->judul }}" required class="w-full p-2.5 border border-gray-300 rounded-lg text-sm bg-gray-50 focus:ring-purple-500 focus:border-purple-500">
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Soal/Instruksi <span class="text-red-500">*</span></label>
                <textarea name="deskripsi" rows="4" required class="w-full p-2.5 border border-gray-300 rounded-lg text-sm bg-gray-50 focus:ring-purple-500 focus:border-purple-500">{{ $tugas->deskripsi }}</textarea>
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Batas Waktu (Deadline) <span class="text-red-500">*</span></label>
                <input type="datetime-local" name="batas_waktu" value="{{ $tugas->batas_waktu->format('Y-m-d\TH:i') }}" required class="w-full p-2.5 border border-gray-300 rounded-lg text-sm font-medium text-red-600 bg-red-50 cursor-pointer shadow-sm">
            </div>

            <div class="bg-purple-50 border border-purple-200 p-4 rounded-lg">
                <label class="block text-sm font-bold text-purple-700 mb-2">Ganti Lampiran File (Opsional)</label>
                @if($tugas->file_tugas)
                    <p class="text-sm text-gray-600 mb-3"><i class="fas fa-paperclip mr-1"></i> File saat ini: <span class="font-semibold text-purple-600">{{ $tugas->file_tugas }}</span></p>
                @endif
                <input type="file" name="file_tugas" accept=".pdf,.doc,.docx,.jpg,.png" class="w-full text-sm text-gray-500 bg-white border border-purple-200 rounded p-1">
                <p class="text-xs text-purple-500 mt-2 italic">*Kosongkan jika tidak ingin mengubah file soal yang lama.</p>
            </div>

            <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 rounded-lg shadow-md mt-4 transition">
                Simpan Perubahan <i class="fas fa-save ml-1"></i>
            </button>
        </form>
    </div>
</div>
@endsection