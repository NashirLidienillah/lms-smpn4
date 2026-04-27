@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <a href="/guru/ujian/{{ $soal->ujian_id }}" class="inline-flex items-center text-sm text-gray-500 hover:text-emerald-600 transition mb-4 font-medium">
        <i class="fas fa-arrow-left mr-2"></i> Batal & Kembali
    </a>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-emerald-600 px-6 py-4">
            <h2 class="text-xl font-bold text-white"><i class="fas fa-edit mr-2"></i> Edit Pertanyaan CBT</h2>
        </div>
        
        <form action="/guru/soal/{{ $soal->id }}" method="POST" class="p-6 space-y-5">
            @csrf
            @method('PUT')
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Teks Pertanyaan <span class="text-red-500">*</span></label>
                <textarea name="pertanyaan" rows="3" required class="w-full p-2.5 border border-gray-300 rounded-lg text-sm bg-gray-50 focus:ring-emerald-500 focus:border-emerald-500">{{ $soal->pertanyaan }}</textarea>
            </div>

            <div class="space-y-3">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Pilihan Jawaban <span class="text-red-500">*</span></label>
                
                <div class="flex">
                    <span class="inline-flex items-center px-4 text-sm font-bold text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md">A</span>
                    <input type="text" name="pilihan_a" value="{{ $soal->pilihan_a }}" required class="rounded-none rounded-r-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-emerald-500 focus:border-emerald-500 block flex-1 min-w-0 w-full text-sm p-2.5">
                </div>
                <div class="flex">
                    <span class="inline-flex items-center px-4 text-sm font-bold text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md">B</span>
                    <input type="text" name="pilihan_b" value="{{ $soal->pilihan_b }}" required class="rounded-none rounded-r-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-emerald-500 focus:border-emerald-500 block flex-1 min-w-0 w-full text-sm p-2.5">
                </div>
                <div class="flex">
                    <span class="inline-flex items-center px-4 text-sm font-bold text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md">C</span>
                    <input type="text" name="pilihan_c" value="{{ $soal->pilihan_c }}" required class="rounded-none rounded-r-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-emerald-500 focus:border-emerald-500 block flex-1 min-w-0 w-full text-sm p-2.5">
                </div>
                <div class="flex">
                    <span class="inline-flex items-center px-4 text-sm font-bold text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md">D</span>
                    <input type="text" name="pilihan_d" value="{{ $soal->pilihan_d }}" required class="rounded-none rounded-r-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-emerald-500 focus:border-emerald-500 block flex-1 min-w-0 w-full text-sm p-2.5">
                </div>
            </div>

            <div class="bg-emerald-50 p-4 rounded-lg border border-emerald-200 mt-4">
                <label class="block text-sm font-bold text-emerald-800 mb-2">Kunci Jawaban Benar <span class="text-red-500">*</span></label>
                <select name="kunci_jawaban" required class="w-full p-2.5 border border-emerald-300 rounded-lg text-sm bg-white font-bold text-emerald-700 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 cursor-pointer">
                    <option value="a" {{ $soal->kunci_jawaban == 'a' ? 'selected' : '' }}>Opsi A</option>
                    <option value="b" {{ $soal->kunci_jawaban == 'b' ? 'selected' : '' }}>Opsi B</option>
                    <option value="c" {{ $soal->kunci_jawaban == 'c' ? 'selected' : '' }}>Opsi C</option>
                    <option value="d" {{ $soal->kunci_jawaban == 'd' ? 'selected' : '' }}>Opsi D</option>
                </select>
            </div>

            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 rounded-lg shadow-md mt-4 transition">
                Simpan Perubahan Soal <i class="fas fa-save ml-1"></i>
            </button>
        </form>
    </div>
</div>
@endsection