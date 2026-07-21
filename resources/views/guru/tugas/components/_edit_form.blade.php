<form action="/guru/tugas/{{ $tugas->id }}" method="POST" enctype="multipart/form-data" class="p-6 md:p-8 space-y-6">
    @csrf
    @method('PUT')
    
    {{-- Input Judul --}}
    <div>
        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Judul Tugas <span class="text-red-500">*</span></label>
        <input type="text" name="judul" value="{{ $tugas->judul }}" required 
            class="w-full p-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all outline-none">
    </div>
    
    {{-- Input Soal/Instruksi --}}
    <div>
        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Soal / Instruksi <span class="text-red-500">*</span></label>
        <textarea name="deskripsi" rows="4" required 
            class="w-full p-4 bg-gray-50 border border-gray-200 rounded-2xl text-sm font-medium text-gray-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all outline-none leading-relaxed">{{ $tugas->deskripsi }}</textarea>
    </div>
    
    {{-- Input Batas Waktu (Bento Style) --}}
    <div>
        <label class="block text-[10px] font-black text-red-400 uppercase tracking-widest mb-2 flex items-center">
            <i class="fas fa-stopwatch mr-1.5"></i> Batas Waktu (Deadline) <span class="text-red-500 ml-1">*</span>
        </label>
        <input type="datetime-local" name="batas_waktu" value="{{ $tugas->batas_waktu->format('Y-m-d\TH:i') }}" required 
            class="w-full p-3.5 border border-red-200 rounded-xl text-sm font-black text-red-700 bg-red-50 focus:ring-2 focus:ring-red-500 focus:bg-white cursor-pointer shadow-sm transition-all outline-none uppercase tracking-wide">
    </div>

    {{-- BOX UPLOAD FILE (Bento Style) --}}
    <div class="bg-blue-50 border border-blue-100 p-5 rounded-2xl">
        <label class="block text-[10px] font-black text-blue-800 uppercase tracking-widest mb-3">Ganti Lampiran File <span class="text-blue-500 lowercase font-medium tracking-normal">(Opsional)</span></label>
        
        @if($tugas->file_tugas)
            <div class="flex items-center bg-white border border-blue-200 p-3 rounded-xl mb-4 shadow-sm">
                <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center mr-3 shrink-0">
                    <i class="fas fa-paperclip"></i>
                </div>
                <div class="min-w-0 flex-1">
                    <div class="text-[9px] uppercase tracking-wider font-bold text-gray-400">File Saat Ini</div>
                    <div class="text-sm font-bold text-blue-700 truncate">{{ $tugas->file_tugas }}</div>
                </div>
            </div>
        @endif
        
        <span class="block text-[10px] text-blue-400 mb-2">* Kosongkan jika tidak ingin mengubah file lama</span>
        <input type="file" name="file_tugas" accept=".pdf,.doc,.docx,.jpg,.png" 
            class="w-full text-sm font-medium text-gray-600 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-100 file:text-blue-700 hover:file:bg-blue-200 transition-all bg-white border border-blue-200 rounded-xl p-1.5 shadow-sm outline-none cursor-pointer">
    </div>

    <div class="pt-4 border-t border-gray-100 mt-6">
        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-4 rounded-xl shadow-lg shadow-blue-200 transition-all uppercase tracking-widest text-[11px] flex items-center justify-center gap-2">
            <i class="fas fa-save"></i> Simpan Perubahan Tugas
        </button>
    </div>
</form>