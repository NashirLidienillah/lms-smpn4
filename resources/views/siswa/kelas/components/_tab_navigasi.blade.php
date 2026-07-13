{{-- Tombol Navigasi 3 Tab --}}
<div class="bg-gray-100/50 p-1.5 rounded-2xl flex flex-wrap gap-1 shadow-inner border border-gray-200/50">
    <button @click="tab = 'materi'" :class="tab === 'materi' ? 'bg-blue-600 text-white shadow-lg shadow-blue-100' : 'text-gray-400 hover:bg-gray-100'" 
        class="flex-1 min-w-[100px] py-3.5 rounded-xl text-sm font-black transition-all duration-300 flex items-center justify-center gap-2">
        <i class="fas fa-book-open"></i> Materi
    </button>
    <button @click="tab = 'tugas'" :class="tab === 'tugas' ? 'bg-purple-600 text-white shadow-lg shadow-purple-100' : 'text-gray-400 hover:bg-gray-100'" 
        class="flex-1 min-w-[100px] py-3.5 rounded-xl text-sm font-black transition-all duration-300 flex items-center justify-center gap-2">
        <i class="fas fa-tasks"></i> Tugas Kelas
    </button>
    <button @click="tab = 'ujian'" :class="tab === 'ujian' ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-100' : 'text-gray-400 hover:bg-gray-100'" 
        class="flex-1 min-w-[100px] py-3.5 rounded-xl text-sm font-black transition-all duration-300 flex items-center justify-center gap-2">
        <i class="fas fa-vial"></i> Kuis & Ujian
    </button>
</div>