@if(session('success'))
    <div id="toast-success" class="fixed top-5 right-5 flex items-center w-full max-w-xs p-4 mb-4 text-gray-700 bg-white rounded-2xl shadow-xl border-l-4 border-emerald-500 z-50 transition-all duration-500">
        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-emerald-500 bg-emerald-100 rounded-lg"><i class="fas fa-check"></i></div>
        <div class="ml-3 text-sm font-medium">{{ session('success') }}</div>
        <button type="button" class="ml-auto bg-white text-gray-400 hover:text-gray-900 rounded-lg p-1.5 hover:bg-gray-100 h-8 w-8 transition" onclick="document.getElementById('toast-success').remove()"><i class="fas fa-times"></i></button>
    </div>
    <script>setTimeout(() => { document.getElementById('toast-success')?.remove(); }, 3500);</script>
@endif

<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <div>
        <h1 class="text-3xl font-black text-gray-800 tracking-tight">Rekap Nilai Kuis dan Ujian</h1>
        <p class="text-gray-500 text-sm mt-1">Ujian: <span class="font-bold text-emerald-600">{{ $ujian->judul }}</span> | Total Soal: {{ $ujian->soals->count() }} Butir</p>
    </div>
    <a href="/guru/ujian/{{ $ujian->id }}" class="bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 px-5 py-2.5 rounded-xl text-sm font-bold transition shadow-sm flex items-center">
        <i class="fas fa-arrow-left mr-2"></i> Kembali
    </a>
</div>