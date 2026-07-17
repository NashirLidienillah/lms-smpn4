{{-- Tombol Kembali --}}
<a href="/guru/kelas/{{ $materi->guru_mapel_id }}" class="inline-flex items-center text-xs font-black text-gray-400 hover:text-blue-600 transition-all mb-6 uppercase tracking-widest bg-white px-4 py-2 rounded-xl border border-gray-100 shadow-sm">
    <i class="fas fa-arrow-left mr-2"></i> Batal & Kembali
</a>

{{-- Header Form Bento --}}
<div class="bg-blue-600 px-6 py-5 rounded-t-3xl flex items-center shadow-inner">
    <div class="w-10 h-10 rounded-xl bg-white/20 text-white flex items-center justify-center mr-4 backdrop-blur-sm">
        <i class="fas fa-edit text-lg"></i>
    </div>
    <div>
        <h2 class="text-xl font-black text-white tracking-tight">Edit Materi Pembelajaran</h2>
        <p class="text-blue-100 text-xs mt-0.5 font-medium">Perbarui judul, file, atau tautan video materi.</p>
    </div>
</div>