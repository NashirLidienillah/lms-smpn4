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
            <h2 class="text-2xl font-bold text-gray-800">Master Data Mata Pelajaran</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola daftar mata pelajaran yang diajarkan di SMPN 4 Kota Serang.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden sticky top-6">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 font-bold text-gray-700 flex items-center">
                    <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center mr-3">
                        <i class="fas fa-book-open"></i>
                    </div>
                    Tambah Mapel Baru
                </div>
                <form action="/admin/mapel" method="POST" class="p-6 space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-bold text-gray-600 mb-2">Nama Mata Pelajaran</label>
                        <input type="text" name="nama_mapel" value="{{ old('nama_mapel') }}" required placeholder="Contoh: Matematika, IPA..."
                            class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition text-sm @error('nama_mapel') border-red-500 bg-red-50 @enderror">
                        @error('nama_mapel') 
                            <span class="text-xs text-red-500 mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span> 
                        @enderror
                    </div>
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl transition shadow-sm font-bold flex items-center justify-center">
                        <i class="fas fa-save mr-2"></i> Simpan Data Mapel
                    </button>
                </form>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <span class="font-bold text-gray-700">Daftar Mata Pelajaran</span>
                    <span class="bg-amber-100 text-amber-700 py-1 px-3 rounded-full text-xs font-bold">{{ $mapel->count() }} Mapel</span>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse whitespace-nowrap">
                        <thead>
                            <tr class="bg-white text-gray-500 text-xs uppercase tracking-wider border-b border-gray-100">
                                <th class="p-4 font-bold w-16 text-center">No</th>
                                <th class="p-4 font-bold">Identitas Mata Pelajaran</th>
                                <th class="p-4 font-bold text-center w-32">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($mapel as $index => $m)
                            <tr class="hover:bg-slate-50 transition duration-200 group">
                                <td class="p-4 text-center font-medium text-gray-400">{{ $index + 1 }}</td>
                                <td class="p-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold shrink-0">
                                            <i class="fas fa-book"></i>
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-800 text-base">{{ $m->nama_mapel }}</div>
                                            <div class="text-xs text-gray-400 mt-0.5">Kode: MP-{{ str_pad($m->id, 3, '0', STR_PAD_LEFT) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4 text-center">
                                    <form id="delete-form-{{ $m->id }}" action="/admin/mapel/{{ $m->id }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="openDeleteModal({{ $m->id }}, '{{ addslashes($m->nama_mapel) }}')" class="w-9 h-9 rounded-lg bg-gray-50 hover:bg-red-100 text-gray-400 hover:text-red-600 flex items-center justify-center transition" title="Hapus Mata Pelajaran">
                                            <i class="fas fa-trash-alt text-sm"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="p-12 text-center">
                                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 text-gray-300 mb-4 text-3xl">
                                        <i class="fas fa-book-dead"></i>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-800">Belum ada data mata pelajaran</h3>
                                    <p class="text-gray-500 text-sm mt-1">Silakan tambahkan mata pelajaran baru melalui form di samping.</p>
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

{{-- ================= MODAL KONFIRMASI HAPUS ================= --}}
<div id="deleteModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-slate-900/40 backdrop-blur-sm transition-opacity duration-300 opacity-0 px-4">
    <div id="deleteModalContent" class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-sm transform scale-95 transition-transform duration-300 relative overflow-hidden">
        
        <div class="absolute -right-8 -top-8 w-32 h-32 bg-red-50 rounded-full blur-2xl"></div>

        <div class="flex items-center justify-center w-16 h-16 mx-auto bg-red-100 text-red-600 rounded-full mb-4 border-4 border-white shadow-sm relative z-10">
            <i class="fas fa-exclamation-triangle text-2xl"></i>
        </div>
        
        <h3 class="text-xl font-bold text-center text-gray-800 mb-2 relative z-10">Hapus Mapel <span id="modalMapelName" class="text-red-600"></span>?</h3>
        <p class="text-center text-gray-500 text-sm mb-6 relative z-10">
            Apakah Anda yakin ingin menghapus mata pelajaran ini dari sistem?
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
    let currentDeleteId = null;
    const deleteModal = document.getElementById('deleteModal');
    const deleteModalContent = document.getElementById('deleteModalContent');
    const modalMapelName = document.getElementById('modalMapelName');

    // Menerima parameter namaMapel agar peringatannya jelas
    function openDeleteModal(id, namaMapel) {
        currentDeleteId = id;
        modalMapelName.innerText = namaMapel;
        
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