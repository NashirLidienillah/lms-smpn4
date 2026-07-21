{{-- ================= KANAN: DAFTAR MAPEL (GRID & SEARCH) ================= --}}
<div class="lg:col-span-2 space-y-4">
    
    {{-- Bagian Atas: Info Total & Search --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 flex flex-col md:flex-row justify-between items-center gap-4">
        <div class="flex items-center text-sm font-bold text-amber-700 bg-amber-50 px-4 py-2.5 rounded-xl border border-amber-100 w-full md:w-auto justify-center">
            <i class="fas fa-book text-amber-500 mr-2"></i> Total: {{ $mapel->count() }} Mapel Tersedia
        </div>

        {{-- Kotak Pencarian --}}
        <div class="relative w-full md:w-72">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                <i class="fas fa-search text-gray-400"></i>
            </div>
            <input type="text" id="searchMapel" oninput="applyMapelFilter()" class="bg-gray-50 border border-gray-200 text-gray-700 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 transition font-medium" placeholder="Cari nama pelajaran...">
        </div>
    </div>

    {{-- Grid Kartu Mapel --}}
    <div id="mapelGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
        @forelse($mapel as $m)
            <div class="mapel-card bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition-shadow group">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-orange-50 text-orange-500 flex items-center justify-center font-black text-xl border border-orange-100 shrink-0 group-hover:bg-orange-500 group-hover:text-white transition-colors">
                        {{ substr(trim($m->nama_mapel), 0, 1) }}
                    </div>
                    <div>
                        <div class="font-bold text-gray-800 text-sm leading-tight mapel-name">{{ $m->nama_mapel }}</div>
                        <div class="text-[10px] text-gray-400 font-black tracking-widest uppercase mt-1">Kode: MP-{{ str_pad($m->id, 3, '0', STR_PAD_LEFT) }}</div>
                    </div>
                </div>
                
                <form id="delete-form-{{ $m->id }}" action="/admin/mapel/{{ $m->id }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="openDeleteModal({{ $m->id }}, '{{ addslashes($m->nama_mapel) }}')" class="w-8 h-8 rounded-lg bg-gray-50 hover:bg-red-100 text-gray-400 hover:text-red-600 flex items-center justify-center transition opacity-0 group-hover:opacity-100" title="Hapus Mapel">
                        <i class="fas fa-trash-alt text-xs"></i>
                    </button>
                </form>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-2xl p-12 text-center border border-gray-100 border-dashed">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 text-gray-300 mb-4 text-3xl">
                    <i class="fas fa-book-dead"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-800">Belum ada data mata pelajaran</h3>
                <p class="text-gray-500 text-sm mt-1">Silakan tambahkan mata pelajaran baru melalui form di samping.</p>
            </div>
        @endforelse
    </div>

    {{-- State Kosong Pencarian --}}
    <div id="emptySearchMapel" class="hidden bg-white rounded-2xl p-12 text-center border border-gray-100 border-dashed">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 text-gray-300 mb-4 text-3xl">
            <i class="fas fa-search-minus"></i>
        </div>
        <h3 class="text-lg font-bold text-gray-800">Mata Pelajaran tidak ditemukan</h3>
        <p class="text-gray-500 text-sm mt-1">Coba gunakan kata kunci pencarian yang berbeda.</p>
    </div>

</div>