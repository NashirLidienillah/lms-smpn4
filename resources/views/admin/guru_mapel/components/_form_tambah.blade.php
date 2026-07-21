{{-- ================= KIRI: FORM TAMBAH JADWAL ================= --}}
<div class="lg:col-span-4">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 sticky top-6 z-20">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 font-bold text-gray-700 flex items-center rounded-t-2xl">
            <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center mr-3">
                <i class="fas fa-clock"></i>
            </div>
            Buat Jadwal Baru
        </div>
        <form action="/admin/guru-mapel" method="POST" class="p-6 space-y-5">
            @csrf
            
            {{-- 1. Dropdown Kelas (Alpine.js) --}}
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Pilih Kelas</label>
                <div x-data="{ open: false, selectedId: '', selectedName: '' }" class="relative">
                    <input type="hidden" name="kelas_id" x-model="selectedId" required>
                    
                    <button @click="open = !open" @click.outside="open = false" type="button" 
                        class="w-full p-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold flex justify-between items-center focus:ring-2 focus:ring-blue-500 transition-all shadow-sm outline-none">
                        <span x-text="selectedName || '-- Pilih Kelas --'" :class="selectedName ? 'text-gray-800' : 'text-gray-400'"></span>
                        <i class="fas fa-chevron-down text-gray-400 transition-transform duration-300" :class="open ? 'rotate-180' : ''"></i>
                    </button>

                    <div x-show="open" style="display: none;"
                         x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2"
                         class="absolute z-50 w-full mt-2 bg-white border border-gray-100 rounded-xl shadow-xl max-h-60 overflow-y-auto custom-scrollbar">
                        @foreach($kelas as $k)
                            <div @click="selectedId = '{{ $k->id }}'; selectedName = 'Kelas {{ addslashes($k->nama_kelas) }}'; open = false" 
                                 class="px-4 py-3 text-sm font-bold cursor-pointer transition-colors border-b border-gray-50 hover:bg-blue-50 hover:text-blue-600 flex items-center justify-between"
                                 :class="selectedId == '{{ $k->id }}' ? 'bg-blue-50 text-blue-600' : 'text-gray-600'">
                                 Kelas {{ $k->nama_kelas }}
                                 <i x-show="selectedId == '{{ $k->id }}'" class="fas fa-check text-blue-500"></i>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- 2. Dropdown Mapel (Alpine.js) --}}
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Mata Pelajaran</label>
                <div x-data="{ open: false, selectedId: '', selectedName: '' }" class="relative">
                    <input type="hidden" name="mapel_id" x-model="selectedId" required>
                    
                    <button @click="open = !open" @click.outside="open = false" type="button" 
                        class="w-full p-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold flex justify-between items-center focus:ring-2 focus:ring-blue-500 transition-all shadow-sm outline-none">
                        <span x-text="selectedName || '-- Pilih Mapel --'" :class="selectedName ? 'text-gray-800' : 'text-gray-400'"></span>
                        <i class="fas fa-chevron-down text-gray-400 transition-transform duration-300" :class="open ? 'rotate-180' : ''"></i>
                    </button>

                    <div x-show="open" style="display: none;"
                         x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2"
                         class="absolute z-50 w-full mt-2 bg-white border border-gray-100 rounded-xl shadow-xl max-h-60 overflow-y-auto custom-scrollbar">
                        @foreach($mapels as $mapel)
                            <div @click="selectedId = '{{ $mapel->id }}'; selectedName = '{{ addslashes($mapel->nama_mapel) }}'; open = false" 
                                 class="px-4 py-3 text-sm font-bold cursor-pointer transition-colors border-b border-gray-50 hover:bg-blue-50 hover:text-blue-600 flex items-center justify-between"
                                 :class="selectedId == '{{ $mapel->id }}' ? 'bg-blue-50 text-blue-600' : 'text-gray-600'">
                                 {{ $mapel->nama_mapel }}
                                 <i x-show="selectedId == '{{ $mapel->id }}'" class="fas fa-check text-blue-500"></i>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- 3. Dropdown Guru (Alpine.js dengan Search Live) --}}
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Guru Pengajar</label>
                <div x-data="{ 
                        open: false, search: '', selectedId: '', selectedName: '',
                        options: [
                            @foreach($gurus as $guru)
                                { id: '{{ $guru->id }}', name: '{{ addslashes($guru->name) }}' },
                            @endforeach
                        ],
                        get filtered() { return this.search === '' ? this.options : this.options.filter(o => o.name.toLowerCase().includes(this.search.toLowerCase())) }
                    }" class="relative">
                    
                    <input type="hidden" name="user_id" x-model="selectedId" required>
                    
                    <button @click="open = !open" @click.outside="open = false" type="button" 
                        class="w-full p-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold flex justify-between items-center focus:ring-2 focus:ring-blue-500 transition-all shadow-sm outline-none">
                        <span x-text="selectedName || '-- Cari & Pilih Guru --'" :class="selectedName ? 'text-gray-800' : 'text-gray-400'"></span>
                        <i class="fas fa-chevron-down text-gray-400 transition-transform duration-300" :class="open ? 'rotate-180' : ''"></i>
                    </button>

                    <div x-show="open" style="display: none;"
                         x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2"
                         class="absolute z-50 w-full mt-2 bg-white border border-gray-100 rounded-xl shadow-xl overflow-hidden flex flex-col">
                        
                        <div class="p-2 border-b border-gray-100 bg-gray-50">
                            <input x-model="search" type="text" placeholder="Ketik nama guru..." class="w-full p-2.5 bg-white border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none" @click.stop>
                        </div>
                        <div class="max-h-56 overflow-y-auto custom-scrollbar p-1">
                            <template x-for="opt in filtered" :key="opt.id">
                                <div @click="selectedId = opt.id; selectedName = opt.name; open = false; search = ''" 
                                     class="px-3 py-3 text-sm font-bold cursor-pointer rounded-lg mb-1 transition-colors hover:bg-blue-50 hover:text-blue-600 flex items-center justify-between"
                                     :class="selectedId == opt.id ? 'bg-blue-50 text-blue-600' : 'text-gray-600'">
                                     <span x-text="opt.name"></span>
                                     <i x-show="selectedId == opt.id" class="fas fa-check text-blue-500"></i>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Box Waktu --}}
            <div class="grid grid-cols-1 gap-4 bg-blue-50/50 p-5 rounded-2xl border border-blue-100/50">
                {{-- 4. Dropdown Hari (Alpine.js) --}}
                <div>
                    <label class="block text-[10px] font-black text-blue-800 uppercase tracking-widest mb-2">Hari Mengajar</label>
                    <div x-data="{ open: false, selected: '', options: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] }" class="relative">
                        <input type="hidden" name="hari" x-model="selected" required>
                        
                        <button @click="open = !open" @click.outside="open = false" type="button" 
                            class="w-full p-3.5 bg-white border border-blue-200 rounded-xl text-sm font-bold flex justify-between items-center focus:ring-2 focus:ring-blue-500 transition-all shadow-sm outline-none">
                            <span x-text="selected || '-- Pilih Hari --'" :class="selected ? 'text-blue-900' : 'text-blue-400'"></span>
                            <i class="fas fa-chevron-down text-blue-400 transition-transform duration-300" :class="open ? 'rotate-180' : ''"></i>
                        </button>

                        <div x-show="open" style="display: none;"
                             x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2"
                             class="absolute z-50 w-full mt-2 bg-white border border-gray-100 rounded-xl shadow-xl overflow-hidden">
                            <template x-for="hari in options" :key="hari">
                                <div @click="selected = hari; open = false" 
                                     class="px-4 py-3 text-sm font-bold cursor-pointer transition-colors border-b border-gray-50 hover:bg-blue-50 hover:text-blue-600 flex items-center justify-between"
                                     :class="selected == hari ? 'bg-blue-50 text-blue-600' : 'text-gray-600'">
                                     <span x-text="hari"></span>
                                     <i x-show="selected == hari" class="fas fa-check text-blue-500"></i>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[10px] font-black text-blue-800 uppercase tracking-widest mb-2">Jam Mulai</label>
                        <input type="time" name="jam_mulai" required class="w-full p-3 bg-white border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm font-mono font-bold text-blue-900 shadow-sm transition-all outline-none">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-blue-800 uppercase tracking-widest mb-2">Jam Selesai</label>
                        <input type="time" name="jam_selesai" required class="w-full p-3 bg-white border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm font-mono font-bold text-blue-900 shadow-sm transition-all outline-none">
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-xl transition-all shadow-lg shadow-blue-200 font-black flex items-center justify-center uppercase tracking-widest text-[11px]">
                <i class="fas fa-plus-circle mr-2"></i> Tambahkan Jadwal
            </button>
        </form>
    </div>
</div>