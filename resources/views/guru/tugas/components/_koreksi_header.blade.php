{{-- ================= NOTIFIKASI TOAST ================= --}}
@if(session('success'))
    <div id="toast-success" class="fixed top-5 right-5 flex items-center w-full max-w-xs p-4 mb-4 text-gray-700 bg-white rounded-2xl shadow-xl border-l-4 border-emerald-500 z-50 transition-all duration-500">
        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-emerald-500 bg-emerald-100 rounded-lg"><i class="fas fa-check"></i></div>
        <div class="ml-3 text-sm font-medium">{{ session('success') }}</div>
        <button type="button" class="ml-auto bg-white text-gray-400 hover:text-gray-900 rounded-lg p-1.5 hover:bg-gray-100 h-8 w-8 transition" onclick="document.getElementById('toast-success').remove()"><i class="fas fa-times"></i></button>
    </div>
    <script>setTimeout(() => { document.getElementById('toast-success')?.remove(); }, 3500);</script>
@endif

<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div>
        <a href="/guru/kelas/{{ $tugas->guru_mapel_id }}" class="group inline-flex items-center text-sm font-bold text-gray-400 hover:text-blue-600 transition mb-2">
            <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i> Kembali ke Kelas
        </a>
        <h1 class="text-2xl font-black text-gray-800 tracking-tight">Koreksi Tugas</h1>
        <p class="text-sm text-gray-500">{{ $tugas->judul }}</p>
    </div>
    
    <div class="flex gap-3 w-full md:w-auto">
        <div class="bg-blue-50 border border-blue-100 p-3 px-5 rounded-2xl flex-1 md:flex-none">
            <span class="block text-[10px] font-black text-blue-400 uppercase tracking-widest">Mengumpulkan</span>
            <span class="text-xl font-bold text-blue-700">{{ $pengumpulan->count() }}</span>
        </div>
        <div class="bg-emerald-50 border border-emerald-100 p-3 px-5 rounded-2xl flex-1 md:flex-none">
            <span class="block text-[10px] font-black text-emerald-400 uppercase tracking-widest">Sudah Dinilai</span>
            <span class="text-xl font-bold text-emerald-700">{{ $pengumpulan->whereNotNull('nilai')->count() }}</span>
        </div>
    </div>
</div>