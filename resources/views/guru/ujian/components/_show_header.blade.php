@if(session('success'))
    <div id="toast-success" class="fixed top-5 right-5 flex items-center w-full max-w-xs p-4 mb-4 text-gray-700 bg-white rounded-2xl shadow-xl border-l-4 border-emerald-500 z-50 transition-all duration-500">
        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-emerald-500 bg-emerald-100 rounded-lg"><i class="fas fa-check"></i></div>
        <div class="ml-3 text-sm font-medium">{{ session('success') }}</div>
        <button type="button" class="ml-auto bg-white text-gray-400 hover:text-gray-900 rounded-lg p-1.5 hover:bg-gray-100 h-8 w-8 transition" onclick="document.getElementById('toast-success').remove()"><i class="fas fa-times"></i></button>
    </div>
    <script>setTimeout(() => { document.getElementById('toast-success')?.remove(); }, 3500);</script>
@endif

<div class="mb-6">
    <a href="/guru/kelas/{{ $ujian->guru_mapel_id }}" class="group inline-flex items-center text-sm font-bold text-gray-400 hover:text-emerald-600 transition">
        <div class="w-8 h-8 rounded-lg bg-gray-100 group-hover:bg-emerald-50 flex items-center justify-center mr-3 transition">
            <i class="fas fa-arrow-left text-xs"></i>
        </div>
        Kembali ke Ruang Kelas
    </a>
</div>

<div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100 mb-8 flex flex-col lg:flex-row justify-between items-start lg:items-center relative overflow-hidden">
    <div class="absolute left-0 top-0 h-full w-2 bg-emerald-600"></div>
    <div class="relative z-10">
        <div class="flex items-center gap-3 mb-2">
            <span class="bg-emerald-50 text-emerald-600 text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-widest border border-emerald-100">Dapur Ujian CBT</span>
            <span class="text-gray-300">•</span>
            <span class="text-xs font-bold text-gray-400"><i class="fas fa-stopwatch mr-1"></i> {{ $ujian->durasi }} Menit</span>
        </div>
        <h2 class="text-3xl font-black text-gray-800 tracking-tight">{{ $ujian->judul }}</h2>
        <p class="text-gray-500 text-sm mt-1 font-medium">Pastikan semua kunci jawaban sudah benar sebelum dibagikan ke siswa.</p>
    </div>
    
    <div class="mt-6 lg:mt-0 flex flex-col sm:flex-row gap-4 w-full lg:w-auto">
        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 flex-1">
            <span class="block text-[9px] text-gray-400 font-black uppercase tracking-wider mb-2">Periode Akses</span>
            <div class="space-y-1.5">
                <div class="flex items-center gap-2 text-xs font-bold text-gray-700">
                    <i class="fas fa-door-open text-emerald-500 w-4"></i> {{ $ujian->mulai->format('d M, H:i') }}
                </div>
                <div class="flex items-center gap-2 text-xs font-bold text-gray-700">
                    <i class="fas fa-door-closed text-red-500 w-4"></i> {{ $ujian->selesai->format('d M, H:i') }}
                </div>
            </div>
        </div>
        <div class="bg-emerald-600 p-4 rounded-2xl text-white flex flex-col justify-center items-center px-8 shadow-lg shadow-emerald-100 flex-1">
            <span class="text-[9px] font-black uppercase tracking-widest opacity-70">Total Soal</span>
            <span class="text-3xl font-black">{{ count($ujian->soals) }}</span>
        </div>
    </div>
</div>