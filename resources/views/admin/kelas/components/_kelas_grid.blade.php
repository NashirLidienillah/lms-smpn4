{{-- ================= KANAN: DAFTAR KELAS (GRID & FILTER) ================= --}}
<div class="lg:col-span-2 space-y-4">
    
    {{-- Bagian Atas: Tab Filter & Search --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 flex flex-col md:flex-row justify-between items-center gap-4">
        
        {{-- Tab Filter Tingkatan Kelas --}}
        <div class="flex overflow-x-auto hide-scrollbar gap-2 w-full md:w-auto" style="-ms-overflow-style: none; scrollbar-width: none;">
            <button onclick="filterKelas('semua')" data-target="semua" class="tab-kelas-btn bg-blue-600 text-white shadow-md px-5 py-2.5 rounded-xl text-sm font-bold transition-all duration-300 whitespace-nowrap">
                Semua Kelas
            </button>
            <button onclick="filterKelas('7')" data-target="7" class="tab-kelas-btn bg-gray-50 text-gray-500 hover:bg-gray-100 border border-gray-200 px-5 py-2.5 rounded-xl text-sm font-bold transition-all duration-300 whitespace-nowrap">
                Kelas 7
            </button>
            <button onclick="filterKelas('8')" data-target="8" class="tab-kelas-btn bg-gray-50 text-gray-500 hover:bg-gray-100 border border-gray-200 px-5 py-2.5 rounded-xl text-sm font-bold transition-all duration-300 whitespace-nowrap">
                Kelas 8
            </button>
            <button onclick="filterKelas('9')" data-target="9" class="tab-kelas-btn bg-gray-50 text-gray-500 hover:bg-gray-100 border border-gray-200 px-5 py-2.5 rounded-xl text-sm font-bold transition-all duration-300 whitespace-nowrap">
                Kelas 9
            </button>
        </div>

        {{-- Kotak Pencarian --}}
        <div class="relative w-full md:w-64">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                <i class="fas fa-search text-gray-400"></i>
            </div>
            <input type="text" id="searchKelas" oninput="applyKelasFilter()" class="bg-gray-50 border border-gray-200 text-gray-700 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 transition font-medium" placeholder="Cari 7A, 8B...">
        </div>
    </div>

    {{-- Grid Kartu Kelas --}}
    <div id="kelasGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
        @forelse($kelas as $k)
            @php
                $tingkat = substr(trim($k->nama_kelas), 0, 1);
                if (!in_array($tingkat, ['7', '8', '9'])) {
                    $tingkat = 'lainnya'; 
                }
            @endphp

            <div class="kelas-card bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition-shadow group" data-tingkat="{{ $tingkat }}">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center font-black text-lg border border-purple-100 shrink-0 group-hover:bg-purple-600 group-hover:text-white transition-colors">
                        {{ $k->nama_kelas }}
                    </div>
                    <div>
                        <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-0.5">Ruang Kelas</span>
                        <div class="text-xs text-gray-500 font-medium">ID: #{{ str_pad($k->id, 4, '0', STR_PAD_LEFT) }}</div>
                    </div>
                </div>
                
                <form id="delete-form-{{ $k->id }}" action="/admin/kelas/{{ $k->id }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="openDeleteModal({{ $k->id }}, '{{ $k->nama_kelas }}')" class="w-8 h-8 rounded-lg bg-gray-50 hover:bg-red-100 text-gray-400 hover:text-red-600 flex items-center justify-center transition opacity-0 group-hover:opacity-100" title="Hapus Kelas">
                        <i class="fas fa-trash-alt text-xs"></i>
                    </button>
                </form>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-2xl p-12 text-center border border-gray-100 border-dashed">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 text-gray-300 mb-4 text-3xl">
                    <i class="fas fa-school"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-800">Belum ada data kelas</h3>
                <p class="text-gray-500 text-sm mt-1">Silakan tambahkan kelas baru melalui form di samping.</p>
            </div>
        @endforelse
    </div>

    {{-- State Kosong Pencarian --}}
    <div id="emptySearchKelas" class="hidden bg-white rounded-2xl p-12 text-center border border-gray-100 border-dashed">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 text-gray-300 mb-4 text-3xl">
            <i class="fas fa-search"></i>
        </div>
        <h3 class="text-lg font-bold text-gray-800">Kelas tidak ditemukan</h3>
        <p class="text-gray-500 text-sm mt-1">Coba gunakan nama kelas yang berbeda.</p>
    </div>

</div>