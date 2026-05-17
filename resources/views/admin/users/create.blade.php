@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto mb-10">
    {{-- Header Form --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-black text-gray-800 tracking-tight">Tambah Pengguna Baru</h2>
            <p class="text-sm text-gray-500 mt-1">Buat akun akses untuk Admin, Guru, atau Siswa.</p>
        </div>
        <a href="/admin/users" class="w-10 h-10 bg-white border border-gray-200 rounded-xl flex items-center justify-center text-gray-400 hover:text-red-500 hover:bg-red-50 hover:border-red-100 transition-all shadow-sm">
            <i class="fas fa-times"></i>
        </a>
    </div>

    {{-- Bento Form Card --}}
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <form action="/admin/users" method="POST" class="p-6 md:p-8 space-y-6">
            @csrf

            {{-- Input: Nama Lengkap --}}
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required 
                    placeholder="Contoh: Budi Santoso"
                    class="w-full p-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all @error('name') border-red-500 bg-red-50 @enderror">
                @error('name') <span class="text-[10px] font-bold text-red-500 mt-1 block"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</span> @enderror
            </div>

            {{-- Input: Username --}}
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Username / NIS / NIP</label>
                <input type="text" name="username" value="{{ old('username') }}" required 
                    placeholder="Contoh: 123456789"
                    class="w-full p-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all @error('username') border-red-500 bg-red-50 @enderror">
                @error('username') <span class="text-[10px] font-bold text-red-500 mt-1 block"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</span> @enderror
            </div>

            {{-- Input: Password --}}
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Password Akses</label>
                <input type="password" name="password" required 
                    placeholder="Minimal 8 karakter"
                    class="w-full p-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all @error('password') border-red-500 bg-red-50 @enderror">
                @error('password') <span class="text-[10px] font-bold text-red-500 mt-1 block"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</span> @enderror
            </div>

            {{-- THE STAR: DROPDOWN ROLE (Anti-Kaku di HP) --}}
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Peran (Role)</label>
                
                {{-- Bungkus Relative --}}
                <div class="relative group">
                    {{-- Select dengan appearance-none --}}
                    <select name="role" required class="appearance-none w-full p-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all cursor-pointer outline-none @error('role') border-red-500 bg-red-50 @enderror">
                        <option value="" disabled {{ old('role') ? '' : 'selected' }}>Pilih Peran Akun...</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin Sekolah</option>
                        <option value="guru" {{ old('role') == 'guru' ? 'selected' : '' }}>Guru</option>
                        <option value="siswa" {{ old('role') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                    </select>
                    
                    {{-- Panah Custom Absolute --}}
                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-gray-400 group-hover:text-blue-500 transition-colors">
                        <i class="fas fa-chevron-down text-sm"></i>
                    </div>
                </div>
                @error('role') <span class="text-[10px] font-bold text-red-500 mt-1 block"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</span> @enderror
            </div>

            {{-- Action Buttons --}}
            <div class="pt-6 mt-6 border-t border-gray-100 flex flex-col sm:flex-row justify-end gap-3">
                <a href="/admin/users" class="w-full sm:w-auto text-center bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold px-6 py-3.5 rounded-xl transition-all text-xs uppercase tracking-widest">
                    Batal
                </a>
                <button type="submit" class="w-full sm:w-auto text-center bg-blue-600 hover:bg-blue-700 text-white font-black px-6 py-3.5 rounded-xl transition-all shadow-lg shadow-blue-100 uppercase tracking-widest text-xs flex items-center justify-center gap-2">
                    <i class="fas fa-save"></i> Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>
@endsection