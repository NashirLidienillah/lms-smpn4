{{-- Toast Notifikasi Sukses Buka Akses --}}
@if(session('success'))
    <div id="toast-success" class="fixed top-5 right-5 flex items-center w-full max-w-xs p-4 mb-4 text-gray-700 bg-white rounded-2xl shadow-xl border-l-4 border-emerald-500 z-50 transition-all duration-500">
        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-emerald-500 bg-emerald-100 rounded-lg"><i class="fas fa-check"></i></div>
        <div class="ml-3 text-sm font-medium">{{ session('success') }}</div>
        <button type="button" class="ml-auto bg-white text-gray-400 hover:text-gray-900 rounded-lg p-1.5 hover:bg-gray-100 h-8 w-8 transition" onclick="document.getElementById('toast-success').remove()"><i class="fas fa-times"></i></button>
    </div>
    <script>setTimeout(() => { document.getElementById('toast-success')?.remove(); }, 3500);</script>
@endif

{{-- Header Actions (Hidden on Print) --}}
<div class="print:hidden mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <a href="/guru/kelas/{{ $jadwal->id }}" class="group inline-flex items-center text-sm font-bold text-gray-400 hover:text-indigo-600 transition">
        <div class="w-8 h-8 rounded-lg bg-white border border-gray-100 group-hover:bg-indigo-50 flex items-center justify-center mr-3 transition shadow-sm">
            <i class="fas fa-arrow-left text-xs"></i>
        </div>
        Kembali ke Ruang Kelas
    </a>
    <button onclick="window.print()" class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-black px-5 py-3 rounded-xl shadow-lg shadow-indigo-100 transition-all uppercase tracking-widest text-xs flex items-center justify-center gap-2 active:scale-95">
        <i class="fas fa-print text-sm"></i> Cetak Catatan Nilai
    </button>
</div>

{{-- Title Section --}}
<div class="mb-6 print:hidden">
    <h1 class="text-3xl font-black text-gray-800 tracking-tight">Rekap Nilai Siswa</h1>
    <p class="text-gray-500 text-sm mt-1">Kumpulan riwayat hasil nilai tugas esai, Kuis dan Ujian siswa.</p>
</div>