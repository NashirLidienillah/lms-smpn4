@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto mb-20">
    <a href="/guru/ujian/{{ $soal->ujian_id }}" class="inline-flex items-center text-xs font-black text-gray-400 hover:text-emerald-600 transition-all mb-6 uppercase tracking-widest bg-white px-4 py-2 rounded-xl border border-gray-100 shadow-sm">
        <i class="fas fa-arrow-left mr-2"></i> Batal & Kembali
    </a>

    {{-- Bento Form Card (Tanpa overflow-hidden) --}}
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100">
        <div class="bg-emerald-600 px-6 py-5 rounded-t-3xl flex items-center shadow-inner">
            <div class="w-10 h-10 rounded-xl bg-white/20 text-white flex items-center justify-center mr-4 backdrop-blur-sm">
                <i class="fas fa-edit text-lg"></i>
            </div>
            <div>
                <h2 class="text-xl font-black text-white tracking-tight">Edit Pertanyaan CBT</h2>
                <p class="text-emerald-100 text-xs mt-0.5 font-medium">Perbarui teks soal atau pilihan jawaban.</p>
            </div>
        </div>
        
        <form action="/guru/soal/{{ $soal->id }}" method="POST" class="p-6 md:p-8 space-y-6">
            @csrf
            @method('PUT')
            
            {{-- Input Teks Pertanyaan --}}
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Teks Pertanyaan <span class="text-red-500">*</span></label>
                <textarea name="pertanyaan" rows="4" required 
                    class="w-full p-4 bg-gray-50 border border-gray-200 rounded-2xl text-sm font-medium text-gray-800 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 focus:bg-white transition-all outline-none leading-relaxed">{{ $soal->pertanyaan }}</textarea>
            </div>

            {{-- Input Pilihan Ganda (Bento Style) --}}
            <div class="space-y-3">
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Pilihan Jawaban <span class="text-red-500">*</span></label>
                
                <div class="flex shadow-sm rounded-xl overflow-hidden border border-gray-200 focus-within:border-emerald-500 focus-within:ring-2 focus-within:ring-emerald-500 transition-all">
                    <span class="inline-flex items-center px-5 text-sm font-black text-gray-400 bg-gray-100 border-r border-gray-200">A</span>
                    <input type="text" name="pilihan_a" value="{{ $soal->pilihan_a }}" required class="bg-gray-50 border-none text-gray-800 font-medium block flex-1 min-w-0 w-full text-sm p-3.5 focus:ring-0 outline-none">
                </div>
                
                <div class="flex shadow-sm rounded-xl overflow-hidden border border-gray-200 focus-within:border-emerald-500 focus-within:ring-2 focus-within:ring-emerald-500 transition-all">
                    <span class="inline-flex items-center px-5 text-sm font-black text-gray-400 bg-gray-100 border-r border-gray-200">B</span>
                    <input type="text" name="pilihan_b" value="{{ $soal->pilihan_b }}" required class="bg-gray-50 border-none text-gray-800 font-medium block flex-1 min-w-0 w-full text-sm p-3.5 focus:ring-0 outline-none">
                </div>
                
                <div class="flex shadow-sm rounded-xl overflow-hidden border border-gray-200 focus-within:border-emerald-500 focus-within:ring-2 focus-within:ring-emerald-500 transition-all">
                    <span class="inline-flex items-center px-5 text-sm font-black text-gray-400 bg-gray-100 border-r border-gray-200">C</span>
                    <input type="text" name="pilihan_c" value="{{ $soal->pilihan_c }}" required class="bg-gray-50 border-none text-gray-800 font-medium block flex-1 min-w-0 w-full text-sm p-3.5 focus:ring-0 outline-none">
                </div>
                
                <div class="flex shadow-sm rounded-xl overflow-hidden border border-gray-200 focus-within:border-emerald-500 focus-within:ring-2 focus-within:ring-emerald-500 transition-all">
                    <span class="inline-flex items-center px-5 text-sm font-black text-gray-400 bg-gray-100 border-r border-gray-200">D</span>
                    <input type="text" name="pilihan_d" value="{{ $soal->pilihan_d }}" required class="bg-gray-50 border-none text-gray-800 font-medium block flex-1 min-w-0 w-full text-sm p-3.5 focus:ring-0 outline-none">
                </div>
            </div>

            {{-- THE STAR: DROPDOWN KUNCI JAWABAN (Custom Alpine.js) --}}
            <div class="bg-emerald-50 p-5 rounded-2xl border border-emerald-100 mt-6">
                <label class="block text-[10px] font-black text-emerald-800 uppercase tracking-widest mb-3 flex items-center">
                    <i class="fas fa-key text-emerald-600 mr-2 text-sm"></i> Kunci Jawaban Benar <span class="text-red-500 ml-1">*</span>
                </label>
                
                <div x-data="{ 
                        open: false, 
                        selected: '{{ $soal->kunci_jawaban }}', 
                        options: {
                            'a': 'Pilihan A', 
                            'b': 'Pilihan B', 
                            'c': 'Pilihan C', 
                            'd': 'Pilihan D'
                        } 
                    }" class="relative w-full">
                    
                    {{-- Hidden Input untuk Backend Laravel --}}
                    <input type="hidden" name="kunci_jawaban" x-model="selected" required>

                    {{-- Tombol Dropdown Custom --}}
                    <button @click="open = !open" @click.outside="open = false" type="button" 
                        class="w-full p-3.5 bg-white border border-emerald-200 rounded-xl text-sm font-bold flex justify-between items-center focus:ring-2 focus:ring-emerald-500 transition-all shadow-sm outline-none">
                        <span x-text="options[selected]" class="text-emerald-800"></span>
                        <i class="fas fa-chevron-down text-emerald-400 transition-transform duration-300" :class="open ? 'rotate-180' : ''"></i>
                    </button>

                    {{-- Menu Popup Melayang (Bukan bawaan HP lagi) --}}
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-2"
                         style="display: none;"
                         class="absolute z-50 w-full mt-2 bg-white border border-emerald-100 rounded-xl shadow-xl overflow-hidden">
                        
                        <template x-for="(label, value) in options" :key="value">
                            <div @click="selected = value; open = false" 
                                 class="px-4 py-3.5 text-sm font-bold cursor-pointer transition-colors border-b border-emerald-50 last:border-0 hover:bg-emerald-50 hover:text-emerald-700 flex items-center gap-2"
                                 :class="selected === value ? 'bg-emerald-50 text-emerald-700' : 'text-gray-600'">
                                 <span x-text="label"></span>
                                 <i x-show="selected === value" class="fas fa-check text-emerald-500 ml-auto"></i>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-gray-100 mt-6">
                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-black py-4 rounded-xl shadow-lg shadow-emerald-200 transition-all uppercase tracking-widest text-[11px] flex items-center justify-center gap-2">
                    <i class="fas fa-save"></i> Simpan Perubahan Soal
                </button>
            </div>
        </form>
    </div>
</div>
@endsection