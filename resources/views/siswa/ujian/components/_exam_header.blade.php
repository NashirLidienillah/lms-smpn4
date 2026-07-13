{{-- Sticky Header Navigasi Ujian & Timer --}}
<div class="sticky top-2 md:top-4 z-50 mb-6 px-2 sm:px-0">
    <div class="bg-white/90 backdrop-blur-xl border border-gray-100 shadow-xl rounded-2xl md:rounded-3xl p-3 md:p-5 flex justify-between items-center">
        <div class="hidden md:block">
            <h2 class="font-black text-gray-800 uppercase tracking-tighter">{{ $ujian->judul }}</h2>
            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Siswa: {{ auth()->user()->name }}</p>
        </div>
        
        <div class="md:hidden">
            <span class="block text-[8px] font-black text-gray-400 uppercase tracking-widest leading-none mb-1">Ujian Aktif</span>
            <h2 class="font-bold text-gray-800 text-xs truncate max-w-[120px]">{{ $ujian->judul }}</h2>
        </div>
        
        <div class="flex items-center gap-2 md:gap-4">
            <div class="bg-red-50 text-red-600 px-3 md:px-6 py-2 md:py-3 rounded-xl md:rounded-2xl font-black shadow-inner border border-red-100 flex items-center gap-2 md:gap-3">
                <i class="fas fa-clock text-xs md:text-base animate-pulse"></i> 
                <span id="timer" class="text-sm md:text-xl font-mono tracking-tighter">--:--</span>
            </div>
            <button type="button" onclick="confirmFinish()" class="bg-gray-900 hover:bg-black text-white px-4 md:px-6 py-2 md:py-3 rounded-xl md:rounded-2xl font-black text-[9px] md:text-[10px] uppercase tracking-widest shadow-lg transition active:scale-95">
                Selesai
            </button>
        </div>
    </div>
</div>