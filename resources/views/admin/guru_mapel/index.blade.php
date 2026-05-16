@extends('layouts.app')

@section('content')

{{-- ================= NOTIFIKASI TOAST MELAYANG ================= --}}
@if(session('success'))
    <div id="toast-success" class="fixed top-5 right-5 flex items-center w-full max-w-xs p-4 mb-4 text-gray-700 bg-white rounded-xl shadow-xl border-l-4 border-emerald-500 z-50 transition-all duration-500">
        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-emerald-500 bg-emerald-100 rounded-lg"><i class="fas fa-check"></i></div>
        <div class="ml-3 text-sm font-medium">{{ session('success') }}</div>
        <button type="button" class="ml-auto bg-white text-gray-400 hover:text-gray-900 rounded-lg p-1.5 hover:bg-gray-100 h-8 w-8 transition" onclick="document.getElementById('toast-success').remove()"><i class="fas fa-times"></i></button>
    </div>
    <script>setTimeout(() => { document.getElementById('toast-success')?.remove(); }, 3500);</script>
@endif

@if(session('error'))
    <div id="toast-error" class="fixed top-5 right-5 flex items-center w-full max-w-xs p-4 mb-4 text-gray-700 bg-white rounded-xl shadow-xl border-l-4 border-red-500 z-50 transition-all duration-500">
        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg"><i class="fas fa-exclamation-triangle"></i></div>
        <div class="ml-3 text-sm font-medium leading-tight">{{ session('error') }}</div>
        <button type="button" class="ml-auto bg-white text-gray-400 hover:text-gray-900 rounded-lg p-1.5 hover:bg-gray-100 h-8 w-8 transition" onclick="document.getElementById('toast-error').remove()"><i class="fas fa-times"></i></button>
    </div>
    <script>setTimeout(() => { document.getElementById('toast-error')?.remove(); }, 4500);</script>
@endif

@if($errors->any())
    <div id="toast-validation" class="fixed top-5 right-5 flex items-center w-full max-w-xs p-4 mb-4 text-gray-700 bg-white rounded-xl shadow-xl border-l-4 border-amber-500 z-50 transition-all duration-500">
        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-amber-500 bg-amber-100 rounded-lg"><i class="fas fa-exclamation-circle"></i></div>
        <div class="ml-3 text-sm font-medium leading-tight">{{ $errors->first() }}</div>
        <button type="button" class="ml-auto bg-white text-gray-400 hover:text-gray-900 rounded-lg p-1.5 hover:bg-gray-100 h-8 w-8 transition" onclick="document.getElementById('toast-validation').remove()"><i class="fas fa-times"></i></button>
    </div>
    <script>setTimeout(() => { document.getElementById('toast-validation')?.remove(); }, 4500);</script>
@endif
{{-- ========================================================= --}}

<div class="space-y-6">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col md:flex-row items-start md:items-center justify-between relative overflow-hidden">
        <div class="absolute left-0 top-0 w-1.5 h-full bg-blue-600"></div>
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Manajemen Jadwal Pelajaran</h2>
            <p class="text-sm text-gray-500 mt-1">Mengatur jadwal mengajar guru pada tahun ajaran aktif.</p>
        </div>
        <div class="mt-4 md:mt-0 text-left md:text-right w-full md:w-auto">
            <span class="block text-xs text-gray-400 mb-1 uppercase tracking-wider font-bold">Tahun Akademik Aktif</span>
            <span class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-2 rounded-xl text-sm font-bold inline-flex items-center w-full md:w-auto justify-center">
                <i class="fas fa-calendar-check mr-2"></i> {{ $tahunAktif->nama_tahun }} ({{ $tahunAktif->semester }})
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        {{-- ================= KIRI: FORM TAMBAH JADWAL ================= --}}
        <div class="lg:col-span-4">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden sticky top-6">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 font-bold text-gray-700 flex items-center">
                    <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center mr-3">
                        <i class="fas fa-clock"></i>
                    </div>
                    Buat Jadwal Baru
                </div>
                <form action="/admin/guru-mapel" method="POST" class="p-6 space-y-4">
                    @csrf
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-600 mb-1.5">Pilih Kelas</label>
                        <select name="kelas_id" required class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 text-sm">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($kelas as $k)
                                <option value="{{ $k->id }}">Kelas {{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-600 mb-1.5">Mata Pelajaran</label>
                        <select name="mapel_id" required class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 text-sm">
                            <option value="">-- Pilih Mapel --</option>
                            @foreach($mapels as $mapel)
                                <option value="{{ $mapel->id }}">{{ $mapel->nama_mapel }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-600 mb-1.5">Guru Pengajar</label>
                        <select name="user_id" required class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 text-sm">
                            <option value="">-- Pilih Guru --</option>
                            @foreach($gurus as $guru)
                                <option value="{{ $guru->id }}">{{ $guru->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-1 gap-4 bg-blue-50/50 p-4 rounded-xl border border-blue-100/50">
                        <div>
                            <label class="block text-xs font-bold text-blue-800 uppercase mb-1.5">Hari</label>
                            <select name="hari" required class="w-full p-2.5 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                                <option value="Senin">Senin</option>
                                <option value="Selasa">Selasa</option>
                                <option value="Rabu">Rabu</option>
                                <option value="Kamis">Kamis</option>
                                <option value="Jumat">Jumat</option>
                                <option value="Sabtu">Sabtu</option>
                            </select>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-blue-800 uppercase mb-1.5">Jam Mulai</label>
                                <input type="time" name="jam_mulai" required class="w-full p-2.5 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm font-mono">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-blue-800 uppercase mb-1.5">Jam Selesai</label>
                                <input type="time" name="jam_selesai" required class="w-full p-2.5 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm font-mono">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3.5 rounded-xl transition shadow-sm font-bold flex items-center justify-center">
                        <i class="fas fa-plus-circle mr-2"></i> Tambahkan Jadwal
                    </button>
                </form>
            </div>
        </div>

        {{-- ================= KANAN: DAFTAR JADWAL GRID ================= --}}
        <div class="lg:col-span-8 space-y-4">
            
            {{-- Navigasi Filter & Pencarian --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 flex flex-col xl:flex-row justify-between items-center gap-4">
                
                {{-- Bagian Kiri: Filter Hari & Filter Kelas --}}
                <div class="flex flex-col md:flex-row items-center gap-3 w-full xl:w-auto">
                    {{-- Tab Filter Hari --}}
                    <div class="flex overflow-x-auto hide-scrollbar gap-2 w-full md:w-auto" style="-ms-overflow-style: none; scrollbar-width: none;">
                        <button onclick="filterHari('semua')" data-target="semua" class="tab-hari-btn bg-blue-600 text-white shadow-md px-4 py-2 rounded-xl text-xs font-bold transition-all duration-300 whitespace-nowrap">
                            Semua
                        </button>
                        @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $h)
                        <button onclick="filterHari('{{ $h }}')" data-target="{{ $h }}" class="tab-hari-btn bg-gray-50 text-gray-500 hover:bg-gray-100 border border-gray-200 px-4 py-2 rounded-xl text-xs font-bold transition-all duration-300 whitespace-nowrap">
                            {{ $h }}
                        </button>
                        @endforeach
                    </div>

                    {{-- Dropdown Filter Kelas Baru --}}
                    <div class="w-full md:w-40 shrink-0">
                        <select id="filterKelasDropdown" onchange="filterKelas(this.value)" class="bg-gray-50 border border-gray-200 text-gray-700 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2 transition font-bold cursor-pointer">
                            <option value="semua">Semua Kelas</option>
                            @foreach($kelas as $k)
                                <option value="{{ $k->nama_kelas }}">Kelas {{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Kotak Pencarian --}}
                <div class="relative w-full xl:w-56 shrink-0">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" id="searchJadwal" oninput="applyJadwalFilter()" class="bg-gray-50 border border-gray-200 text-gray-700 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2 transition font-medium" placeholder="Cari Guru, Mapel...">
                </div>
            </div>

            {{-- Grid Kartu Jadwal Bento --}}
            <div id="jadwalGrid" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse($guruMapels as $gm)
                    {{-- Tambahkan data-kelas untuk ditangkap oleh JS --}}
                    <div class="jadwal-card bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col hover:shadow-md transition-shadow relative group" data-hari="{{ $gm->hari }}" data-kelas="{{ $gm->kelas->nama_kelas }}">
                        
                        {{-- Header Kartu: Jam & Hari --}}
                        <div class="flex justify-between items-center mb-4 border-b border-gray-50 pb-3">
                            <div class="flex items-center gap-2.5">
                                <span class="bg-blue-50 text-blue-600 px-2.5 py-1 rounded-md text-[10px] font-black uppercase tracking-widest border border-blue-100">{{ $gm->hari }}</span>
                                <span class="text-sm font-black text-gray-700 font-mono"><i class="far fa-clock text-gray-400 mr-1"></i> {{ substr($gm->jam_mulai, 0, 5) }} - {{ substr($gm->jam_selesai, 0, 5) }}</span>
                            </div>
                            
                            {{-- Tombol Hapus (Muncul saat hover) --}}
                            <form id="delete-form-{{ $gm->id }}" action="/admin/guru-mapel/{{ $gm->id }}" method="POST" class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="openDeleteModal({{ $gm->id }}, '{{ addslashes($gm->user->name) }}', '{{ addslashes($gm->mapel->nama_mapel) }}', '{{ $gm->kelas->nama_kelas }}')" class="w-8 h-8 rounded-lg bg-white hover:bg-red-50 text-gray-400 hover:text-red-600 flex items-center justify-center transition border border-gray-100 hover:border-red-100 shadow-sm" title="Hapus Jadwal">
                                    <i class="fas fa-trash-alt text-xs"></i>
                                </button>
                            </form>
                        </div>

                        {{-- Body Kartu: Kelas, Mapel, Guru --}}
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-black text-sm border border-indigo-100 shrink-0 shadow-inner jadwal-kelas">
                                {{ $gm->kelas->nama_kelas }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="font-bold text-gray-800 text-base truncate jadwal-mapel">{{ $gm->mapel->nama_mapel }}</div>
                                <div class="text-xs text-gray-500 flex items-center mt-1 truncate jadwal-guru">
                                    <i class="fas fa-user-tie text-emerald-500 mr-1.5"></i> {{ $gm->user->name }}
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white rounded-2xl p-12 text-center border border-gray-100 border-dashed">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 text-gray-300 mb-4 text-3xl">
                            <i class="fas fa-calendar-times"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800">Jadwal Masih Kosong</h3>
                        <p class="text-gray-500 text-sm mt-1">Gunakan form di samping untuk mulai membagi jadwal mengajar.</p>
                    </div>
                @endforelse
            </div>

            {{-- State Kosong Pencarian --}}
            <div id="emptySearchJadwal" class="hidden bg-white rounded-2xl p-12 text-center border border-gray-100 border-dashed">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 text-gray-300 mb-4 text-3xl">
                    <i class="fas fa-search-minus"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-800">Jadwal tidak ditemukan</h3>
                <p class="text-gray-500 text-sm mt-1">Coba sesuaikan filter hari, kelas, atau kata kunci pencarian.</p>
            </div>

        </div>
    </div>
</div>

{{-- MODAL KONFIRMASI HAPUS --}}
<div id="deleteModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-slate-900/40 backdrop-blur-sm transition-opacity duration-300 opacity-0 px-4">
    <div id="deleteModalContent" class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-sm transform scale-95 transition-transform duration-300 relative overflow-hidden">
        
        <div class="absolute -right-8 -top-8 w-32 h-32 bg-red-50 rounded-full blur-2xl"></div>

        <div class="flex items-center justify-center w-16 h-16 mx-auto bg-red-100 text-red-600 rounded-full mb-4 border-4 border-white shadow-sm relative z-10">
            <i class="fas fa-calendar-times text-2xl"></i>
        </div>
        
        <h3 class="text-xl font-bold text-center text-gray-800 mb-2 relative z-10">Hapus Jadwal?</h3>
        <p class="text-center text-gray-500 text-sm mb-4 relative z-10 leading-relaxed">
            Yakin ingin menghapus jadwal <span class="font-bold text-gray-800" id="detailMapelLabel"></span> di <span class="font-bold text-indigo-600" id="detailKelasLabel"></span>?
        </p>
        <div class="text-center mb-6 relative z-10">
            <span class="inline-block bg-gray-100 text-gray-600 text-[10px] font-bold px-2 py-1 rounded"><i class="fas fa-user-tie mr-1"></i> <span id="detailGuruLabel"></span></span>
        </div>
        
        <div class="flex space-x-3 relative z-10">
            <button onclick="closeDeleteModal()" class="flex-1 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-bold py-2.5 rounded-xl transition shadow-sm">
                Batal
            </button>
            <button onclick="submitDeleteForm()" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-2.5 rounded-xl shadow-sm transition">
                Ya, Hapus
            </button>
        </div>
    </div>
</div>

<script>
    // --- LOGIKA FILTER TAB HARI, DROPDOWN KELAS & LIVE SEARCH ---
    let currentHariFilter = 'semua';
    let currentKelasFilter = 'semua';

    function filterHari(hari) {
        currentHariFilter = hari;
        
        // Ubah styling tombol tab
        document.querySelectorAll('.tab-hari-btn').forEach(btn => {
            if(btn.dataset.target === hari) {
                btn.classList.add('bg-blue-600', 'text-white', 'shadow-md');
                btn.classList.remove('bg-gray-50', 'text-gray-500', 'hover:bg-gray-100', 'border', 'border-gray-200');
            } else {
                btn.classList.remove('bg-blue-600', 'text-white', 'shadow-md');
                btn.classList.add('bg-gray-50', 'text-gray-500', 'hover:bg-gray-100', 'border', 'border-gray-200');
            }
        });
        
        applyJadwalFilter();
    }

    function filterKelas(kelas) {
        currentKelasFilter = kelas;
        applyJadwalFilter();
    }

    function applyJadwalFilter() {
        const searchQuery = document.getElementById('searchJadwal').value.toLowerCase();
        let visibleCount = 0;
        
        document.querySelectorAll('.jadwal-card').forEach(card => {
            const cardHari = card.dataset.hari;
            const cardKelas = card.dataset.kelas; // Menangkap data kelas dari elemen HTML
            
            const namaMapel = card.querySelector('.jadwal-mapel').innerText.toLowerCase();
            const namaGuru = card.querySelector('.jadwal-guru').innerText.toLowerCase();
            const namaKelasText = card.querySelector('.jadwal-kelas').innerText.toLowerCase(); 
            
            // Pengecekan multi-kondisi (Hari + Kelas + Search harus cocok semua)
            const matchesHari = (currentHariFilter === 'semua' || cardHari === currentHariFilter);
            const matchesKelas = (currentKelasFilter === 'semua' || cardKelas === currentKelasFilter);
            const matchesSearch = namaMapel.includes(searchQuery) || namaGuru.includes(searchQuery) || namaKelasText.includes(searchQuery);

            if (matchesHari && matchesKelas && matchesSearch) {
                card.style.display = 'flex';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        // Menampilkan kotak error jika tidak ada hasil
        const emptyState = document.getElementById('emptySearchJadwal');
        const gridContainer = document.getElementById('jadwalGrid');
        
        if (visibleCount === 0) {
            emptyState.classList.remove('hidden');
            gridContainer.classList.add('hidden');
        } else {
            emptyState.classList.add('hidden');
            gridContainer.classList.remove('hidden');
        }
    }

    // --- LOGIKA MODAL HAPUS ---
    let currentDeleteId = null;
    const deleteModal = document.getElementById('deleteModal');
    const deleteModalContent = document.getElementById('deleteModalContent');
    const detailGuruLabel = document.getElementById('detailGuruLabel');
    const detailMapelLabel = document.getElementById('detailMapelLabel');
    const detailKelasLabel = document.getElementById('detailKelasLabel');

    function openDeleteModal(id, namaGuru, namaMapel, namaKelas) {
        currentDeleteId = id;
        detailGuruLabel.innerText = namaGuru; 
        detailMapelLabel.innerText = namaMapel; 
        detailKelasLabel.innerText = 'Kelas ' + namaKelas; 
        
        deleteModal.classList.remove('hidden');
        setTimeout(() => {
            deleteModal.classList.remove('opacity-0');
            deleteModalContent.classList.remove('scale-95');
            deleteModalContent.classList.add('scale-100');
        }, 10);
    }

    function closeDeleteModal() {
        deleteModal.classList.add('opacity-0');
        deleteModalContent.classList.remove('scale-100');
        deleteModalContent.classList.add('scale-95');
        setTimeout(() => { 
            deleteModal.classList.add('hidden'); 
            currentDeleteId = null; 
        }, 300);
    }

    function submitDeleteForm() {
        if (currentDeleteId) { document.getElementById('delete-form-' + currentDeleteId).submit(); }
    }
</script>

@endsection