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

<h2 class="text-2xl font-bold text-gray-800 mb-6">Master Data Tahun Akademik</h2>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    
    <div class="md:col-span-1">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gray-50 px-4 py-3 border-b font-semibold text-gray-700">
                <i class="fas fa-calendar-plus mr-2 text-blue-600"></i> Tambah Tahun Akademik
            </div>
            <form action="/admin/tahun-akademik" method="POST" class="p-4 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Ajaran</label>
                    <input type="text" name="nama_tahun" required placeholder="Contoh: 2025/2026" class="w-full p-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Semester</label>
                    <select name="semester" required class="w-full p-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 text-sm">
                        <option value="Ganjil">Ganjil</option>
                        <option value="Genap">Genap</option>
                    </select>
                </div>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded transition shadow-sm font-medium mt-2">
                    Simpan Data
                </button>
            </form>
        </div>
    </div>

    <div class="md:col-span-2">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-700 text-sm border-b">
                        <th class="p-4 font-semibold w-12 text-center">No</th>
                        <th class="p-4 font-semibold">Tahun Ajaran</th>
                        <th class="p-4 font-semibold">Semester</th>
                        <th class="p-4 font-semibold text-center">Status</th>
                        <th class="p-4 font-semibold text-center w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tahun as $index => $t)
                    <tr class="border-b hover:bg-gray-50 transition text-sm text-gray-800 {{ $t->status_aktif ? 'bg-blue-50/30' : '' }}">
                        <td class="p-4 text-center">{{ $index + 1 }}</td>
                        <td class="p-4 font-bold text-gray-700">{{ $t->nama_tahun }}</td>
                        <td class="p-4">{{ $t->semester }}</td>
                        <td class="p-4 text-center">
                            @if($t->status_aktif)
                                <span class="bg-green-100 text-green-700 border border-green-200 px-3 py-1 rounded-full text-xs font-bold flex items-center justify-center w-max mx-auto">
                                    <i class="fas fa-check-circle mr-1"></i> Aktif
                                </span>
                            @else
                                <span class="bg-gray-100 text-gray-500 border border-gray-200 px-3 py-1 rounded-full text-xs font-semibold">
                                    Tidak Aktif
                                </span>
                            @endif
                        </td>
                        <td class="p-4 text-center">
                            <div class="flex justify-center space-x-2">
                                @if(!$t->status_aktif)
                                    <form id="activate-form-{{ $t->id }}" action="/admin/tahun-akademik/{{ $t->id }}/aktif" method="POST" class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <button type="button" onclick="openActivateModal({{ $t->id }}, '{{ $t->nama_tahun }} (Semester {{ $t->semester }})')" class="text-green-600 hover:text-white hover:bg-green-600 border border-green-600 p-1.5 rounded transition" title="Set Sebagai Aktif">
                                            <i class="fas fa-power-off"></i>
                                        </button>
                                    </form>
                                @else
                                    <div class="w-8"></div>
                                @endif

                                <form id="delete-form-{{ $t->id }}" action="/admin/tahun-akademik/{{ $t->id }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="openDeleteModal({{ $t->id }}, '{{ $t->nama_tahun }} (Semester {{ $t->semester }})')" class="text-red-500 hover:text-white hover:bg-red-500 border border-red-500 p-1.5 rounded transition" title="Hapus Data">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-6 text-center text-gray-500 italic">Belum ada data tahun akademik.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- ================= MODAL KONFIRMASI HAPUS ================= --}}
<div id="deleteModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black bg-opacity-40 backdrop-blur-sm transition-opacity duration-300 opacity-0">
    <div id="deleteModalContent" class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-sm transform scale-95 transition-transform duration-300">
        <div class="flex items-center justify-center w-16 h-16 mx-auto bg-red-50 text-red-500 rounded-full mb-4 border-4 border-red-100">
            <i class="fas fa-exclamation-triangle text-2xl"></i>
        </div>
        <h3 class="text-xl font-bold text-center text-gray-800 mb-2">Konfirmasi Hapus</h3>
        <p class="text-center text-gray-500 text-sm mb-6">
            Yakin ingin menghapus Tahun Akademik <span id="detailDataLabel" class="font-bold text-gray-700"></span>?
        </p>
        <div class="flex space-x-3">
            <button onclick="closeDeleteModal()" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2.5 rounded-xl transition">Batal</button>
            <button onclick="submitDeleteForm()" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-semibold py-2.5 rounded-xl shadow-md transition">Ya, Hapus</button>
        </div>
    </div>
</div>

<script>
    let currentDeleteId = null;
    const deleteModal = document.getElementById('deleteModal');
    const deleteModalContent = document.getElementById('deleteModalContent');
    const detailDataLabel = document.getElementById('detailDataLabel');

    function openDeleteModal(id, namaData) {
        currentDeleteId = id;
        detailDataLabel.innerText = namaData; 
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
        setTimeout(() => { deleteModal.classList.add('hidden'); currentDeleteId = null; }, 300);
    }

    function submitDeleteForm() {
        if (currentDeleteId) { document.getElementById('delete-form-' + currentDeleteId).submit(); }
    }
</script>
@endsection
{{-- ================= MODAL KONFIRMASI AKTIFKAN ================= --}}
<div id="activateModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black bg-opacity-40 backdrop-blur-sm transition-opacity duration-300 opacity-0">
    <div id="activateModalContent" class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-sm transform scale-95 transition-transform duration-300">
        
        <div class="flex items-center justify-center w-16 h-16 mx-auto bg-green-50 text-green-600 rounded-full mb-4 border-4 border-green-100">
            <i class="fas fa-power-off text-2xl"></i>
        </div>
        
        <h3 class="text-xl font-bold text-center text-gray-800 mb-2">Aktifkan Tahun Ajaran</h3>
        <p class="text-center text-gray-500 text-sm mb-6">
            Anda akan mengaktifkan <span id="detailActivateLabel" class="font-bold text-green-700"></span>. <br><br>
            <span class="text-xs text-red-500 italic">*Tahun ajaran yang lain akan otomatis dinonaktifkan.</span> Lanjutkan?
        </p>
        
        <div class="flex space-x-3">
            <button onclick="closeActivateModal()" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2.5 rounded-xl transition">
                Batal
            </button>
            <button onclick="submitActivateForm()" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-semibold py-2.5 rounded-xl shadow-md hover:shadow-lg transition">
                Ya, Aktifkan
            </button>
        </div>
    </div>
</div>

<script>
    // Logika Modal Aktifkan
    let currentActivateId = null;
    const activateModal = document.getElementById('activateModal');
    const activateModalContent = document.getElementById('activateModalContent');
    const detailActivateLabel = document.getElementById('detailActivateLabel');

    function openActivateModal(id, namaData) {
        currentActivateId = id;
        detailActivateLabel.innerText = namaData; 
        
        activateModal.classList.remove('hidden');
        setTimeout(() => {
            activateModal.classList.remove('opacity-0');
            activateModalContent.classList.remove('scale-95');
            activateModalContent.classList.add('scale-100');
        }, 10);
    }

    function closeActivateModal() {
        activateModal.classList.add('opacity-0');
        activateModalContent.classList.remove('scale-100');
        activateModalContent.classList.add('scale-95');
        setTimeout(() => {
            activateModal.classList.add('hidden');
            currentActivateId = null;
        }, 300);
    }

    function submitActivateForm() {
        if (currentActivateId) {
            document.getElementById('activate-form-' + currentActivateId).submit();
        }
    }
</script>
{{-- ==================================================================== --}}