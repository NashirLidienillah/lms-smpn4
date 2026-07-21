<div class="lg:col-span-1">
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 sticky top-6 z-10">
        {{-- Header Form Tambah Soal (Biru) --}}
        <div class="bg-blue-600 px-6 py-5 flex items-center gap-3 rounded-t-3xl">
            <i class="fas fa-plus-circle text-white text-xl"></i>
            <h3 class="font-bold text-white uppercase tracking-wider text-sm">Tambah Soal</h3>
        </div>
        
        <form action="/guru/ujian/{{ $ujian->id }}/soal" method="POST" class="p-6 space-y-5">
            @csrf
            
            {{-- Input Pertanyaan --}}
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Tambah Pertanyaan</label>
                <textarea name="pertanyaan" rows="4" required placeholder="Tuliskan butir soal di sini..." class="w-full p-4 bg-gray-50 border border-gray-100 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all outline-none leading-relaxed"></textarea>
            </div>

            {{-- Input Opsi Jawaban --}}
            <div class="space-y-3">
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Pilihan Opsi Jawaban</label>
                @foreach(['A', 'B', 'C', 'D'] as $label)
                <div class="flex shadow-sm rounded-xl overflow-hidden border border-gray-200 focus-within:border-blue-500 focus-within:ring-2 focus-within:ring-blue-500 transition-all">
                    <span class="inline-flex items-center px-4 text-xs font-black text-gray-400 bg-gray-100 border-r border-gray-200">{{ $label }}</span>
                    <input type="text" name="pilihan_{{ strtolower($label) }}" required placeholder="Pilihan {{ $label }}..." class="bg-gray-50 border-none text-gray-800 font-medium block flex-1 min-w-0 w-full text-sm p-3 focus:ring-0 outline-none">
                </div>
                @endforeach
            </div>

            {{-- Box Dropdown Kunci Jawaban (Biru) --}}
            <div class="p-5 bg-blue-50/50 border border-blue-100 rounded-2xl mt-4">
                <label class="block text-[10px] font-black text-blue-800 uppercase tracking-widest mb-3">Kunci Jawaban Benar</label>
                <div x-data="{ 
                        open: false, selected: '', 
                        options: { 'a': 'Opsi A', 'b': 'Opsi B', 'c': 'Opsi C', 'd': 'Opsi D' } 
                    }" class="relative w-full">
                    
                    <input type="hidden" name="kunci_jawaban" x-model="selected" required>

                    <button @click="open = !open" @click.outside="open = false" type="button" 
                        class="w-full p-3.5 bg-white border border-blue-200 rounded-xl text-sm font-black flex justify-between items-center focus:ring-2 focus:ring-blue-500 transition-all shadow-sm outline-none">
                        <span x-text="selected ? options[selected] : '-- Pilih Kunci --'" :class="selected ? 'text-blue-700' : 'text-gray-400'"></span>
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
                                 class="px-4 py-3.5 text-sm font-bold cursor-pointer transition-colors border-b border-gray-50 last:border-0 hover:bg-blue-50 hover:text-blue-700 flex items-center gap-2"
                                 :class="selected === value ? 'bg-blue-50 text-blue-700' : 'text-gray-600'">
                                 <span x-text="label"></span>
                                 <i x-show="selected === value" class="fas fa-check text-blue-500 ml-auto"></i>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            {{-- Tombol Simpan (Biru) --}}
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-4 rounded-2xl shadow-lg shadow-blue-100 transition-all active:scale-95 uppercase tracking-widest text-xs">
                Simpan Pertanyaan <i class="fas fa-save ml-2"></i>
            </button>
        </form>
    </div>
</div>