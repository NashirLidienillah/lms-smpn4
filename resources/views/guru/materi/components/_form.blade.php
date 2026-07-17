{{-- Kita bungkus seluruh form dengan Alpine.js data untuk handle toggle tipe --}}
<form action="/guru/materi/{{ $materi->id }}" method="POST" enctype="multipart/form-data" class="p-6 md:p-8 space-y-6" x-data="{ currentType: '{{ $materi->tipe }}' }">
    @csrf
    @method('PUT') 
    
    {{-- Input Judul --}}
    <div>
        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Judul Materi <span class="text-red-500">*</span></label>
        <input type="text" name="judul" value="{{ $materi->judul }}" required 
            class="w-full p-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all outline-none">
    </div>
    
    {{-- Input Deskripsi --}}
    <div>
        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Deskripsi Singkat</label>
        <textarea name="deskripsi" rows="3" 
            class="w-full p-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all outline-none">{{ $materi->deskripsi }}</textarea>
    </div>
    
    {{-- DROPDOWN JENIS MATERI (Custom Alpine.js) --}}
    <div>
        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Jenis Materi</label>
        
        <div x-data="{ 
                open: false, 
                options: {
                    'file': '📄 Upload Dokumen (PDF, Word, PPT)', 
                    'youtube': '📺 Link Video YouTube'
                } 
            }" class="relative">
            
            {{-- Hidden Input untuk Backend Laravel --}}
            <input type="hidden" name="tipe" x-model="currentType" required>

            {{-- Tombol Dropdown Custom --}}
            <button @click="open = !open" @click.outside="open = false" type="button" 
                class="w-full p-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold flex justify-between items-center focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all shadow-sm outline-none">
                <span x-text="options[currentType]" class="text-blue-700"></span>
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
                    <div @click="currentType = value; open = false" 
                         class="px-4 py-3.5 text-sm font-bold cursor-pointer transition-colors border-b border-gray-50 last:border-0 hover:bg-blue-50 hover:text-blue-600 flex items-center gap-2"
                         :class="currentType === value ? 'bg-blue-50 text-blue-600' : 'text-gray-600'">
                         <span x-text="label"></span>
                         <i x-show="currentType === value" class="fas fa-check text-blue-500 ml-auto"></i>
                    </div>
                </template>
            </div>
        </div>
    </div>

    {{-- BOX UPLOAD FILE (Ditampilkan jika currentType == 'file') --}}
    <div x-show="currentType === 'file'" x-collapse>
        <div class="bg-orange-50 border border-orange-100 p-5 rounded-2xl">
            <label class="block text-[10px] font-black text-orange-800 uppercase tracking-widest mb-3">Ganti File Dokumen</label>
            
            @if($materi->tipe == 'file' && $materi->file_path)
                <div class="flex items-center bg-white border border-orange-200 p-3 rounded-xl mb-4 shadow-sm">
                    <div class="w-8 h-8 rounded-lg bg-orange-100 text-orange-600 flex items-center justify-center mr-3 shrink-0">
                        <i class="fas fa-paperclip"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="text-[9px] uppercase tracking-wider font-bold text-gray-400">File Saat Ini</div>
                        <div class="text-sm font-bold text-orange-700 truncate">{{ $materi->file_path }}</div>
                    </div>
                </div>
            @endif
            
            <span class="block text-[10px] text-gray-500 mb-2">* Kosongkan jika tidak ingin mengubah file lama</span>
            <input type="file" name="file_materi" accept=".pdf,.doc,.docx,.ppt,.pptx" 
                class="w-full text-sm font-medium text-gray-600 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-orange-100 file:text-orange-700 hover:file:bg-orange-200 transition-all bg-white border border-orange-200 rounded-xl p-1.5 shadow-sm outline-none cursor-pointer">
        </div>
    </div>

    {{-- BOX YOUTUBE (Ditampilkan jika currentType == 'youtube') --}}
    <div x-show="currentType === 'youtube'" x-collapse style="display: none;">
        <div class="bg-red-50 border border-red-100 p-5 rounded-2xl">
            <label class="block text-[10px] font-black text-red-800 uppercase tracking-widest mb-2 flex items-center">
                <i class="fab fa-youtube text-red-600 mr-2 text-sm"></i> URL Video YouTube Baru
            </label>
            <input type="url" name="url_youtube" value="{{ $materi->url_youtube }}" 
                placeholder="https://www.youtube.com/watch?v=..."
                class="w-full p-3.5 bg-white border border-red-200 rounded-xl text-sm font-medium text-gray-700 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all shadow-sm outline-none">
        </div>
    </div>

    <div class="pt-4 border-t border-gray-100 mt-6">
        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-4 rounded-xl shadow-lg shadow-blue-200 transition-all uppercase tracking-widest text-[11px] flex items-center justify-center gap-2">
            <i class="fas fa-save"></i> Simpan Perubahan Materi
        </button>
    </div>
</form>