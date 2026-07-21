{{-- KOLOM FORM (Diperbarui dengan Alpine.js) --}}
<div class="lg:col-span-1">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 sticky top-6 z-10">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 rounded-t-2xl font-bold text-gray-700 flex items-center">
            <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center mr-3">
                <i class="fas fa-calendar-plus"></i>
            </div>
            Buat Periode Baru
        </div>
        
        <form action="/admin/tahun-akademik" method="POST" class="p-6 space-y-5">
            @csrf
            
            {{-- Input Tahun Ajaran --}}
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Tahun Ajaran</label>
                <input type="text" name="nama_tahun" required placeholder="Contoh: 2026/2027" 
                    class="w-full p-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-all outline-none">
            </div>
            
            {{-- THE STAR: DROPDOWN SEMESTER (100% Custom Alpine.js) --}}
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Semester</label>
                
                <div x-data="{ 
                        open: false, 
                        selected: 'Ganjil', 
                        options: {
                            'Ganjil': 'Semester Ganjil', 
                            'Genap': 'Semester Genap'
                        } 
                    }" class="relative w-full">
                    
                    {{-- Hidden Input untuk Backend Laravel --}}
                    <input type="hidden" name="semester" x-model="selected" required>

                    {{-- Tombol Dropdown Custom --}}
                    <button @click="open = !open" @click.outside="open = false" type="button" 
                        class="w-full p-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold flex justify-between items-center focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all shadow-sm outline-none text-gray-700">
                        <span x-text="options[selected]"></span>
                        <i class="fas fa-chevron-down text-gray-400 transition-transform duration-300" :class="open ? 'rotate-180' : ''"></i>
                    </button>

                    {{-- Menu Popup Melayang --}}
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-2"
                         style="display: none;"
                         class="absolute z-50 w-full mt-2 bg-white border border-gray-100 rounded-xl shadow-xl overflow-hidden">
                        
                        <template x-for="(label, value) in options" :key="value">
                            <div @click="selected = value; open = false" 
                                 class="px-4 py-3.5 text-sm font-bold cursor-pointer transition-colors border-b border-gray-50 last:border-0 hover:bg-indigo-50 hover:text-indigo-600 flex items-center gap-2"
                                 :class="selected === value ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600'">
                                 <span x-text="label"></span>
                                 <i x-show="selected === value" class="fas fa-check text-indigo-500 ml-auto"></i>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
            
            {{-- Tombol Submit --}}
            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-black py-4 rounded-xl transition-all shadow-lg shadow-indigo-200 flex items-center justify-center mt-4 uppercase tracking-widest text-xs">
                <i class="fas fa-save mr-2"></i> Simpan Periode
            </button>
        </form>
    </div>
</div>