@extends('layouts.app')

@section('content')

{{-- ================= NOTIFIKASI TOAST MELAYANG ================= --}}
@if(session('success'))
    <div id="toast-success" class="fixed top-5 right-5 flex items-center w-full max-w-xs p-4 mb-4 text-gray-700 bg-white rounded-xl shadow-xl border-l-4 border-green-500 z-50 transition-all duration-500">
        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg"><i class="fas fa-check"></i></div>
        <div class="ml-3 text-sm font-medium">{{ session('success') }}</div>
        <button type="button" class="ml-auto bg-white text-gray-400 hover:text-gray-900 rounded-lg p-1.5 hover:bg-gray-100 h-8 w-8 transition" onclick="document.getElementById('toast-success').remove()"><i class="fas fa-times"></i></button>
    </div>
    <script>setTimeout(() => { document.getElementById('toast-success')?.remove(); }, 3500);</script>
@endif

@if(session('error'))
    <div id="toast-error" class="fixed top-5 right-5 flex items-center w-full max-w-xs p-4 mb-4 text-gray-700 bg-white rounded-xl shadow-xl border-l-4 border-red-500 z-50 transition-all duration-500">
        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg"><i class="fas fa-exclamation"></i></div>
        <div class="ml-3 text-sm font-medium">{{ session('error') }}</div>
        <button type="button" class="ml-auto bg-white text-gray-400 hover:text-gray-900 rounded-lg p-1.5 hover:bg-gray-100 h-8 w-8 transition" onclick="document.getElementById('toast-error').remove()"><i class="fas fa-times"></i></button>
    </div>
    <script>setTimeout(() => { document.getElementById('toast-error')?.remove(); }, 4000);</script>
@endif

<div class="space-y-6">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col md:flex-row items-start md:items-center justify-between relative overflow-hidden">
        <div class="absolute left-0 top-0 w-1.5 h-full bg-blue-600"></div>
        
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Manajemen Rombongan Belajar</h2>
            <p class="text-sm text-gray-500 mt-1">Mengelola penempatan siswa ke dalam kelas sesuai tahun ajaran berjalan.</p>
        </div>
        
        <div class="mt-4 md:mt-0 text-left md:text-right w-full md:w-auto">
            <span class="block text-xs text-gray-400 mb-1 uppercase tracking-wider font-bold">Tahun Akademik Aktif</span>
            <span class="bg-blue-50 border border-blue-100 text-blue-700 px-4 py-2 rounded-xl text-sm font-bold inline-flex items-center w-full md:w-auto justify-center">
                <i class="fas fa-calendar-check mr-2"></i> {{ $tahunAktif->nama_tahun }} (Semester {{ $tahunAktif->semester }})
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        
        {{-- ================= KIRI: FOLDER KELAS ================= --}}
        <div class="lg:col-span-1">
            <div class="sticky top-6 space-y-3">
                <div class="bg-white px-5 py-3.5 rounded-xl border border-gray-100 shadow-sm font-bold text-gray-700 flex items-center">
                    <i class="fas fa-layer-group text-blue-500 mr-2 text-lg"></i> Tingkat Kelas
                </div>

                @php
                    $groupedKelas = $kelas->groupBy(function($item) {
                        preg_match('/\d+/', $item->nama_kelas, $matches);
                        return $matches[0] ?? 'Lainnya';
                    });
                @endphp

                @forelse($groupedKelas as $tingkat => $kelasGroup)
                    <details class="group bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden" {{ (request('kelas_id') && $kelasGroup->contains('id', request('kelas_id'))) ? 'open' : '' }}>
                        <summary class="bg-gray-50 text-gray-800 p-3.5 font-bold text-sm cursor-pointer list-none flex justify-between items-center hover:bg-gray-100 transition select-none">
                            <span class="flex items-center"><i class="fas fa-folder text-yellow-400 mr-2 text-lg"></i> Tingkat {{ $tingkat }}</span>
                            <i class="fas fa-chevron-down text-gray-400 transition-transform duration-300 group-open:rotate-180"></i>
                        </summary>
                        
                        <div class="bg-white border-t border-gray-100 divide-y divide-gray-50">
                            @foreach($kelasGroup as $k)
                                <a href="/admin/rombel?kelas_id={{ $k->id }}" 
                                   class="flex items-center p-3.5 transition text-sm font-medium
                                   {{ request('kelas_id') == $k->id ? 'bg-blue-50 text-blue-700 border-l-4 border-l-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-600 border-l-4 border-transparent' }}">
                                    <i class="fas fa-door-open mr-2 {{ request('kelas_id') == $k->id ? 'text-blue-500' : 'text-gray-300' }}"></i> 
                                    Kelas {{ $k->nama_kelas }}
                                </a>
                            @endforeach
                        </div>
                    </details>
                @empty
                    <div class="p-5 text-center text-gray-500 text-sm bg-white rounded-xl border border-gray-100 shadow-sm">Belum ada Master Kelas.</div>
                @endforelse
            </div>
        </div>

        {{-- ================= KANAN: MANAJEMEN SISWA ================= --}}
        <div class="lg:col-span-3">
            @if($selectedKelas)
                
                {{-- Form Tambah Siswa --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 md:p-6 mb-6">
                    <h3 class="font-bold text-gray-800 mb-4 flex items-center">
                        <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center mr-3">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        Masukkan Siswa ke Kelas {{ $selectedKelas->nama_kelas }}
                    </h3>
                    
                    <form action="/admin/rombel/add" method="POST" class="flex flex-col sm:flex-row gap-3">
                        @csrf
                        <input type="hidden" name="kelas_id" value="{{ $selectedKelas->id }}">
                        
                        <div class="flex-1 relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <i class="fas fa-search-plus text-gray-400"></i>
                            </div>
                            <select name="user_id" required class="w-full pl-9 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 text-sm transition font-medium">
                                <option value="">-- Pilih Siswa yang Belum Punya Kelas --</option>
                                @foreach($siswaBelumAdaKelas as $s)
                                    <option value="{{ $s->id }}">{{ $s->name }} (NIS: {{ $s->username }})</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl text-sm font-bold transition shadow-sm whitespace-nowrap flex justify-center items-center">
                            <i class="fas fa-plus mr-2"></i> Tambahkan
                        </button>
                    </form>
                </div>

                {{-- Daftar Siswa di Kelas Ini --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    
                    {{-- Header & Fitur Pencarian --}}
                    <div class="bg-gray-50 px-5 py-4 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4">
                        <div class="flex items-center font-bold text-gray-700 w-full sm:w-auto">
                            <i class="fas fa-users mr-2 text-gray-400"></i> Daftar Siswa
                            <span class="ml-3 bg-blue-100 text-blue-700 py-1 px-3 rounded-full text-xs font-bold">{{ count($siswaDiKelas) }} Orang</span>
                        </div>
                        
                        {{-- Kotak Pencarian Siswa --}}
                        <div class="relative w-full sm:w-64">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" id="searchSiswa" oninput="applySiswaFilter()" class="bg-white border border-gray-200 text-gray-700 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full pl-9 p-2 shadow-sm transition" placeholder="Cari nama atau NIS...">
                        </div>
                    </div>
                    
                    {{-- Grid Kartu Siswa (Menggantikan Tabel) --}}
                    <div class="p-5">
                        <div id="siswaGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                            @forelse($siswaDiKelas as $siswa)
                                <div class="siswa-card bg-white p-3 rounded-xl border border-gray-200 shadow-sm flex items-center justify-between hover:border-blue-300 hover:shadow-md transition group">
                                    <div class="flex items-center gap-3 min-w-0">
                                        {{-- Avatar Inisial --}}
                                        <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-sm uppercase shrink-0 border border-blue-100">
                                            {{ substr($siswa->user->name, 0, 1) }}
                                        </div>
                                        
                                        {{-- Info Nama & NIS --}}
                                        <div class="min-w-0">
                                            <div class="font-bold text-gray-800 text-sm truncate siswa-name" title="{{ $siswa->user->name }}">{{ $siswa->user->name }}</div>
                                            <div class="text-[10px] font-mono text-gray-500 mt-0.5 siswa-nis tracking-widest"><i class="fas fa-id-badge text-gray-400 mr-1"></i>{{ $siswa->user->username }}</div>
                                        </div>
                                    </div>
                                    
                                    {{-- Tombol Keluarkan --}}
                                    <form id="remove-form-{{ $siswa->id }}" action="/admin/rombel/remove/{{ $siswa->id }}" method="POST" class="shrink-0 ml-2">
                                        @csrf
                                        <button type="button" onclick="openRemoveModal({{ $siswa->id }}, '{{ addslashes($siswa->user->name) }}')" class="w-8 h-8 rounded-lg bg-gray-50 hover:bg-orange-100 text-gray-400 hover:text-orange-600 flex items-center justify-center transition opacity-0 group-hover:opacity-100" title="Keluarkan dari kelas">
                                            <i class="fas fa-user-minus text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            @empty
                                <div class="col-span-full py-10 text-center">
                                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 text-gray-300 mb-4 text-3xl">
                                        <i class="fas fa-user-slash"></i>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-800">Kelas Masih Kosong</h3>
                                    <p class="text-gray-500 text-sm mt-1">Gunakan form di atas untuk memasukkan siswa ke kelas ini.</p>
                                </div>
                            @endforelse
                        </div>

                        {{-- State Kosong Pencarian --}}
                        <div id="emptySearchSiswa" class="hidden py-10 text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 text-gray-300 mb-4 text-3xl">
                                <i class="fas fa-search-minus"></i>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800">Siswa tidak ditemukan</h3>
                            <p class="text-gray-500 text-sm mt-1">Siswa tersebut mungkin tidak ada di kelas ini.</p>
                        </div>
                    </div>
                </div>

            @else
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 text-center h-full flex flex-col items-center justify-center min-h-[450px]">
                    <div class="w-24 h-24 bg-blue-50 text-blue-400 rounded-full flex items-center justify-center mb-6 text-4xl shadow-inner">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Pilih Kelas Terlebih Dahulu</h3>
                    <p class="text-gray-500 text-sm max-w-sm mx-auto leading-relaxed">
                        Silakan buka folder tingkat di sebelah kiri, lalu klik salah satu kelas untuk melihat dan mengelola daftar siswa di dalamnya.
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- ================= MODAL KONFIRMASI KELUARKAN ================= --}}
<div id="removeModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-slate-900/40 backdrop-blur-sm transition-opacity duration-300 opacity-0 px-4">
    <div id="removeModalContent" class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-sm transform scale-95 transition-transform duration-300 relative overflow-hidden">
        
        <div class="absolute -right-8 -top-8 w-32 h-32 bg-orange-50 rounded-full blur-2xl"></div>

        <div class="flex items-center justify-center w-16 h-16 mx-auto bg-orange-100 text-orange-600 rounded-full mb-4 border-4 border-white shadow-sm relative z-10">
            <i class="fas fa-user-minus text-2xl"></i>
        </div>
        
        <h3 class="text-xl font-bold text-center text-gray-800 mb-2 relative z-10">Keluarkan Siswa?</h3>
        <p class="text-center text-gray-500 text-sm mb-6 relative z-10">
            Yakin ingin mengeluarkan <span id="namaSiswaLabel" class="font-bold text-gray-800"></span> dari kelas ini?
        </p>
        
        <div class="flex space-x-3 relative z-10">
            <button onclick="closeRemoveModal()" class="flex-1 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-bold py-2.5 rounded-xl transition shadow-sm">
                Batal
            </button>
            <button onclick="submitRemoveForm()" class="flex-1 bg-orange-600 hover:bg-orange-700 text-white font-bold py-2.5 rounded-xl shadow-sm transition">
                Ya, Keluarkan
            </button>
        </div>
    </div>
</div>

<script>
    // --- LOGIKA LIVE SEARCH SISWA ---
    function applySiswaFilter() {
        const searchQuery = document.getElementById('searchSiswa').value.toLowerCase();
        let visibleCount = 0;
        
        document.querySelectorAll('.siswa-card').forEach(card => {
            const nama = card.querySelector('.siswa-name').innerText.toLowerCase();
            const nis = card.querySelector('.siswa-nis').innerText.toLowerCase();
            
            // Cek apakah input cocok dengan Nama atau NIS
            if (nama.includes(searchQuery) || nis.includes(searchQuery)) {
                card.style.display = 'flex';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        const emptyState = document.getElementById('emptySearchSiswa');
        const gridContainer = document.getElementById('siswaGrid');
        
        if (visibleCount === 0) {
            emptyState.classList.remove('hidden');
            gridContainer.classList.add('hidden');
        } else {
            emptyState.classList.add('hidden');
            gridContainer.classList.remove('hidden');
        }
    }

    // --- LOGIKA MODAL KELUARKAN SISWA ---
    let currentRemoveId = null;
    const removeModal = document.getElementById('removeModal');
    const removeModalContent = document.getElementById('removeModalContent');
    const namaSiswaLabel = document.getElementById('namaSiswaLabel');

    function openRemoveModal(id, nama) {
        currentRemoveId = id;
        namaSiswaLabel.innerText = nama; 
        
        removeModal.classList.remove('hidden');
        setTimeout(() => {
            removeModal.classList.remove('opacity-0');
            removeModalContent.classList.remove('scale-95');
            removeModalContent.classList.add('scale-100');
        }, 10);
    }

    function closeRemoveModal() {
        removeModal.classList.add('opacity-0');
        removeModalContent.classList.remove('scale-100');
        removeModalContent.classList.add('scale-95');
        setTimeout(() => { removeModal.classList.add('hidden'); currentRemoveId = null; }, 300);
    }

    function submitRemoveForm() {
        if (currentRemoveId) { document.getElementById('remove-form-' + currentRemoveId).submit(); }
    }
</script>

@endsection