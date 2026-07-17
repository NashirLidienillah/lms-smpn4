{{-- Menu Tab Navigasi --}}
<div class="bg-gray-100/50 p-1.5 rounded-2xl flex flex-wrap gap-1 mb-8 shadow-inner border border-gray-200/50">
    <button onclick="gantiTab('materi')" id="btn-tab-materi" class="flex-1 min-w-[120px] py-3.5 rounded-xl text-sm font-black transition-all duration-300 flex items-center justify-center gap-2">
        <i class="fas fa-book-open"></i> Materi
    </button>
    <button onclick="gantiTab('tugas')" id="btn-tab-tugas" class="flex-1 min-w-[120px] py-3.5 rounded-xl text-sm font-black transition-all duration-300 flex items-center justify-center gap-2">
        <i class="fas fa-tasks"></i> Tugas Kelas
    </button>
    <button onclick="gantiTab('ujian')" id="btn-tab-ujian" class="flex-1 min-w-[120px] py-3.5 rounded-xl text-sm font-black transition-all duration-300 flex items-center justify-center gap-2">
        <i class="fas fa-vial"></i> Kuis & Ujian
    </button>
</div>