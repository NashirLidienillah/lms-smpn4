<form action="/guru/soal/{{ $soal->id }}" method="POST" class="p-6 md:p-8 space-y-6">
    @csrf
    @method('PUT')
    
    {{-- Input Teks Pertanyaan --}}
    <div>
        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Teks Pertanyaan <span class="text-red-500">*</span></label>
        <textarea name="pertanyaan" rows="4" required 
            class="w-full p-4 bg-gray-50 border border-gray-200 rounded-2xl text-sm font-medium text-gray-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all outline-none leading-relaxed">{{ $soal->pertanyaan }}</textarea>
    </div>

    {{-- Input Pilihan Ganda (Bento Style) --}}
    <div class="space-y-3">
        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Pilihan Jawaban <span class="text-red-500">*</span></label>
        
        @foreach(['a', 'b', 'c', 'd'] as $huruf)
            @php 
                $nama_kolom = 'pilihan_' . $huruf; 
                $value_pilihan = $soal->$nama_kolom;
            @endphp
            <div class="flex shadow-sm rounded-xl overflow-hidden border border-gray-200 focus-within:border-blue-500 focus-within:ring-2 focus-within:ring-blue-500 transition-all">
                <span class="inline-flex items-center px-5 text-sm font-black text-gray-400 bg-gray-100 border-r border-gray-200">{{ strtoupper($huruf) }}</span>
                <input type="text" name="{{ $nama_kolom }}" value="{{ $value_pilihan }}" required class="bg-gray-50 border-none text-gray-800 font-medium block flex-1 min-w-0 w-full text-sm p-3.5 focus:ring-0 outline-none">
            </div>
        @endforeach
    </div>

    {{-- THE STAR: DROPDOWN KUNCI JAWABAN (Custom Alpine.js) --}}
    <div class="bg-blue-50 p-5 rounded-2xl border border-blue-100 mt-6">
        <label class="block text-[10px] font-black text-blue-800 uppercase tracking-widest mb-3 flex items-center">
            <i class="fas fa-key text-blue-600 mr-2 text-sm"></i> Kunci Jawaban Benar <span class="text-red-500 ml-1">*</span>
        </label>
        
        <div x-data="{ 
                open: false, 
                selected: '{{ strtolower($soal->kunci_jawaban) }}', 
                options: {
                    'a': 'Pilihan A', 
                    'b': 'Pilihan B', 
                    'c': 'Pilihan C', 
                    'd': 'Pilihan D'
                } 
            }" class="relative w-full">
            
            <input type="hidden" name="kunci_jawaban" x-model="selected" required>

            <button @click="open = !open" @click.outside="open = false" type="button" 
                class="w-full p-3.5 bg-white border border-blue-200 rounded-xl text-sm font-bold flex justify-between items-center focus:ring-2 focus:ring-blue-500 transition-all shadow-sm outline-none">
                <span x-text="options[selected]" class="text-blue-800"></span>
                <i class="fas fa-chevron-down text-blue-400 transition-transform duration-300" :class="open ? 'rotate-180' : ''"></i>
            </button>

            <div x-show="open" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 translate-y-2"
                 style="display: none;"
                 class="absolute z-50 w-full mt-2 bg-white border border-blue-100 rounded-xl shadow-xl overflow-hidden">
                
                <template x-for="(label, value) in options" :key="value">
                    <div @click="selected = value; open = false" 
                         class="px-4 py-3.5 text-sm font-bold cursor-pointer transition-colors border-b border-blue-50 last:border-0 hover:bg-blue-50 hover:text-blue-700 flex items-center gap-2"
                         :class="selected === value ? 'bg-blue-50 text-blue-700' : 'text-gray-600'">
                         <span x-text="label"></span>
                         <i x-show="selected === value" class="fas fa-check text-blue-500 ml-auto"></i>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <div class="pt-4 border-t border-gray-100 mt-6">
        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-4 rounded-xl shadow-lg shadow-blue-200 transition-all uppercase tracking-widest text-[11px] flex items-center justify-center gap-2">
            <i class="fas fa-save"></i> Simpan Perubahan Soal
        </button>
    </div>
</form>