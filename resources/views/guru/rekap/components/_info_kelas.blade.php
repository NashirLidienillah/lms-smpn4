{{-- JUDUL SIMPLE (Hanya Muncul Saat di Print) --}}
<div class="hidden print:block border-b-2 border-black pb-2 mb-4">
    <h2 class="text-2xl font-bold uppercase text-black">Catatan Nilai Kelas</h2>
</div>

{{-- INFORMASI KELAS & GURU (Bento Grid View on Screen, Clean Table on Print) --}}
<div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-end gap-4 print:mb-4">
    
    {{-- Screen Mode: Bento Grid Info --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 w-full print:hidden">
        <div class="bg-slate-50 border border-slate-100 p-4 rounded-2xl flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shadow-inner font-bold"><i class="fas fa-book"></i></div>
            <div class="min-w-0 flex-1">
                <span class="block text-[9px] text-gray-400 font-black uppercase tracking-wider">Mata Pelajaran</span>
                <div class="text-sm font-black text-gray-800 truncate">{{ $jadwal->mapel->nama_mapel }}</div>
            </div>
        </div>
        <div class="bg-slate-50 border border-slate-100 p-4 rounded-2xl flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shadow-inner font-bold"><i class="fas fa-door-open"></i></div>
            <div class="min-w-0 flex-1">
                <span class="block text-[9px] text-gray-400 font-black uppercase tracking-wider">Kelas Belajar</span>
                <div class="text-sm font-black text-gray-800 truncate">Kelas {{ $jadwal->kelas->nama_kelas }}</div>
            </div>
        </div>
        <div class="bg-slate-50 border border-slate-100 p-4 rounded-2xl flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shadow-inner font-bold"><i class="fas fa-user-tie"></i></div>
            <div class="min-w-0 flex-1">
                <span class="block text-[9px] text-gray-400 font-black uppercase tracking-wider">Guru Pengajar  </span>
                <div class="text-sm font-black text-gray-800 truncate">{{ Auth::user()->name }}</div>
            </div>
        </div>
    </div>

    {{-- Print Mode: Clean Text Table --}}
    <div class="hidden print:block">
        <table class="text-sm font-semibold text-black">
            <tr><td class="pr-6 py-1">Mata Pelajaran</td><td>: {{ $jadwal->mapel->nama_mapel }}</td></tr>
            <tr><td class="pr-6 py-1">Kelas</td><td>: {{ $jadwal->kelas->nama_kelas }}</td></tr>
            <tr><td class="pr-6 py-1">Guru Pengampu</td><td>: {{ Auth::user()->name }}</td></tr>
        </table>
    </div>

    {{-- Tanggal cetak untuk referensi guru --}}
    <div class="hidden print:block text-sm text-gray-600 font-medium">
        Dicetak pada: {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
    </div>
</div>