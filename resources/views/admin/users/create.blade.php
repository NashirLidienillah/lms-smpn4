@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h2 class="text-xl font-bold text-gray-800">Tambah Pengguna Baru</h2>
        <a href="/admin/users" class="text-gray-500 hover:text-gray-700 transition">
            <i class="fas fa-times text-lg"></i>
        </a>
    </div>

    <form action="/admin/users" method="POST" class="p-6 space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name') }}" required 
                class="w-full p-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror">
            @error('name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Username / NIS / NIP</label>
            <input type="text" name="username" value="{{ old('username') }}" required 
                class="w-full p-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 @error('username') border-red-500 @enderror">
            @error('username') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input type="password" name="password" required 
                class="w-full p-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-500 @enderror">
            @error('password') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Peran (Role)</label>
            <select name="role" required class="w-full p-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
                <option value="">-- Pilih Peran --</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="guru" {{ old('role') == 'guru' ? 'selected' : '' }}>Guru</option>
                <option value="siswa" {{ old('role') == 'siswa' ? 'selected' : '' }}>Siswa</option>
            </select>
            @error('role') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="pt-4 flex justify-end space-x-2">
            <a href="/admin/users" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded transition">Batal</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition shadow-sm">
                <i class="fas fa-save mr-1"></i> Simpan Data
            </button>
        </div>
    </form>
</div>
@endsection