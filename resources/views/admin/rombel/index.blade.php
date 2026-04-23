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

@if(session('error'))
    <div id="toast-error" class="fixed top-5 right-5 flex items-center w-full max-w-xs p-4 mb-4 text-gray-700 bg-white rounded-lg shadow-xl border-l-4 border-red-500 z-50 transition-all duration-500">
        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg"><i class="fas fa-exclamation"></i></div>
        <div class="ml-3 text-sm font-medium">{{ session('error') }}</div>
        <button type="button" class="ml-auto bg-white text-gray-400 hover:text-gray-900 rounded-lg p-1.5 hover:bg-gray-100 h-8 w-8 transition" onclick="document.getElementById('toast-error').remove()"><i class="fas fa-times"></i></button>
    </div>
    <script>setTimeout(() => { document.getElementById('toast-error')?.remove(); }, 4000);</script>
@endif

{{-- Header dengan Indikator Tahun Akademik --}}
<div class="mb-6 bg-white border border-gray-200 rounded-xl p-5 flex flex-col md:flex-row items-start md:items-center justify-between shadow-sm relative overflow-hidden">
    <div class="absolute top-0 left-0 w-1.5 h-full bg-blue-600"></div>
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Manajemen Rombongan Belajar</h2>
        <p class="text-sm text-gray-500 mt-1">Mengelola penempatan siswa ke dalam kelas sesuai tahun ajaran berjalan.</p>
    </div>
    <div class="mt-4 md:mt-0 text-left md:text-right">
        <span class="block text-xs text-gray-400 mb-1 uppercase tracking-wider font-bold">Tahun Akademik Aktif</span>
        <span class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-2 rounded-lg text-sm font-bold shadow-sm inline-block">
            <i class="fas fa-calendar-check mr-2"></i> {{ $tahunAktif->nama_tahun }} (Semester {{ $tahunAktif->semester }})
        </span>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-4 gap-6">
    
    <div class="md:col-span-1 space-y-3">
        @php
            // Logika Otomatis: Mengelompokkan kelas berdasarkan angka pertamanya (Tingkat)
            // Contoh: "7A" dan "7B" akan masuk ke grup "7"
            $groupedKelas = $kelas->groupBy(function($item) {
                preg_match('/\d+/', $item->nama_kelas, $matches);
                return $matches[0] ?? 'Lainnya';
            });
        @endphp

        @forelse($groupedKelas as $tingkat => $kelasGroup)
            {{-- Tag details ini otomatis membuat fitur buka-tutup tanpa perlu Javascript! --}}
            {{-- Akan otomatis terbuka (open) jika admin sedang memilih kelas di dalam tingkat ini --}}
            <details class="group" {{ (request('kelas_id') && $kelasGroup->contains('id', request('kelas_id'))) ? 'open' : '' }}>
                <summary class="bg-gray-800 text-white p-3 rounded-lg font-semibold text-sm cursor-pointer list-none flex justify-between items-center hover:bg-gray-700 transition select-none shadow-sm">
                    <span class="flex items-center"><i class="fas fa-folder-open text-yellow-400 mr-2"></i> Tingkat {{ $tingkat }}</span>
                    <i class="fas fa-chevron-down transition-transform duration-300 group-open:rotate-180"></i>
                </summary>
                
                <div class="bg-white border border-gray-200 rounded-b-lg shadow-sm overflow-hidden mt-1">
                    @foreach($kelasGroup as $k)
                        <a href="/admin/rombel?kelas_id={{ $k->id }}" 
                           class="flex items-center p-3 border-b transition text-sm font-medium
                           {{ request('kelas_id') == $k->id ? 'bg-blue-50 text-blue-700 border-l-4 border-l-blue-600' : 'text-gray-700 hover:bg-gray-50 border-l-4 border-transparent' }}">
                            <i class="fas fa-door-open mr-2 {{ request('kelas_id') == $k->id ? 'text-blue-500' : 'text-gray-300' }}"></i> 
                            Kelas {{ $k->nama_kelas }}
                        </a>
                    @endforeach
                </div>
            </details>
        @empty
            <div class="p-4 text-center text-gray-500 text-sm bg-white rounded-lg border border-gray-200 shadow-sm">Belum ada Master Kelas.</div>
        @endforelse
    </div>

    <div class="md:col-span-3">
        @if($selectedKelas)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 mb-6">
                <h3 class="font-bold text-gray-800 mb-3"><i class="fas fa-user-plus text-blue-600 mr-2"></i> Masukkan Siswa ke Kelas {{ $selectedKelas->nama_kelas }}</h3>
                <form action="/admin/rombel/add" method="POST" class="flex gap-3">
                    @csrf
                    <input type="hidden" name="kelas_id" value="{{ $selectedKelas->id }}">
                    <select name="user_id" required class="flex-1 p-2.5 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm bg-gray-50">
                        <option value="">-- Pilih Siswa yang Belum Punya Kelas di Tahun Ini --</option>
                        @foreach($siswaBelumAdaKelas as $s)
                            <option value="{{ $s->id }}">{{ $s->name }} ({{ $s->username }})</option>
                        @endforeach
                    </select>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg text-sm font-medium transition shadow-sm">
                        Tambahkan
                    </button>
                </form>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gray-50 px-5 py-3 border-b border-gray-200 flex justify-between items-center">
                    <span class="font-bold text-gray-700"><i class="fas fa-users mr-2 text-gray-400"></i> Daftar Siswa ({{ count($siswaDiKelas) }} Orang)</span>
                </div>
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-sm text-gray-600 border-b bg-white">
                            <th class="p-4 font-semibold w-16 text-center">No</th>
                            <th class="p-4 font-semibold">Nama Siswa</th>
                            <th class="p-4 font-semibold">NIS</th>
                            <th class="p-4 font-semibold text-center w-28">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswaDiKelas as $index => $siswa)
                        <tr class="border-b hover:bg-gray-50 transition text-sm text-gray-800">
                            <td class="p-4 text-center font-medium text-gray-500">{{ $index + 1 }}</td>
                            <td class="p-4 font-bold text-gray-700">{{ $siswa->user->name }}</td>
                            <td class="p-4 text-gray-500">{{ $siswa->user->username }}</td>
                            <td class="p-4 text-center">
                                <form id="remove-form-{{ $siswa->id }}" action="/admin/rombel/remove/{{ $siswa->id }}" method="POST" class="inline-block">
                                    @csrf
                                    <button type="button" onclick="openRemoveModal({{ $siswa->id }}, '{{ addslashes($siswa->user->name) }}')" class="text-orange-500 hover:text-white hover:bg-orange-500 border border-orange-500 p-1.5 rounded transition" title="Keluarkan dari kelas">
                                        <i class="fas fa-sign-out-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="p-12 text-center flex flex-col items-center justify-center">
                                <div class="w-16 h-16 bg-gray-100 text-gray-400 rounded-full flex items-center justify-center mb-3 text-2xl">
                                    <i class="fas fa-user-slash"></i>
                                </div>
                                <p class="text-gray-500 italic">Belum ada siswa di kelas ini.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        @else
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center h-full flex flex-col items-center justify-center min-h-[400px]">
                <div class="w-24 h-24 bg-blue-50 text-blue-400 rounded-full flex items-center justify-center mb-5 text-4xl">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Pilih Kelas Terlebih Dahulu</h3>
                <p class="text-gray-500 text-sm max-w-sm mx-auto">Silakan buka folder tingkat di sebelah kiri, lalu klik salah satu kelas untuk mulai mengelola daftar siswa.</p>
            </div>
        @endif
    </div>
</div>

{{-- ================= MODAL KONFIRMASI KELUARKAN ================= --}}
<div id="removeModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black bg-opacity-40 backdrop-blur-sm transition-opacity duration-300 opacity-0">
    <div id="removeModalContent" class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-sm transform scale-95 transition-transform duration-300">
        <div class="flex items-center justify-center w-16 h-16 mx-auto bg-orange-50 text-orange-500 rounded-full mb-4 border-4 border-orange-100">
            <i class="fas fa-user-minus text-2xl"></i>
        </div>
        <h3 class="text-xl font-bold text-center text-gray-800 mb-2">Keluarkan Siswa</h3>
        <p class="text-center text-gray-500 text-sm mb-6">
            Apakah Anda yakin ingin mengeluarkan <span id="namaSiswaLabel" class="font-bold text-gray-700"></span> dari kelas ini?
        </p>
        <div class="flex space-x-3">
            <button onclick="closeRemoveModal()" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2.5 rounded-xl transition">Batal</button>
            <button onclick="submitRemoveForm()" class="flex-1 bg-orange-600 hover:bg-orange-700 text-white font-semibold py-2.5 rounded-xl shadow-md transition">Ya, Keluarkan</button>
        </div>
    </div>
</div>

<script>
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