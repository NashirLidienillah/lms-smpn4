@extends('layouts.app')

@section('content')

{{-- Toast Notifikasi --}}
@if(session('success'))
    <div id="toast-success" class="fixed top-5 right-5 flex items-center w-full max-w-xs p-4 mb-4 text-gray-700 bg-white rounded-lg shadow-xl border-l-4 border-green-500 z-50 transition-all duration-500">
        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg"><i class="fas fa-check"></i></div>
        <div class="ml-3 text-sm font-medium">{{ session('success') }}</div>
        <button type="button" class="ml-auto bg-white text-gray-400 hover:text-gray-900 rounded-lg p-1.5 hover:bg-gray-100 h-8 w-8 transition" onclick="document.getElementById('toast-success').remove()"><i class="fas fa-times"></i></button>
    </div>
    <script>setTimeout(() => { document.getElementById('toast-success')?.remove(); }, 3500);</script>
@endif

<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Manajemen Pengguna</h2>
        <p class="text-sm text-gray-500 mt-1">Kelola data Admin, Guru, dan Siswa dalam satu tempat.</p>
    </div>
    <a href="/admin/users/create" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-sm font-medium transition shadow-sm flex items-center">
        <i class="fas fa-plus mr-2"></i> Tambah Pengguna
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    
    <div class="bg-gray-50 px-5 py-4 border-b border-gray-200 flex flex-col lg:flex-row justify-between gap-4 items-center">
        <div class="flex flex-wrap gap-2 w-full lg:w-auto">
            <button onclick="changeTab('semua')" data-target="semua" class="tab-btn bg-blue-600 text-white shadow-md px-5 py-2 rounded-full text-sm font-bold transition-all duration-300 flex-1 lg:flex-none">
                <i class="fas fa-users mr-1"></i> Semua
            </button>
            <button onclick="changeTab('admin')" data-target="admin" class="tab-btn bg-white text-gray-600 hover:bg-gray-100 border border-gray-200 px-5 py-2 rounded-full text-sm font-bold transition-all duration-300 flex-1 lg:flex-none">
                <i class="fas fa-user-shield mr-1 text-red-500"></i> Admin
            </button>
            <button onclick="changeTab('guru')" data-target="guru" class="tab-btn bg-white text-gray-600 hover:bg-gray-100 border border-gray-200 px-5 py-2 rounded-full text-sm font-bold transition-all duration-300 flex-1 lg:flex-none">
                <i class="fas fa-chalkboard-teacher mr-1 text-blue-500"></i> Guru
            </button>
            <button onclick="changeTab('siswa')" data-target="siswa" class="tab-btn bg-white text-gray-600 hover:bg-gray-100 border border-gray-200 px-5 py-2 rounded-full text-sm font-bold transition-all duration-300 flex-1 lg:flex-none">
                <i class="fas fa-user-graduate mr-1 text-green-500"></i> Siswa
            </button>
        </div>

        <div class="relative w-full lg:w-72">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <i class="fas fa-search text-gray-400"></i>
            </div>
            <input type="text" id="searchInput" oninput="applyFilters()" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-full focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 shadow-sm transition" placeholder="Cari nama atau NIS/NIP...">
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-max">
            <thead>
                <tr class="bg-white text-gray-600 text-sm border-b">
                    <th class="p-4 font-semibold w-16 text-center">No</th>
                    <th class="p-4 font-semibold">Nama Lengkap</th>
                    <th class="p-4 font-semibold">Username / NIS / NIP</th>
                    <th class="p-4 font-semibold text-center">Role</th>
                    <th class="p-4 font-semibold text-center w-28">Aksi</th>
                </tr>
            </thead>
            <tbody id="userTableBody">
                @foreach($users as $index => $user)
                
                {{-- LOGIKA CEK KELAS SISWA (Hanya diproses untuk UI Modal) --}}
                @php
                    $infoKelas = 'Tidak Berlaku (Bukan Siswa)';
                    $isBelumMasukKelas = false;

                    if($user->role === 'siswa') {
                        $tahunAktif = \App\Models\TahunAkademik::where('status_aktif', true)->first();
                        if($tahunAktif) {
                            $rombel = \App\Models\Rombel::where('user_id', $user->id)->where('tahun_akademik_id', $tahunAktif->id)->first();
                            if($rombel) {
                                $infoKelas = 'Kelas ' . $rombel->kelas->nama_kelas;
                            } else {
                                $infoKelas = 'Siswa ini belum dimasukkan ke dalam kelas.';
                                $isBelumMasukKelas = true;
                            }
                        } else {
                            $infoKelas = 'Tahun akademik belum diatur.';
                            $isBelumMasukKelas = true;
                        }
                    }
                @endphp
                {{-- ======================================= --}}

                <tr class="user-row border-b hover:bg-gray-50 transition text-sm text-gray-800" data-role="{{ $user->role }}">
                    <td class="p-4 text-center font-medium text-gray-500 serial-number">{{ $index + 1 }}</td>
                    <td class="p-4 font-bold text-gray-700 searchable-data">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold mr-3 uppercase">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <span>{{ $user->name }}</span>
                        </div>
                    </td>
                    <td class="p-4 text-gray-500 searchable-data">{{ $user->username }}</td>
                    <td class="p-4 text-center">
                        @if($user->role === 'admin')
                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold"><i class="fas fa-shield-alt mr-1"></i> Admin</span>
                        @elseif($user->role === 'guru')
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold"><i class="fas fa-chalkboard-teacher mr-1"></i> Guru</span>
                        @else
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold"><i class="fas fa-user-graduate mr-1"></i> Siswa</span>
                        @endif
                    </td>
                    <td class="p-4 text-center">
                        <div class="flex justify-center space-x-2">
                            {{-- Tombol Lihat Detail (Mata) --}}
                            <button type="button" onclick="openDetailModal('{{ addslashes($user->name) }}', '{{ $user->username }}', '{{ $user->role }}', '{{ $infoKelas }}', {{ $isBelumMasukKelas ? 'true' : 'false' }})" class="text-teal-500 hover:bg-teal-50 p-2 rounded transition" title="Lihat Detail Profil">
                                <i class="fas fa-eye"></i>
                            </button>

                            {{-- Tombol Edit --}}
                            <a href="/admin/users/{{ $user->id }}/edit" class="text-blue-500 hover:bg-blue-50 p-2 rounded transition" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>

                            {{-- Tombol Hapus --}}
                            <form action="/admin/users/{{ $user->id }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus pengguna ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:bg-red-50 p-2 rounded transition" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach

                <tr id="empty-state" style="display: none;">
                    <td colspan="5" class="p-12 text-center flex flex-col items-center justify-center">
                        <div class="w-16 h-16 bg-gray-100 text-gray-400 rounded-full flex items-center justify-center mb-3 text-2xl">
                            <i class="fas fa-search-minus"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-700 mb-1">Data Tidak Ditemukan</h3>
                        <p class="text-gray-500 text-sm">Coba gunakan kata kunci lain atau periksa tab role yang sedang aktif.</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

{{-- ================= MODAL DETAIL PROFIL (KTP VIRTUAL) ================= --}}
<div id="detailModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black bg-opacity-40 backdrop-blur-sm transition-opacity duration-300 opacity-0">
    <div id="detailModalContent" class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform scale-95 transition-transform duration-300 overflow-hidden">
        
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 p-6 text-center relative">
            <button onclick="closeDetailModal()" class="absolute top-4 right-4 text-white/80 hover:text-white transition">
                <i class="fas fa-times text-xl"></i>
            </button>
            <div id="modalAvatar" class="w-20 h-20 bg-white text-blue-600 rounded-full flex items-center justify-center text-3xl font-bold mx-auto mb-3 shadow-lg uppercase">
                A
            </div>
            <h3 id="modalName" class="text-xl font-bold text-white">Nama Pengguna</h3>
            <p id="modalRoleBadge" class="text-blue-100 text-sm font-medium mt-1 uppercase tracking-widest">ROLE</p>
        </div>

        <div class="p-6 space-y-4">
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase">Username / NIS / NIP</label>
                <div class="mt-1 text-gray-800 font-medium" id="modalUsername">12345678</div>
            </div>

            <div id="kelasSection" style="display: none;">
                <label class="block text-xs font-bold text-gray-400 uppercase">Status Rombongan Belajar</label>
                <div id="modalKelasContainer" class="mt-1 p-3 rounded-lg flex items-center">
                    <i id="modalKelasIcon" class="fas mr-3 text-lg"></i>
                    <span id="modalKelasText" class="font-medium text-sm"></span>
                </div>
            </div>
        </div>

        <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-end">
            <button onclick="closeDetailModal()" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-5 py-2 rounded-lg font-medium transition">
                Tutup
            </button>
        </div>
    </div>
</div>

{{-- SCRIPT UNTUK FILTER TAB, LIVE SEARCH & MODAL DETAIL --}}
<script>
    let currentRoleFilter = 'semua';

    function changeTab(role) {
        currentRoleFilter = role;
        document.querySelectorAll('.tab-btn').forEach(btn => {
            if(btn.dataset.target === role) {
                btn.classList.add('bg-blue-600', 'text-white', 'shadow-md');
                btn.classList.remove('bg-white', 'text-gray-600', 'hover:bg-gray-100');
            } else {
                btn.classList.remove('bg-blue-600', 'text-white', 'shadow-md');
                btn.classList.add('bg-white', 'text-gray-600', 'hover:bg-gray-100');
            }
        });
        applyFilters();
    }

    function applyFilters() {
        const searchQuery = document.getElementById('searchInput').value.toLowerCase();
        let visibleCount = 0;
        let serialCounter = 1; 
        
        document.querySelectorAll('.user-row').forEach(row => {
            const rowText = row.innerText.toLowerCase();
            const matchesRole = (currentRoleFilter === 'semua' || row.dataset.role === currentRoleFilter);
            const matchesSearch = rowText.includes(searchQuery);

            if (matchesRole && matchesSearch) {
                row.style.display = '';
                row.querySelector('.serial-number').innerText = serialCounter++;
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        const emptyState = document.getElementById('empty-state');
        if (visibleCount === 0) {
            emptyState.style.display = '';
        } else {
            emptyState.style.display = 'none';
        }
    }

    // ================= SCRIPT MODAL DETAIL =================
    const detailModal = document.getElementById('detailModal');
    const detailModalContent = document.getElementById('detailModalContent');

    function openDetailModal(name, username, role, infoKelas, isBelumMasukKelas) {
        // 1. Isi text dasar
        document.getElementById('modalAvatar').innerText = name.substring(0, 1);
        document.getElementById('modalName').innerText = name;
        document.getElementById('modalUsername').innerText = username;
        document.getElementById('modalRoleBadge').innerText = role;

        // 2. Atur visibilitas kelas (Saran brilian kamu)
        const kelasSection = document.getElementById('kelasSection');
        const kelasContainer = document.getElementById('modalKelasContainer');
        const kelasIcon = document.getElementById('modalKelasIcon');
        const kelasText = document.getElementById('modalKelasText');

        if (role === 'siswa') {
            kelasSection.style.display = 'block';
            kelasText.innerText = infoKelas;

            if (isBelumMasukKelas) {
                // UI Siswa Belum Punya Kelas (Merah)
                kelasContainer.className = "mt-1 p-3 rounded-lg border border-red-200 bg-red-50 flex items-center text-red-700";
                kelasIcon.className = "fas fa-exclamation-triangle mr-3 text-lg";
            } else {
                // UI Siswa Sudah Punya Kelas (Hijau)
                kelasContainer.className = "mt-1 p-3 rounded-lg border border-green-200 bg-green-50 flex items-center text-green-700";
                kelasIcon.className = "fas fa-check-circle mr-3 text-lg";
            }
        } else {
            // Sembunyikan jika Admin atau Guru
            kelasSection.style.display = 'none';
        }

        // 3. Tampilkan Pop-up
        detailModal.classList.remove('hidden');
        setTimeout(() => {
            detailModal.classList.remove('opacity-0');
            detailModalContent.classList.remove('scale-95');
            detailModalContent.classList.add('scale-100');
        }, 10);
    }

    function closeDetailModal() {
        detailModal.classList.add('opacity-0');
        detailModalContent.classList.remove('scale-100');
        detailModalContent.classList.add('scale-95');
        setTimeout(() => { detailModal.classList.add('hidden'); }, 300);
    }
</script>

@endsection