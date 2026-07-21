<form action="/guru/ujian/{{ $ujian->id }}" method="POST" class="p-6 md:p-8 space-y-6">
    @csrf
    @method('PUT')
    
    <div>
        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Judul Kuis / Ujian <span class="text-red-500">*</span></label>
        <input type="text" name="judul" value="{{ $ujian->judul }}" required 
            class="w-full p-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all outline-none">
    </div>
    
    <div>
        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Durasi Pengerjaan <span class="text-red-500">*</span></label>
        <div class="relative flex items-center">
            <input type="number" name="durasi" value="{{ $ujian->durasi }}" required min="1" 
                class="w-full p-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 pr-16 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all outline-none">
            <span class="absolute right-4 text-gray-400 text-[10px] font-black uppercase tracking-widest pointer-events-none">Menit</span>
        </div>
    </div>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="bg-blue-50 border border-blue-100 p-5 rounded-2xl">
            <label class="block text-[10px] font-black text-blue-800 uppercase tracking-widest mb-3 flex items-center">
                <i class="fas fa-play-circle mr-1.5 text-blue-600"></i> Waktu Dibuka <span class="text-red-500 ml-1">*</span>
            </label>
            <input type="datetime-local" name="mulai" value="{{ $ujian->mulai->format('Y-m-d\TH:i') }}" required 
                class="w-full p-3 bg-white border border-blue-200 rounded-xl text-sm font-black text-blue-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 cursor-pointer shadow-sm transition-all outline-none uppercase tracking-wide">
        </div>
        
        <div class="bg-red-50 border border-red-100 p-5 rounded-2xl">
            <label class="block text-[10px] font-black text-red-800 uppercase tracking-widest mb-3 flex items-center">
                <i class="fas fa-stop-circle mr-1.5 text-red-600"></i> Waktu Ditutup <span class="text-red-500 ml-1">*</span>
            </label>
            <input type="datetime-local" name="selesai" value="{{ $ujian->selesai->format('Y-m-d\TH:i') }}" required 
                class="w-full p-3 bg-white border border-red-200 rounded-xl text-sm font-black text-red-700 focus:ring-2 focus:ring-red-500 focus:border-red-500 cursor-pointer shadow-sm transition-all outline-none uppercase tracking-wide">
        </div>
    </div>

    <div class="pt-4 border-t border-gray-100 mt-6">
        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-4 rounded-xl shadow-lg shadow-blue-200 transition-all uppercase tracking-widest text-[11px] flex items-center justify-center gap-2">
            <i class="fas fa-save"></i> Simpan Pengaturan Kuis / Ujian
        </button>
    </div>
</form>