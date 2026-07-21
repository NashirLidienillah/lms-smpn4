{{-- ================= KANAN: MANAJEMEN SISWA ================= --}}
<div class="lg:col-span-3">
    @if($selectedKelas)
        
        {{-- Form Tambah Siswa (Diperbarui dengan Alpine JS Searchable Dropdown) --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-visible mb-6">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex items-center font-bold text-gray-800 rounded-t-2xl">
                <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center mr-3">
                    <i class="fas fa-user-plus"></i>
                </div>
                Masukkan Siswa ke Kelas {{ $selectedKelas->nama_kelas }}
            </div>
            
            <div class="p-6">
                <form action="/admin/rombel/add" method="POST" class="flex flex-col sm:flex-row gap-4 items-start">
                    @csrf
                    <input type="hidden" name="kelas_id" value="{{ $selectedKelas->id }}">
                    
                    {{-- Dropdown Searchable Custom --}}
                    <div class="flex-1 w-full" 
                         x-data="{ 
                            open: false, 
                            search: '', 
                            selectedId: '', 
                            selectedName: '',
                            options: [
                                @foreach($siswaBelumAdaKelas as $s)
                                    { id: '{{ $s->id }}', name: '{{ addslashes($s->name) }}', nis: '{{ addslashes($s->username) }}' },
                                @endforeach
                            ],
                            get filteredOptions() {
                                if (this.search === '') return this.options;
                                return this.options.filter(opt => 
                                    opt.name.toLowerCase().includes(this.search.toLowerCase()) || 
                                    opt.nis.toLowerCase().includes(this.search.toLowerCase())
                                );
                            }
                         }">
                        
                        <input type="hidden" name="user_id" x-model="selectedId" required>
                        
                        <div class="relative w-full">
                            {{-- Tombol Pemicu Dropdown --}}
                            <button @click="open = !open" @click.outside="open = false" type="button" 
                                class="w-full p-3.5 bg-white border border-gray-200 rounded-xl text-sm font-bold flex justify-between items-center focus:ring-2 focus:ring-blue-500 transition-all shadow-sm outline-none">
                                <div class="flex items-center text-gray-700 truncate">
                                    <i class="fas fa-search-plus text-gray-400 mr-3"></i>
                                    <span x-text="selectedName || '-- Cari dan Pilih Siswa --'" :class="selectedName ? 'text-gray-800' : 'text-gray-400'"></span>
                                </div>
                                <i class="fas fa-chevron-down text-gray-400 transition-transform duration-300 ml-2" :class="open ? 'rotate-180' : ''"></i>
                            </button>

                            {{-- Popup Menu dengan Kotak Pencarian --}}
                            <div x-show="open" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 translate-y-2"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 translate-y-2"
                                 style="display: none;"
                                 class="absolute z-50 w-full mt-2 bg-white border border-gray-100 rounded-xl shadow-2xl overflow-hidden flex flex-col">
                                
                                {{-- Kotak Cari Live di dalam Dropdown --}}
                                <div class="p-2 border-b border-gray-100 bg-gray-50">
                                    <input x-model="search" type="text" placeholder="Ketik nama atau NIS..." 
                                        class="w-full p-2.5 bg-white border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none transition-all"
                                        @click.stop>
                                </div>

                                {{-- Daftar Opsi Siswa --}}
                                <div class="max-h-64 overflow-y-auto overflow-x-hidden p-1 custom-scrollbar">
                                    <template x-for="opt in filteredOptions" :key="opt.id">
                                        <div @click="selectedId = opt.id; selectedName = opt.name + ' (NIS: ' + opt.nis + ')'; open = false; search = ''" 
                                             class="px-3 py-3 text-sm cursor-pointer rounded-lg transition-colors flex flex-col mb-1 hover:bg-blue-50"
                                             :class="selectedId === opt.id ? 'bg-blue-50 text-blue-700' : 'text-gray-700'">
                                             <div class="font-bold truncate" x-text="opt.name"></div>
                                             <div class="text-[10px] text-gray-500 font-mono mt-0.5"><i class="fas fa-id-badge mr-1 opacity-50"></i><span x-text="opt.nis"></span></div>
                                        </div>
                                    </template>
                                    <div x-show="filteredOptions.length === 0" class="p-4 text-center text-xs text-gray-400 font-bold">
                                        Siswa tidak ditemukan.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white px-8 py-3.5 rounded-xl text-sm font-black transition-all shadow-lg shadow-blue-100 uppercase tracking-widest whitespace-nowrap flex justify-center items-center h-full shrink-0">
                        <i class="fas fa-plus mr-2"></i> Tambah
                    </button>
                </form>
            </div>
        </div>

        {{-- Daftar Siswa di Kelas Ini --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            
            {{-- Header & Fitur Pencarian --}}
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="flex items-center font-bold text-gray-700 w-full sm:w-auto">
                    <i class="fas fa-users mr-3 text-gray-400 text-lg"></i> Daftar Siswa
                    <span class="ml-3 bg-blue-100 text-blue-700 py-1.5 px-3 rounded-lg text-[10px] uppercase tracking-widest font-black border border-blue-200 shadow-sm">{{ count($siswaDiKelas) }} Orang</span>
                </div>
                
                {{-- Kotak Pencarian Siswa --}}
                <div class="relative w-full sm:w-72">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" id="searchSiswa" oninput="applySiswaFilter()" class="bg-white border border-gray-200 text-gray-700 text-sm rounded-xl focus:ring-2 focus:ring-blue-500 block w-full pl-10 p-2.5 shadow-sm transition outline-none" placeholder="Cari nama atau NIS...">
                </div>
            </div>
            
            {{-- Grid Kartu Siswa (Bento Style) --}}
            <div class="p-6 bg-slate-50/50">
                <div id="siswaGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($siswaDiKelas as $siswa)
                        <div class="siswa-card bg-white p-4 rounded-2xl border border-gray-200 shadow-sm flex items-center justify-between hover:border-blue-300 hover:shadow-lg transition-all duration-300 group">
                            <div class="flex items-center gap-3.5 min-w-0">
                                {{-- Avatar Inisial --}}
                                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-blue-50 to-indigo-50 text-blue-600 flex items-center justify-center font-black text-sm uppercase shrink-0 border border-blue-100 shadow-inner">
                                    {{ substr($siswa->user->name, 0, 1) }}
                                </div>
                                
                                {{-- Info Nama & NIS --}}
                                <div class="min-w-0">
                                    <div class="font-bold text-gray-800 text-sm truncate siswa-name group-hover:text-blue-600 transition-colors" title="{{ $siswa->user->name }}">{{ $siswa->user->name }}</div>
                                    <div class="text-[10px] font-mono font-medium text-gray-500 mt-0.5 siswa-nis tracking-wider"><i class="fas fa-id-badge text-gray-400 mr-1.5"></i>{{ $siswa->user->username }}</div>
                                </div>
                            </div>
                            
                            {{-- Tombol Keluarkan --}}
                            <form id="remove-form-{{ $siswa->id }}" action="/admin/rombel/remove/{{ $siswa->id }}" method="POST" class="shrink-0 ml-3">
                                @csrf
                                <button type="button" onclick="openRemoveModal({{ $siswa->id }}, '{{ addslashes($siswa->user->name) }}')" class="w-9 h-9 rounded-xl bg-white hover:bg-red-50 text-gray-400 hover:text-red-600 flex items-center justify-center transition-all opacity-0 group-hover:opacity-100 border border-gray-100 hover:border-red-200 shadow-sm" title="Keluarkan dari kelas">
                                    <i class="fas fa-user-minus text-xs"></i>
                                </button>
                            </form>
                        </div>
                    @empty
                        <div class="col-span-full py-16 text-center bg-white rounded-2xl border border-gray-100 border-dashed">
                            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-50 text-gray-300 mb-4 text-4xl shadow-inner">
                                <i class="fas fa-user-slash"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800">Kelas Masih Kosong</h3>
                            <p class="text-gray-500 text-sm mt-2">Gunakan form di atas untuk memasukkan siswa yang belum memiliki kelas.</p>
                        </div>
                    @endforelse
                </div>

                {{-- State Kosong Pencarian --}}
                <div id="emptySearchSiswa" class="hidden py-16 text-center bg-white rounded-2xl border border-gray-100 border-dashed">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-50 text-gray-300 mb-4 text-4xl shadow-inner">
                        <i class="fas fa-search-minus"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800">Siswa tidak ditemukan</h3>
                    <p class="text-gray-500 text-sm mt-2">Pastikan nama atau NIS yang Anda cari sudah benar.</p>
                </div>
            </div>
        </div>

    @else
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 text-center h-full flex flex-col items-center justify-center min-h-[500px]">
            <div class="w-28 h-28 bg-blue-50 text-blue-400 rounded-full flex items-center justify-center mb-6 text-5xl shadow-inner border-[6px] border-white">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <h3 class="text-2xl font-black text-gray-800 mb-3">Pilih Kelas Terlebih Dahulu</h3>
            <p class="text-gray-500 text-sm max-w-sm mx-auto leading-relaxed font-medium">
                Silakan buka folder tingkat di sebelah kiri, lalu klik salah satu kelas untuk mulai mengelola daftar siswa di dalamnya.
            </p>
        </div>
    @endif
</div>