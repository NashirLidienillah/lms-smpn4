@extends('layouts.app')

@section('content')

{{-- ================= NOTIFIKASI TOAST MELAYANG ================= --}}
@if(session('success'))
    <div id="toast-success" class="fixed top-5 right-5 flex items-center w-full max-w-xs p-4 mb-4 text-gray-700 bg-white rounded-lg shadow-xl border-l-4 border-green-500 z-50 transition-all duration-500" role="alert">
        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg">
            <i class="fas fa-check"></i>
        </div>
        <div class="ml-3 text-sm font-medium">{{ session('success') }}</div>
        <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 transition" onclick="closeToast()">
            <span class="sr-only">Close</span>
            <i class="fas fa-times"></i>
        </button>
    </div>

    <script>
        function closeToast() {
            const toast = document.getElementById('toast-success');
            if (toast) {
                toast.classList.add('opacity-0', 'translate-x-full'); // Efek memudar & geser
                setTimeout(() => toast.remove(), 500); // Hapus dari HTML setelah efek selesai
            }
        }
        // Otomatis hilang setelah 3.5 detik
        setTimeout(() => { closeToast(); }, 3500);
    </script>
@endif
{{-- ========================================================== --}}


<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Kelola Data Pengguna</h2>
    
    <a href="/admin/users/create" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow-sm">
        <i class="fas fa-plus mr-2"></i> Tambah Pengguna
    </a>
</div>

<div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-50 text-gray-700 text-sm border-b">
                <th class="p-4 font-semibold">No</th>
                <th class="p-4 font-semibold">Nama Lengkap</th>
                <th class="p-4 font-semibold">Username / NIS</th>
                <th class="p-4 font-semibold">Peran (Role)</th>
                <th class="p-4 font-semibold text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $index => $user)
            <tr class="border-b hover:bg-gray-50 transition text-sm text-gray-800">
                <td class="p-4">{{ $index + 1 }}</td>
                <td class="p-4 font-medium">{{ $user->name }}</td>
                <td class="p-4">{{ $user->username }}</td>
                <td class="p-4">
                    @if($user->role === 'admin')
                        <span class="bg-purple-100 text-purple-700 px-2 py-1 rounded text-xs font-bold uppercase">Admin</span>
                    @elseif($user->role === 'guru')
                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-bold uppercase">Guru</span>
                    @else
                        <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs font-bold uppercase">Siswa</span>
                    @endif
                </td>
                <td class="p-4 text-center space-x-2 flex justify-center">
                    
                    {{-- Tombol Edit (Sudah Berfungsi) --}}
                    <a href="/admin/users/{{ $user->id }}/edit" class="text-blue-500 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 p-2 rounded transition inline-block">
                        <i class="fas fa-edit"></i>
                    </a>
                    
                    {{-- Tombol Hapus (Sudah Berfungsi) --}}
                    <form id="delete-form-{{ $user->id }}" action="/admin/users/{{ $user->id }}" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="openDeleteModal({{ $user->id }})" class="text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 p-2 rounded transition">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

{{-- ================= NOTIF KONFIRMASI HAPUS ================= --}}
<div id="deleteModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black bg-opacity-40 backdrop-blur-sm transition-opacity duration-300 opacity-0">
    <div id="deleteModalContent" class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-sm transform scale-95 transition-transform duration-300">
        
        <div class="flex items-center justify-center w-16 h-16 mx-auto bg-red-50 text-red-500 rounded-full mb-4 border-4 border-red-100">
            <i class="fas fa-exclamation-triangle text-2xl"></i>
        </div>
        
        <h3 class="text-xl font-bold text-center text-gray-800 mb-2">Konfirmasi Hapus</h3>
        <p class="text-center text-gray-500 text-sm mb-6">
            Apakah Anda yakin ingin menghapus pengguna ini? Data yang sudah dihapus tidak dapat dikembalikan.
        </p>
        
        <div class="flex space-x-3">
            <button onclick="closeDeleteModal()" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2.5 rounded-xl transition">
                Batal
            </button>
            <button onclick="submitDeleteForm()" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-semibold py-2.5 rounded-xl shadow-md hover:shadow-lg transition">
                Ya, Hapus
            </button>
        </div>
    </div>
</div>

<script>
    let currentDeleteId = null;
    const deleteModal = document.getElementById('deleteModal');
    const deleteModalContent = document.getElementById('deleteModalContent');

    // Fungsi Membuka Modal
    function openDeleteModal(id) {
        currentDeleteId = id;
        deleteModal.classList.remove('hidden');
        
        // Sedikit jeda untuk memicu efek animasi CSS
        setTimeout(() => {
            deleteModal.classList.remove('opacity-0');
            deleteModalContent.classList.remove('scale-95');
            deleteModalContent.classList.add('scale-100');
        }, 10);
    }

    // Fungsi Menutup Modal
    function closeDeleteModal() {
        deleteModal.classList.add('opacity-0');
        deleteModalContent.classList.remove('scale-100');
        deleteModalContent.classList.add('scale-95');
        
        // Tunggu animasi meluncur selesai (300ms) baru hilangkan dari layar
        setTimeout(() => {
            deleteModal.classList.add('hidden');
            currentDeleteId = null;
        }, 300);
    }

    // Fungsi Eksekusi Hapus
    function submitDeleteForm() {
        if (currentDeleteId) {
            document.getElementById('delete-form-' + currentDeleteId).submit();
        }
    }
</script>
{{-- ========================================================== --}}