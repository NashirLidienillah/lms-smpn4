@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto mb-24">
    {{-- Header Form --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-black text-gray-800 tracking-tight">Edit Data Pengguna</h2>
            <p class="text-sm text-gray-500 mt-1">Ubah informasi akun atau reset password pengguna.</p>
        </div>
        <a href="/admin/users" class="w-10 h-10 bg-white border border-gray-200 rounded-xl flex items-center justify-center text-gray-400 hover:text-red-500 hover:bg-red-50 hover:border-red-100 transition-all shadow-sm">
            <i class="fas fa-times"></i>
        </a>
    </div>

    {{-- Bento Form Card (Tanpa overflow-hidden agar dropdown aman) --}}
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100">
        <form action="/admin/users/{{ $user->id }}" method="POST" class="p-6 md:p-8 space-y-6">
            @csrf
            @method('PUT')

            {{-- Input: Nama Lengkap --}}
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required 
                    class="w-full p-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all outline-none @error('name') border-red-500 bg-red-50 @enderror">
                @error('name') <span class="text-[10px] font-bold text-red-500 mt-1 block"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</span> @enderror
            </div>

            {{-- Input: Username --}}
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Username / NIS / NIP</label>
                <input type="text" name="username" value="{{ old('username', $user->username) }}" required 
                    class="w-full p-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all outline-none @error('username') border-red-500 bg-red-50 @enderror">
                @error('username') <span class="text-[10px] font-bold text-red-500 mt-1 block"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</span> @enderror
            </div>

            {{-- Input: Password (Opsional) --}}
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Password Baru <span class="text-blue-500 lowercase font-medium tracking-normal">(Opsional)</span></label>
                <input type="password" name="password" 
                    placeholder="Kosongkan jika tidak ingin ganti password"
                    class="w-full p-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all outline-none @error('password') border-red-500 bg-red-50 @enderror">
                @error('password') <span class="text-[10px] font-bold text-red-500 mt-1 block"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</span> @enderror
            </div>

            {{-- THE STAR: DROPDOWN ROLE (100% Custom Alpine.js) --}}
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Peran (Role)</label>
                
                {{-- Alpine Component --}}
                <div x-data="{ 
                        open: false, 
                        selected: '{{ old('role', $user->role) }}', 
                        options: {
                            'admin': 'Admin Sekolah', 
                            'guru': 'Guru', 
                            'siswa': 'Siswa'
                        } 
                    }" class="relative">
                    
                    {{-- Hidden Input untuk Laravel --}}
                    <input type="hidden" name="role" x-model="selected" required>

                    {{-- Tombol Dropdown Custom --}}
                    <button @click="open = !open" @click.outside="open = false" type="button" 
                        class="w-full p-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold flex justify-between items-center focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all shadow-sm outline-none">
                        <span x-text="selected ? options[selected] : 'Pilih Peran Akun...'" 
                              :class="selected ? 'text-gray-800' : 'text-gray-400'"></span>
                        <i class="fas fa-chevron-down text-gray-400 transition-transform duration-300" :class="open ? 'rotate-180' : ''"></i>
                    </button>

                    {{-- Menu Popup Melayang --}}
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-2"
                         style="display: none;"
                         class="absolute z-50 w-full mt-2 bg-white border border-gray-100 rounded-xl shadow-xl overflow-hidden">
                        
                        <template x-for="(label, value) in options" :key="value">
                            <div @click="selected = value; open = false" 
                                 class="px-4 py-3.5 text-sm font-bold cursor-pointer transition-colors border-b border-gray-50 last:border-0 hover:bg-blue-50 hover:text-blue-600 flex items-center gap-2"
                                 :class="selected === value ? 'bg-blue-50 text-blue-600' : 'text-gray-600'">
                                 <span x-text="label"></span>
                                 <i x-show="selected === value" class="fas fa-check text-blue-500 ml-auto"></i>
                            </div>
                        </template>
                        
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
                    <i class="fas fa-save"></i> Update Data
                </button>
            </div>
        </form>
    </div>
</div>
@endsection