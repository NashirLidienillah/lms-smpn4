@extends('layouts.app')

@section('content')

{{-- Toast Notifikasi --}}
@if(session('success'))
    <div id="toast-success" class="fixed top-5 right-5 flex items-center w-full max-w-xs p-4 mb-4 text-gray-700 bg-white rounded-xl shadow-xl border-l-4 border-green-500 z-50 transition-all duration-500">
        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg"><i class="fas fa-check"></i></div>
        <div class="ml-3 text-sm font-medium">{{ session('success') }}</div>
        <button type="button" class="ml-auto bg-white text-gray-400 hover:text-gray-900 rounded-lg p-1.5 hover:bg-gray-100 h-8 w-8 transition" onclick="document.getElementById('toast-success').remove()"><i class="fas fa-times"></i></button>
    </div>
    <script>setTimeout(() => { document.getElementById('toast-success')?.remove(); }, 3500);</script>
@endif

<div class="space-y-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Manajemen Pengguna</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola data Admin, Guru, dan Siswa dalam satu tempat.</p>
        </div>
        <a href="/admin/users/create" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-sm font-medium transition shadow-sm flex items-center w-full md:w-auto justify-center">
            <i class="fas fa-plus mr-2"></i> Tambah Pengguna
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        
        <div class="bg-gray-50 p-4 border-b border-gray-100 flex flex-col lg:flex-row justify-between gap-4 items-center">
            
            <div class="flex overflow-x-auto pb-1 w-full lg:w-auto hide-scrollbar gap-2" style="-ms-overflow-style: none; scrollbar-width: none;">
                <button onclick="changeTab('semua')" data-target="semua" class="tab-btn bg-blue-600 text-white shadow-md px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 whitespace-nowrap">
                    <i class="fas fa-users mr-1"></i> Semua
                </button>
                <button onclick="changeTab('admin')" data-target="admin" class="tab-btn bg-white text-gray-600 hover:bg-gray-100 border border-gray-200 px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 whitespace-nowrap">
                    <i class="fas fa-user-shield mr-1 text-red-500"></i> Admin
                </button>
                <button onclick="changeTab('guru')" data-target="guru" class="tab-btn bg-white text-gray-600 hover:bg-gray-100 border border-gray-200 px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 whitespace-nowrap">
                    <i class="fas fa-chalkboard-teacher mr-1 text-blue-500"></i> Guru
                </button>
                <button onclick="changeTab('siswa')" data-target="siswa" class="tab-btn bg-white text-gray-600 hover:bg-gray-100 border border-gray-200 px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 whitespace-nowrap">
                    <i class="fas fa-user-graduate mr-1 text-green-500"></i> Siswa
                </button>
            </div>

            <div class="relative w-full lg:w-80">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" id="searchInput" oninput="applyFilters()" class="bg-white border border-gray-200 text-gray-700 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 shadow-sm transition" placeholder="Cari nama atau NIS/NIP...">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse whitespace-nowrap">
                <thead>
                    <tr class="bg-white text-gray-500 text-xs uppercase tracking-wider border-b border-gray-100">
                        <th class="p-4 font-bold w-16 text-center">No</th>
                        <th class="p-4 font-bold">Profil Pengguna</th>
                        <th class="p-4 font-bold">Username / ID</th>
                        <th class="p-4 font-bold text-center">Role</th>
                        <th class="p-4 font-bold text-center w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody id="userTableBody" class="divide-y divide-gray-50">
                    @foreach($users as $index => $user)
                    
                    {{-- LOGIKA CEK KELAS SISWA --}}
                    @php
                        $infoKelas = 'Tidak Berlaku (Bukan Siswa)';
                        $isBelumMasukKelas = false;

                        if($user->role === 'siswa') {
                            $tahunAktif = \App\Models\TahunAkademik::where('status_aktif', 1)->first(); // Menggunakan 1 untuk status aktif
                            if($tahunAktif) {
                                $rombel = \App\Models\Rombel::where('user_id', $user->id)->where('tahun_akademik_id', $tahunAktif->id)->first();
                                if($rombel) {
                                    $infoKelas = 'Kelas ' . $rombel->kelas->nama_kelas;
                                } else {
                                    $infoKelas = 'Belum memiliki kelas di periode ini.';
                                    $isBelumMasukKelas = true;
                                }
                            } else {
                                $infoKelas = 'Tahun akademik belum diatur.';
                                $isBelumMasukKelas = true;
                            }
                        }
                    @endphp

                    <tr class="user-row hover:bg-slate-50 transition duration-200" data-role="{{ $user->role }}">
                        <td class="p-4 text-center font-medium text-gray-400 serial-number">{{ $index + 1 }}</td>
                        
                        <td class="p-4 searchable-data">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-blue-100/50 text-blue-600 border border-blue-200/50 flex items-center justify-center font-bold text-sm uppercase shrink-0">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-bold text-gray-800 text-sm">{{ $user->name }}</div>
                                    <div class="text-xs text-gray-500 mt-0.5">Terdaftar: {{ $user->created_at->format('M Y') }}</div>
                                </div>
                            </div>
                        </td>
                        
                        <td class="p-4">
                            <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-gray-100 text-gray-600 font-mono text-xs searchable-data">
                                <i class="fas fa-id-card text-gray-400"></i> {{ $user->username }}
                            </div>
                        </td>
                        
                        <td class="p-4 text-center">
                            @if($user->role === 'admin')
                                <span class="bg-red-50 text-red-600 border border-red-200 px-3 py-1 rounded-lg text-xs font-bold"><i class="fas fa-shield-alt mr-1"></i> Admin</span>
                            @elseif($user->role === 'guru')
                                <span class="bg-emerald-50 text-emerald-600 border border-emerald-200 px-3 py-1 rounded-lg text-xs font-bold"><i class="fas fa-chalkboard-teacher mr-1"></i> Guru</span>
                            @else
                                <span class="bg-blue-50 text-blue-600 border border-blue-200 px-3 py-1 rounded-lg text-xs font-bold"><i class="fas fa-user-graduate mr-1"></i> Siswa</span>
                            @endif
                        </td>
                        
                        <td class="p-4 text-center">
                            <div class="flex justify-center items-center gap-2">
                                <button type="button" onclick="openDetailModal('{{ addslashes($user->name) }}', '{{ $user->username }}', '{{ $user->role }}', '{{ $infoKelas }}', {{ $isBelumMasukKelas ? 'true' : 'false' }})" class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-teal-100 text-gray-500 hover:text-teal-600 flex items-center justify-center transition" title="Lihat Detail Profil">
                                    <i class="fas fa-eye text-sm"></i>
                                </button>
                                <a href="/admin/users/{{ $user->id }}/edit" class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-blue-100 text-gray-500 hover:text-blue-600 flex items-center justify-center transition" title="Edit">
                                    <i class="fas fa-pen text-sm"></i>
                                </a>
                                <form action="/admin/users/{{ $user->id }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus {{ $user->name }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-red-100 text-gray-500 hover:text-red-600 flex items-center justify-center transition" title="Hapus">
                                        <i class="fas fa-trash-alt text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach

                    <tr id="empty-state" style="display: none;">
                        <td colspan="5" class="p-16 text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 text-gray-300 mb-4 text-3xl">
                                <i class="fas fa-search"></i>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800">Tidak ada pengguna ditemukan</h3>
                            <p class="text-gray-500 text-sm mt-1">Coba sesuaikan kata kunci pencarian atau filter tab.</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL DETAIL PROFIL (KTP VIRTUAL) --}}
<div id="detailModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-slate-900/40 backdrop-blur-sm transition-opacity duration-300 opacity-0 px-4">
    <div id="detailModalContent" class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform scale-95 transition-all duration-300 overflow-hidden">
        
        <div class="bg-gradient-to-br from-blue-600 to-blue-800 p-6 text-center relative overflow-hidden">
            <div class="absolute -right-8 -top-8 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
            
            <button onclick="closeDetailModal()" class="absolute top-4 right-4 text-white/70 hover:text-white transition focus:outline-none">
                <i class="fas fa-times text-xl"></i>
            </button>
            <div id="modalAvatar" class="w-20 h-20 bg-white text-blue-600 rounded-2xl flex items-center justify-center text-3xl font-bold mx-auto mb-4 shadow-lg uppercase transform rotate-3 hover:rotate-0 transition">
                A
            </div>
            <h3 id="modalName" class="text-xl font-bold text-white mb-1 tracking-tight">Nama Pengguna</h3>
            <span id="modalRoleBadge" class="inline-block bg-white/20 text-white px-3 py-1 rounded-full text-xs font-bold uppercase tracking-widest backdrop-blur-md">ROLE</span>
        </div>

        <div class="p-6 space-y-5">
            <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Username / ID Akses</label>
                <div class="text-gray-800 font-mono font-medium flex items-center gap-2">
                    <i class="fas fa-fingerprint text-blue-400"></i> <span id="modalUsername">12345678</span>
                </div>
            </div>

            <div id="kelasSection" style="display: none;">
                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Status Rombongan Belajar</label>
                <div id="modalKelasContainer" class="p-4 rounded-xl flex items-center shadow-sm">
                    <i id="modalKelasIcon" class="fas mr-3 text-xl"></i>
                    <span id="modalKelasText" class="font-medium text-sm"></span>
                </div>
            </div>
        </div>

        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50 flex justify-end">
            <button onclick="closeDetailModal()" class="bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 px-6 py-2.5 rounded-xl text-sm font-bold transition shadow-sm w-full md:w-auto">
                Tutup Profil
            </button>
        </div>
    </div>
</div>

{{-- SCRIPT TETAP SAMA SEPERTI MILIKMU (Sudah rapi) --}}
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

    const detailModal = document.getElementById('detailModal');
    const detailModalContent = document.getElementById('detailModalContent');

    function openDetailModal(name, username, role, infoKelas, isBelumMasukKelas) {
        document.getElementById('modalAvatar').innerText = name.substring(0, 1);
        document.getElementById('modalName').innerText = name;
        document.getElementById('modalUsername').innerText = username;
        document.getElementById('modalRoleBadge').innerText = role;

        const kelasSection = document.getElementById('kelasSection');
        const kelasContainer = document.getElementById('modalKelasContainer');
        const kelasIcon = document.getElementById('modalKelasIcon');
        const kelasText = document.getElementById('modalKelasText');

        if (role === 'siswa') {
            kelasSection.style.display = 'block';
            kelasText.innerText = infoKelas;

            if (isBelumMasukKelas) {
                kelasContainer.className = "p-4 rounded-xl border border-red-100 bg-red-50 flex items-center text-red-700";
                kelasIcon.className = "fas fa-exclamation-circle mr-3 text-xl";
            } else {
                kelasContainer.className = "p-4 rounded-xl border border-green-100 bg-green-50 flex items-center text-green-700";
                kelasIcon.className = "fas fa-check-circle mr-3 text-xl";
            }
        } else {
            kelasSection.style.display = 'none';
        }

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