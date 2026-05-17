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
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Tahun Akademik & Semester</h2>
            <p class="text-sm text-gray-500 mt-1">Pusat kendali periode belajar. Hanya satu tahun akademik yang bisa aktif bersamaan.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- KOLOM FORM (Ubah di sini) --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden sticky top-6">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 font-bold text-gray-700 flex items-center">
                    <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center mr-3">
                        <i class="fas fa-calendar-plus"></i>
                    </div>
                    Buat Periode Baru
                </div>
                
                <form action="/admin/tahun-akademik" method="POST" class="p-6 space-y-5">
                    @csrf
                    
                    {{-- Input Tahun Ajaran --}}
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Tahun Ajaran</label>
                        <input type="text" name="nama_tahun" required placeholder="Contoh: 2026/2027" 
                            class="w-full p-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-all">
                    </div>
                    
                    {{-- Dropdown Semester (Sudah Anti-Kaku) --}}
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Semester</label>
                        <div class="relative group">
                            <select name="semester" required class="appearance-none w-full p-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-all cursor-pointer outline-none">
                                <option value="Ganjil">Semester Ganjil</option>
                                <option value="Genap">Semester Genap</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-gray-400 group-hover:text-indigo-500 transition-colors">
                                <i class="fas fa-chevron-down text-sm"></i>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Tombol Submit --}}
                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-black py-4 rounded-xl transition-all shadow-lg shadow-indigo-200 flex items-center justify-center mt-4 uppercase tracking-widest text-xs">
                        <i class="fas fa-save mr-2"></i> Simpan Periode
                    </button>
                </form>
            </div>
        </div>

        {{-- KOLOM TABEL DATA --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <span class="font-bold text-gray-700">Daftar Tahun Akademik</span>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse whitespace-nowrap">
                        <thead>
                            <tr class="bg-white text-gray-500 text-xs uppercase tracking-wider border-b border-gray-100">
                                <th class="p-4 font-bold w-12 text-center">No</th>
                                <th class="p-4 font-bold">Periode Belajar</th>
                                <th class="p-4 font-bold text-center">Status</th>
                                <th class="p-4 font-bold text-center w-32">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($tahun as $index => $t)
                            
                            <tr class="transition duration-200 group {{ $t->status_aktif ? 'bg-indigo-50/40 hover:bg-indigo-50' : 'hover:bg-slate-50' }}">
                                <td class="p-4 text-center font-medium text-gray-400">{{ $index + 1 }}</td>
                                <td class="p-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl {{ $t->status_aktif ? 'bg-indigo-600 text-white shadow-md shadow-indigo-200' : 'bg-gray-100 text-gray-400' }} flex items-center justify-center font-bold shrink-0 transition-all">
                                            <i class="fas fa-calendar-alt"></i>
                                        </div>
                                        <div>
                                            <div class="font-bold {{ $t->status_aktif ? 'text-indigo-900' : 'text-gray-800' }} text-base">{{ $t->nama_tahun }}</div>
                                            <div class="text-xs {{ $t->status_aktif ? 'text-indigo-600 font-medium' : 'text-gray-400' }} mt-0.5 uppercase tracking-wide">Semester {{ $t->semester }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4 text-center">
                                    @if($t->status_aktif)
                                        <span class="inline-flex items-center gap-1.5 bg-green-100 text-green-700 border border-green-200 px-3 py-1 rounded-lg text-xs font-bold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span> SEDANG AKTIF
                                        </span>
                                    @else
                                        <span class="inline-flex items-center bg-gray-100 text-gray-500 px-3 py-1 rounded-lg text-xs font-semibold">
                                            Tidak Aktif
                                        </span>
                                    @endif
                                </td>
                                <td class="p-4 text-center">
                                    <div class="flex justify-center items-center gap-2">
                                        @if(!$t->status_aktif)
                                            <form id="activate-form-{{ $t->id }}" action="/admin/tahun-akademik/{{ $t->id }}/aktif" method="POST" class="inline-block">
                                                @csrf
                                                @method('PATCH')
                                                <button type="button" onclick="openActivateModal({{ $t->id }}, '{{ $t->nama_tahun }} - Semester {{ $t->semester }}')" class="w-9 h-9 rounded-lg bg-gray-50 hover:bg-green-100 text-gray-400 hover:text-green-600 flex items-center justify-center transition" title="Jadikan Periode Aktif">
                                                    <i class="fas fa-power-off text-sm"></i>
                                                </button>
                                            </form>
                                        @else
                                            <div class="w-9 h-9 flex items-center justify-center text-green-500" title="Ini adalah periode aktif">
                                                <i class="fas fa-check-circle text-lg"></i>
                                            </div>
                                        @endif

                                        <form id="delete-form-{{ $t->id }}" action="/admin/tahun-akademik/{{ $t->id }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="openDeleteModal({{ $t->id }}, '{{ $t->nama_tahun }} - Semester {{ $t->semester }}')" class="w-9 h-9 rounded-lg bg-gray-50 hover:bg-red-100 text-gray-400 hover:text-red-600 flex items-center justify-center transition" title="Hapus Periode">
                                                <i class="fas fa-trash-alt text-sm"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="p-12 text-center">
                                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 text-gray-300 mb-4 text-3xl">
                                        <i class="fas fa-calendar-times"></i>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-800">Belum ada pengaturan</h3>
                                    <p class="text-gray-500 text-sm mt-1">Silakan buat tahun akademik baru agar sistem bisa berjalan.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ================= SEMUA MODAL DI DALAM SECTION CONTENT ================= --}}

{{-- MODAL HAPUS --}}
<div id="deleteModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-slate-900/40 backdrop-blur-sm transition-opacity duration-300 opacity-0 px-4">
    <div id="deleteModalContent" class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-sm transform scale-95 transition-transform duration-300 relative overflow-hidden">
        <div class="absolute -right-8 -top-8 w-32 h-32 bg-red-50 rounded-full blur-2xl"></div>
        <div class="flex items-center justify-center w-16 h-16 mx-auto bg-red-100 text-red-600 rounded-full mb-4 border-4 border-white shadow-sm relative z-10">
            <i class="fas fa-trash-alt text-2xl"></i>
        </div>
        <h3 class="text-xl font-bold text-center text-gray-800 mb-2 relative z-10">Hapus <span id="detailDataLabel" class="text-red-600"></span>?</h3>
        <p class="text-center text-gray-500 text-sm mb-6 relative z-10">Tindakan ini permanen. Pastikan tidak ada riwayat nilai siswa yang terikat dengan periode ini.</p>
        <div class="flex space-x-3 relative z-10">
            <button onclick="closeDeleteModal()" class="flex-1 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-bold py-2.5 rounded-xl transition shadow-sm">Batal</button>
            <button onclick="submitDeleteForm()" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-2.5 rounded-xl shadow-sm transition">Ya, Hapus</button>
        </div>
    </div>
</div>

{{-- MODAL AKTIFKAN --}}
<div id="activateModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-slate-900/40 backdrop-blur-sm transition-opacity duration-300 opacity-0 px-4">
    <div id="activateModalContent" class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-sm transform scale-95 transition-transform duration-300 relative overflow-hidden">
        <div class="absolute -right-8 -top-8 w-32 h-32 bg-green-50 rounded-full blur-2xl"></div>
        <div class="flex items-center justify-center w-16 h-16 mx-auto bg-green-100 text-green-600 rounded-full mb-4 border-4 border-white shadow-sm relative z-10">
            <i class="fas fa-power-off text-2xl"></i>
        </div>
        <h3 class="text-xl font-bold text-center text-gray-800 mb-2 relative z-10">Nyalakan Periode Ini?</h3>
        <p class="text-center text-gray-500 text-sm mb-6 relative z-10">
            Sistem akan berpindah ke <span id="detailActivateLabel" class="font-bold text-gray-800"></span>.<br><br>
            <span class="text-amber-600 bg-amber-50 px-2 py-1 rounded border border-amber-100 text-xs mt-2 inline-block"><i class="fas fa-info-circle mr-1"></i>Periode lain akan dinonaktifkan otomatis.</span>
        </p>
        <div class="flex space-x-3 relative z-10">
            <button onclick="closeActivateModal()" class="flex-1 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-bold py-2.5 rounded-xl transition shadow-sm">Batal</button>
            <button onclick="submitActivateForm()" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 rounded-xl shadow-sm transition">Mulai Periode</button>
        </div>
    </div>
</div>

<script>
    // JS MODAL HAPUS
    let currentDeleteId = null;
    const deleteModal = document.getElementById('deleteModal');
    const deleteModalContent = document.getElementById('deleteModalContent');
    const detailDataLabel = document.getElementById('detailDataLabel');

    function openDeleteModal(id, namaData) {
        currentDeleteId = id; detailDataLabel.innerText = namaData; 
        deleteModal.classList.remove('hidden');
        setTimeout(() => { deleteModal.classList.remove('opacity-0'); deleteModalContent.classList.remove('scale-95'); deleteModalContent.classList.add('scale-100'); }, 10);
    }
    function closeDeleteModal() {
        deleteModal.classList.add('opacity-0'); deleteModalContent.classList.remove('scale-100'); deleteModalContent.classList.add('scale-95');
        setTimeout(() => { deleteModal.classList.add('hidden'); currentDeleteId = null; }, 300);
    }
    function submitDeleteForm() { if (currentDeleteId) document.getElementById('delete-form-' + currentDeleteId).submit(); }

    // JS MODAL AKTIFKAN
    let currentActivateId = null;
    const activateModal = document.getElementById('activateModal');
    const activateModalContent = document.getElementById('activateModalContent');
    const detailActivateLabel = document.getElementById('detailActivateLabel');

    function openActivateModal(id, namaData) {
        currentActivateId = id; detailActivateLabel.innerText = namaData; 
        activateModal.classList.remove('hidden');
        setTimeout(() => { activateModal.classList.remove('opacity-0'); activateModalContent.classList.remove('scale-95'); activateModalContent.classList.add('scale-100'); }, 10);
    }
    function closeActivateModal() {
        activateModal.classList.add('opacity-0'); activateModalContent.classList.remove('scale-100'); activateModalContent.classList.add('scale-95');
        setTimeout(() => { activateModal.classList.add('hidden'); currentActivateId = null; }, 300);
    }
    function submitActivateForm() { if (currentActivateId) document.getElementById('activate-form-' + currentActivateId).submit(); }
</script>

@endsection