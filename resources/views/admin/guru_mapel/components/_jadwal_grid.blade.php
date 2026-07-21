{{-- ================= KANAN: DAFTAR JADWAL GRID ================= --}}
<div class="lg:col-span-8 space-y-4">
    
    {{-- Navigasi Filter & Pencarian --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 flex flex-col xl:flex-row justify-between items-center gap-4 relative z-10">
        
        {{-- Bagian Kiri: Filter Hari & Filter Kelas --}}
        <div class="flex flex-col md:flex-row items-center gap-3 w-full xl:w-auto">
            {{-- Tab Filter Hari --}}
            <div class="flex overflow-x-auto hide-scrollbar gap-2 w-full md:w-auto" style="-ms-overflow-style: none; scrollbar-width: none;">
                <button onclick="filterHari('semua')" data-target="semua" class="tab-hari-btn bg-blue-600 text-white shadow-md px-5 py-2.5 rounded-xl text-xs font-bold transition-all duration-300 whitespace-nowrap">
                    Semua
                </button>
                @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $h)
                <button onclick="filterHari('{{ $h }}')" data-target="{{ $h }}" class="tab-hari-btn bg-gray-50 text-gray-500 hover:bg-gray-100 border border-gray-200 px-5 py-2.5 rounded-xl text-xs font-bold transition-all duration-300 whitespace-nowrap">
                    {{ $h }}
                </button>
                @endforeach
            </div>

            {{-- 5. Dropdown Filter Kelas Atas (Alpine.js) --}}
            <div class="w-full md:w-48 shrink-0" x-data="{ open: false, selected: 'semua' }">
                <div class="relative">
                    <button @click="open = !open" @click.outside="open = false" type="button" 
                        class="w-full py-2.5 px-4 bg-white border border-gray-200 rounded-xl text-sm font-bold flex justify-between items-center focus:ring-2 focus:ring-blue-500 transition-all shadow-sm outline-none">
                        <span x-text="selected === 'semua' ? 'Semua Kelas' : 'Kelas ' + selected" class="text-gray-700"></span>
                        <i class="fas fa-chevron-down text-gray-400 transition-transform duration-300" :class="open ? 'rotate-180' : ''"></i>
                    </button>

                    <div x-show="open" style="display: none;"
                         x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2"
                         class="absolute z-50 w-full mt-2 bg-white border border-gray-100 rounded-xl shadow-xl max-h-60 overflow-y-auto custom-scrollbar">
                        
                        <div @click="selected = 'semua'; filterKelas('semua'); open = false" 
                             class="px-4 py-3 text-sm font-bold cursor-pointer transition-colors border-b border-gray-50 hover:bg-blue-50 hover:text-blue-600 flex items-center justify-between"
                             :class="selected == 'semua' ? 'bg-blue-50 text-blue-600' : 'text-gray-600'">
                             Semua Kelas
                             <i x-show="selected == 'semua'" class="fas fa-check text-blue-500"></i>
                        </div>
                        @foreach($kelas as $k)
                            <div @click="selected = '{{ $k->nama_kelas }}'; filterKelas('{{ $k->nama_kelas }}'); open = false" 
                                 class="px-4 py-3 text-sm font-bold cursor-pointer transition-colors border-b border-gray-50 hover:bg-blue-50 hover:text-blue-600 flex items-center justify-between"
                                 :class="selected == '{{ $k->nama_kelas }}' ? 'bg-blue-50 text-blue-600' : 'text-gray-600'">
                                 Kelas {{ $k->nama_kelas }}
                                 <i x-show="selected == '{{ $k->nama_kelas }}'" class="fas fa-check text-blue-500"></i>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Kotak Pencarian --}}
        <div class="relative w-full xl:w-56 shrink-0">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                <i class="fas fa-search text-gray-400"></i>
            </div>
            <input type="text" id="searchJadwal" oninput="applyJadwalFilter()" class="bg-gray-50 border border-gray-200 text-gray-700 text-sm rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 py-2.5 transition-all font-medium shadow-sm outline-none" placeholder="Cari Guru, Mapel...">
        </div>
    </div>

    {{-- Grid Kartu Jadwal Bento --}}
    <div id="jadwalGrid" class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @forelse($guruMapels as $gm)
            <div class="jadwal-card bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col hover:shadow-xl transition-all duration-300 relative group" data-hari="{{ $gm->hari }}" data-kelas="{{ $gm->kelas->nama_kelas }}">
                
                {{-- Header Kartu: Jam & Hari --}}
                <div class="flex justify-between items-center mb-4 border-b border-gray-50 pb-3">
                    <div class="flex items-center gap-2.5">
                        <span class="bg-blue-50 text-blue-600 px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest border border-blue-100">{{ $gm->hari }}</span>
                        <span class="text-xs font-black text-gray-700 font-mono bg-gray-50 px-2 py-1 rounded border border-gray-100"><i class="far fa-clock text-gray-400 mr-1"></i> {{ substr($gm->jam_mulai, 0, 5) }} - {{ substr($gm->jam_selesai, 0, 5) }}</span>
                    </div>
                    
                    {{-- Tombol Hapus --}}
                    <form id="delete-form-{{ $gm->id }}" action="/admin/guru-mapel/{{ $gm->id }}" method="POST" class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="openDeleteModal({{ $gm->id }}, '{{ addslashes($gm->user->name) }}', '{{ addslashes($gm->mapel->nama_mapel) }}', '{{ $gm->kelas->nama_kelas }}')" class="w-8 h-8 rounded-lg bg-white hover:bg-red-50 text-gray-400 hover:text-red-600 flex items-center justify-center transition border border-gray-100 hover:border-red-100 shadow-sm" title="Hapus Jadwal">
                            <i class="fas fa-trash-alt text-xs"></i>
                        </button>
                    </form>
                </div>

                {{-- Body Kartu: Kelas, Mapel, Guru --}}
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 rounded-xl bg-indigo-50 text-indigo-600 flex flex-col items-center justify-center border border-indigo-100 shrink-0 shadow-inner jadwal-kelas group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                        <span class="text-[9px] font-black uppercase opacity-70">Kelas</span>
                        <span class="font-black text-lg leading-none mt-0.5">{{ $gm->kelas->nama_kelas }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="font-bold text-gray-800 text-lg truncate jadwal-mapel group-hover:text-blue-600 transition-colors">{{ $gm->mapel->nama_mapel }}</div>
                        <div class="text-xs font-medium text-gray-500 flex items-center mt-1.5 truncate jadwal-guru">
                            <div class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mr-2"><i class="fas fa-user-tie text-[10px]"></i></div>
                            {{ $gm->user->name }}
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-3xl p-16 text-center border-2 border-gray-100 border-dashed">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-50 text-gray-300 mb-4 text-4xl shadow-inner">
                    <i class="fas fa-calendar-times"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800">Jadwal Masih Kosong</h3>
                <p class="text-gray-500 text-sm mt-2 max-w-sm mx-auto">Gunakan form di samping kiri untuk mulai membagi jadwal mengajar pada tahun ajaran ini.</p>
            </div>
        @endforelse
    </div>

    {{-- State Kosong Pencarian --}}
    <div id="emptySearchJadwal" class="hidden bg-white rounded-3xl p-16 text-center border-2 border-gray-100 border-dashed">
        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-50 text-gray-300 mb-4 text-4xl shadow-inner">
            <i class="fas fa-search-minus"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-800">Jadwal tidak ditemukan</h3>
        <p class="text-gray-500 text-sm mt-2 max-w-sm mx-auto">Tidak ada jadwal yang cocok. Coba sesuaikan filter hari, kelas, atau kata kunci pencarian Anda.</p>
    </div>

</div>