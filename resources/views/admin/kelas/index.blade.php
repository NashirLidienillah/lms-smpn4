@extends('layouts.app')

@section('content')

{{-- ================= NOTIFIKASI TOAST MELAYANG ================= --}}
@if(session('success'))
    <div id="toast-success" class="fixed top-5 right-5 flex items-center w-full max-w-xs p-4 mb-4 text-gray-700 bg-white rounded-xl shadow-xl border-l-4 border-green-500 z-50 transition-all duration-500" role="alert">
        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg"><i class="fas fa-check"></i></div>
        <div class="ml-3 text-sm font-medium">{{ session('success') }}</div>
        <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg p-1.5 hover:bg-gray-100 inline-flex h-8 w-8 transition" onclick="closeToast()">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <script>
        function closeToast() {
            const toast = document.getElementById('toast-success');
            if (toast) { toast.classList.add('opacity-0', 'translate-x-full'); setTimeout(() => toast.remove(), 500); }
        }
        setTimeout(() => { closeToast(); }, 3500);
    </script>
@endif

<div class="space-y-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Master Data Kelas</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola daftar ruang kelas untuk penempatan rombongan belajar.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- ================= KIRI: FORM TAMBAH KELAS ================= --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden sticky top-6">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 font-bold text-gray-700 flex items-center">
                    <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center mr-3">
                        <i class="fas fa-plus"></i>
                    </div>
                    Tambah Kelas Baru
                </div>
                <form action="/admin/kelas" method="POST" class="p-6 space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-bold text-gray-600 mb-2">Nama Kelas</label>
                        <input type="text" name="nama_kelas" value="{{ old('nama_kelas') }}" required placeholder="Contoh: 7A, 8B, 9C..."
                            class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition text-sm @error('nama_kelas') border-red-500 bg-red-50 @enderror">
                        @error('nama_kelas') 
                            <span class="text-xs text-red-500 mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span> 
                        @enderror
                    </div>
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl transition shadow-sm font-bold flex items-center justify-center">
                        <i class="fas fa-save mr-2"></i> Simpan Data Kelas
                    </button>
                </form>
            </div>
        </div>

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
                    {{-- Kita ambil angka pertama dari nama_kelas untuk menentukan tingkat (7, 8, atau 9) --}}
                    @php
                        $tingkat = substr(trim($k->nama_kelas), 0, 1);
                        if (!in_array($tingkat, ['7', '8', '9'])) {
                            $tingkat = 'lainnya'; // Jaga-jaga kalau ada kelas bernama "Ekskul" dsb
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
    </div>
</div>

{{-- ================= MODAL KONFIRMASI HAPUS ================= --}}
<div id="deleteModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-slate-900/40 backdrop-blur-sm transition-opacity duration-300 opacity-0 px-4">
    <div id="deleteModalContent" class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-sm transform scale-95 transition-transform duration-300 relative overflow-hidden">
        
        <div class="absolute -right-8 -top-8 w-32 h-32 bg-red-50 rounded-full blur-2xl"></div>

        <div class="flex items-center justify-center w-16 h-16 mx-auto bg-red-100 text-red-600 rounded-full mb-4 border-4 border-white shadow-sm relative z-10">
            <i class="fas fa-exclamation-triangle text-2xl"></i>
        </div>
        
        <h3 class="text-xl font-bold text-center text-gray-800 mb-2 relative z-10">Hapus Kelas <span id="modalClassName" class="text-red-600 font-black"></span>?</h3>
        <p class="text-center text-gray-500 text-sm mb-6 relative z-10">
            Aksi ini tidak dapat dibatalkan. Pastikan tidak ada siswa yang masih terdaftar di kelas ini.
        </p>
        
        <div class="flex space-x-3 relative z-10">
            <button onclick="closeDeleteModal()" class="flex-1 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-bold py-2.5 rounded-xl transition shadow-sm">
                Batal
            </button>
            <button onclick="submitDeleteForm()" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-2.5 rounded-xl shadow-sm hover:shadow-md transition">
                Ya, Hapus
            </button>
        </div>
    </div>
</div>

<script>
    // --- LOGIKA FILTER & SEARCH KELAS ---
    let currentTingkatFilter = 'semua';

    function filterKelas(tingkat) {
        currentTingkatFilter = tingkat;
        
        // Ubah warna tombol Tab yang aktif
        document.querySelectorAll('.tab-kelas-btn').forEach(btn => {
            if(btn.dataset.target === tingkat) {
                btn.classList.add('bg-blue-600', 'text-white', 'shadow-md');
                btn.classList.remove('bg-gray-50', 'text-gray-500', 'hover:bg-gray-100', 'border', 'border-gray-200');
            } else {
                btn.classList.remove('bg-blue-600', 'text-white', 'shadow-md');
                btn.classList.add('bg-gray-50', 'text-gray-500', 'hover:bg-gray-100', 'border', 'border-gray-200');
            }
        });
        
        applyKelasFilter();
    }

    function applyKelasFilter() {
        const searchQuery = document.getElementById('searchKelas').value.toLowerCase().replace(/\s+/g, ''); // Hapus spasi biar "7 A" kebaca "7A"
        let visibleCount = 0;
        
        document.querySelectorAll('.kelas-card').forEach(card => {
            // Ambil nama kelas dari dalam kotak ungu
            const namaKelas = card.querySelector('.text-lg').innerText.toLowerCase().replace(/\s+/g, '');
            const cardTingkat = card.dataset.tingkat;
            
            const matchesTingkat = (currentTingkatFilter === 'semua' || cardTingkat === currentTingkatFilter);
            const matchesSearch = namaKelas.includes(searchQuery);

            if (matchesTingkat && matchesSearch) {
                card.style.display = 'flex';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        // Tampilkan State Kosong jika tidak ada yang cocok
        const emptyState = document.getElementById('emptySearchKelas');
        const gridContainer = document.getElementById('kelasGrid');
        
        if (visibleCount === 0) {
            emptyState.classList.remove('hidden');
            gridContainer.classList.add('hidden');
        } else {
            emptyState.classList.add('hidden');
            gridContainer.classList.remove('hidden');
        }
    }

    // --- LOGIKA MODAL HAPUS KELAS ---
    let currentDeleteId = null;
    const deleteModal = document.getElementById('deleteModal');
    const deleteModalContent = document.getElementById('deleteModalContent');
    const modalClassName = document.getElementById('modalClassName');

    function openDeleteModal(id, namaKelas) {
        currentDeleteId = id;
        modalClassName.innerText = namaKelas; 
        
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
        if (currentDeleteId) {
            document.getElementById('delete-form-' + currentDeleteId).submit();
        }
    }
</script>

@endsection