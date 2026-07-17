{{-- Header Info Kelas --}}
<div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100 mb-8 flex flex-col md:flex-row justify-between items-start md:items-center relative overflow-hidden">
    <div class="absolute left-0 top-0 h-full w-2 bg-blue-600"></div>
    <div class="relative z-10">
        <div class="flex items-center gap-3 mb-2">
            <span class="bg-blue-50 text-blue-600 text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-[0.1em] border border-blue-100">Kelola Ruang Kelas</span>
            <span class="text-gray-300">•</span>
            <span class="text-sm font-bold text-gray-400">Kelas {{ $jadwal->kelas->nama_kelas }}</span>
        </div>
        <h2 class="text-3xl md:text-4xl font-black text-gray-800 tracking-tight">{{ $jadwal->mapel->nama_mapel }}</h2>
    </div>
    
    <div class="mt-6 md:mt-0 bg-slate-50 p-5 rounded-2xl border border-slate-100 flex items-center gap-4 min-w-[200px]">
        <div class="w-12 h-12 rounded-xl bg-white shadow-sm flex items-center justify-center text-blue-600 text-xl">
            <i class="fas fa-calendar-alt"></i>
        </div>
        <div>
            <span class="block text-[10px] text-gray-400 font-black uppercase tracking-wider">Jadwal Pelajaran</span>
            <span class="block text-gray-800 font-extrabold text-sm">{{ $jadwal->hari }}</span>
            <span class="block text-xs text-gray-500 font-medium">{{ substr($jadwal->jam_mulai, 0, 5) }} - {{ substr($jadwal->jam_selesai, 0, 5) }} WIB</span>
        </div>
    </div>
</div>