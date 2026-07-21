{{-- Bento Form Card --}}
<div class="bg-white rounded-3xl shadow-sm border border-gray-100">
    <form action="/admin/users" method="POST" class="p-6 md:p-8 space-y-6">
        @csrf

        <div>
            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name') }}" required 
                placeholder="Contoh: Budi Santoso"
                class="w-full p-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all outline-none @error('name') border-red-500 bg-red-50 @enderror">
            @error('name') <span class="text-[10px] font-bold text-red-500 mt-1 block"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Username / NIS / NIP</label>
            <input type="text" name="username" value="{{ old('username') }}" required 
                placeholder="Contoh: 123456789"
                class="w-full p-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all outline-none @error('username') border-red-500 bg-red-50 @enderror">
            @error('username') <span class="text-[10px] font-bold text-red-500 mt-1 block"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Password Akses</label>
            <input type="password" name="password" required 
                placeholder="Minimal 8 karakter"
                class="w-full p-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all outline-none @error('password') border-red-500 bg-red-50 @enderror">
            @error('password') <span class="text-[10px] font-bold text-red-500 mt-1 block"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</span> @enderror
        </div>

        {{-- DROPDOWN ROLE (Alpine.js) --}}
        <div>
            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Peran (Role)</label>
            
            <div x-data="{ 
                    open: false, 
                    selected: '{{ old('role', '') }}', 
                    options: {
                        'admin': 'Admin Sekolah', 
                        'guru': 'Guru', 
                        'siswa': 'Siswa'
                    } 
                }" class="relative">
                
                <input type="hidden" name="role" x-model="selected" required>

                <button @click="open = !open" @click.outside="open = false" type="button" 
                    class="w-full p-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold flex justify-between items-center focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all shadow-sm outline-none">
                    <span x-text="selected ? options[selected] : 'Pilih Peran Akun...'" 
                          :class="selected ? 'text-gray-800' : 'text-gray-400'"></span>
                    <i class="fas fa-chevron-down text-gray-400 transition-transform duration-300" :class="open ? 'rotate-180' : ''"></i>
                </button>

                <div x-show="open" 
                     x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2"
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