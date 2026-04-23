@extends('layouts.app')

@section('content')

{{-- ================= NOTIFIKASI TOAST MELAYANG ================= --}}
@if(session('success'))
    <div id="toast-success" class="fixed top-5 right-5 flex items-center w-full max-w-xs p-4 mb-4 text-gray-700 bg-white rounded-lg shadow-xl border-l-4 border-green-500 z-50 transition-all duration-500" role="alert">
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

<h2 class="text-2xl font-bold text-gray-800 mb-6">Master Data Mata Pelajaran</h2>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    
    <div class="md:col-span-1">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gray-50 px-4 py-3 border-b font-semibold text-gray-700">
                <i class="fas fa-plus-circle mr-2 text-blue-600"></i> Tambah Mapel
            </div>
            <form action="/admin/mapel" method="POST" class="p-4">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Mata Pelajaran</label>
                    <input type="text" name="nama_mapel" value="{{ old('nama_mapel') }}" required placeholder="Misal: Matematika..."
                        class="w-full p-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 @error('nama_mapel') border-red-500 @enderror">
                    @error('nama_mapel') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded transition shadow-sm font-medium">
                    Simpan Mapel
                </button>
            </form>
        </div>
    </div>

    <div class="md:col-span-2">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-700 text-sm border-b">
                        <th class="p-4 font-semibold w-16">No</th>
                        <th class="p-4 font-semibold">Nama Mata Pelajaran</th>
                        <th class="p-4 font-semibold text-center w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mapel as $index => $m)
                    <tr class="border-b hover:bg-gray-50 transition text-sm text-gray-800">
                        <td class="p-4">{{ $index + 1 }}</td>
                        <td class="p-4 font-bold text-blue-800">{{ $m->nama_mapel }}</td>
                        <td class="p-4 text-center">
                            <form id="delete-form-{{ $m->id }}" action="/admin/mapel/{{ $m->id }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="openDeleteModal({{ $m->id }})" class="text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 p-2 rounded transition">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="p-6 text-center text-gray-500 italic">Belum ada data mata pelajaran.</td>
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
        <p class="text-center text-gray-500 text-sm mb-6">Apakah Anda yakin ingin menghapus mata pelajaran ini?</p>
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
    function openDeleteModal(id) {
        currentDeleteId = id;
        deleteModal.classList.remove('hidden');
        setTimeout(() => { deleteModal.classList.remove('opacity-0'); deleteModalContent.classList.remove('scale-95'); deleteModalContent.classList.add('scale-100'); }, 10);
    }
    function closeDeleteModal() {
        deleteModal.classList.add('opacity-0'); deleteModalContent.classList.remove('scale-100'); deleteModalContent.classList.add('scale-95');
        setTimeout(() => { deleteModal.classList.add('hidden'); currentDeleteId = null; }, 300);
    }
    function submitDeleteForm() {
        if (currentDeleteId) { document.getElementById('delete-form-' + currentDeleteId).submit(); }
    }
</script>
@endsection