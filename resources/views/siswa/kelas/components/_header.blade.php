{{-- Tombol Kembali & Header Kelas --}}
<div class="flex flex-col gap-4">
    
    <div class="bg-gradient-to-br from-blue-600 to-indigo-800 rounded-[2rem] p-8 md:p-10 text-white shadow-xl relative overflow-hidden">
        <div class="absolute right-0 top-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-20 -mt-20"></div>
        
        <div class="relative z-10">
            <div class="flex items-center gap-3 mb-3">
                <span class="bg-white/20 backdrop-blur-md text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-widest border border-white/30">Ruang Belajar</span>
                <span class="text-blue-200 opacity-50">•</span>
                <span class="text-sm font-bold text-blue-100">Siswa Aktif</span>
            </div>
            <h1 class="text-3xl md:text-5xl font-black mb-2 tracking-tight">{{ $jadwal->mapel->nama_mapel }}</h1>
            <div class="flex items-center gap-2 text-blue-100 font-medium opacity-90">
                <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center border border-white/20">
                    <i class="fas fa-user-tie text-xs"></i>
                </div>
                <span>Guru Pengampu: {{ $jadwal->user->name }}</span>
            </div>
        </div>
        <i class="fas fa-book-reader absolute right-10 bottom-4 text-white opacity-5 text-9xl hidden md:block"></i>
    </div>
</div>