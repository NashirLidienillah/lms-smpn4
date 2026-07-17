{{-- Konten Tab Tugas --}}
<div id="konten-tugas" class="grid grid-cols-1 lg:grid-cols-3 gap-8 hidden transition-all">
    <div class="lg:col-span-2 space-y-4">
        @forelse($tugas as $t)
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 relative group overflow-hidden">
                <div class="absolute left-0 top-0 h-full w-1.5 bg-purple-500 transition-all group-hover:w-3"></div>
                <div class="flex flex-col md:flex-row justify-between gap-6">
                    <div class="flex gap-5">
                        <div class="w-14 h-14 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-2xl shrink-0"><i class="fas fa-file-signature"></i></div>
                        <div>
                            <h4 class="font-bold text-gray-800 text-lg">{{ $t->judul }}</h4>
                            <div class="inline-flex items-center gap-1.5 text-red-600 text-[10px] font-black uppercase bg-red-50 px-2 py-1 rounded-md mb-3 mt-1">
                                <i class="fas fa-hourglass-half"></i> Batas Pengumpulan: {{ $t->batas_waktu->format('d M, H:i') }}
                            </div>
                            <p class="text-gray-400 text-sm leading-relaxed mb-4">{{ Str::limit($t->deskripsi, 120) }}</p>
                            <a href="/guru/tugas/{{ $t->id }}/koreksi" class="bg-purple-600 hover:bg-purple-700 text-white text-[10px] font-black px-5 py-3 rounded-xl uppercase tracking-widest shadow-lg shadow-purple-100 transition-all flex items-center justify-center w-full sm:w-max">
                                <i class="fas fa-user-edit mr-2"></i> Periksa Lembar Jawaban Siswa
                            </a>
                        </div>
                    </div>
                    <div class="flex sm:flex-col gap-2 shrink-0">
                        <a href="/guru/tugas/{{ $t->id }}/edit" class="w-10 h-10 rounded-xl bg-gray-50 text-gray-400 hover:bg-purple-50 hover:text-purple-600 flex items-center justify-center transition border border-gray-100"><i class="fas fa-pen text-sm"></i></a>
                        <form id="form-hapus-tugas-{{ $t->id }}" action="/guru/tugas/{{ $t->id }}" method="POST">
                            @csrf @method('DELETE') 
                            <button type="button" onclick="hapusDataAdminStyle('form-hapus-tugas-{{ $t->id }}', 'Tugas: {{ $t->judul }}')" class="w-10 h-10 rounded-xl bg-gray-50 text-gray-400 hover:bg-red-50 hover:text-red-600 flex items-center justify-center transition border border-gray-100"><i class="fas fa-trash-alt text-sm"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-gray-50 border-2 border-dashed border-gray-200 rounded-3xl p-16 text-center">
                <div class="w-20 h-20 bg-white text-gray-200 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-sm text-3xl"><i class="fas fa-tasks"></i></div>
                <h4 class="font-bold text-gray-400">Belum ada daftar tugas untuk kelas ini.</h4>
            </div>
        @endforelse
    </div>
    
    <div class="lg:col-span-1">
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden sticky top-6">
            <div class="bg-purple-600 px-6 py-5 flex items-center gap-3">
                <i class="fas fa-plus-circle text-white text-xl"></i>
                <h3 class="font-bold text-white uppercase tracking-wider text-sm">Tambah Tugas Baru</h3>
            </div>
            <form action="/guru/kelas/{{ $jadwal->id }}/tugas" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
                @csrf
                <div>
                    <label class="block text-xs font-black text-gray-500 uppercase mb-2">Judul Tugas</label>
                    <input type="text" name="judul" required placeholder="Contoh: Latihan Soal Bab 1" class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-purple-500 transition">
                </div>
                <div>
                    <label class="block text-xs font-black text-gray-500 uppercase mb-2">Instruksi Pembelajaran</label>
                    <textarea name="deskripsi" rows="3" required placeholder="Tuliskan petunjuk pengerjaan tugas di sini..." class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-purple-500 transition"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-black text-gray-500 uppercase mb-2">Batas Waktu Pengumpulan</label>
                    <input type="datetime-local" name="batas_waktu" required class="w-full p-3 bg-purple-50 border border-purple-100 rounded-xl text-sm text-purple-700 font-bold">
                </div>
                <div class="p-4 bg-gray-50 border border-gray-100 rounded-2xl">
                    <label class="block text-[10px] font-black text-gray-400 uppercase mb-2">Lampiran Dokumen (Opsional)</label>
                    <input type="file" name="file_tugas" class="w-full text-xs">
                </div>
                <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-black py-4 rounded-2xl shadow-lg shadow-purple-100 transition-all uppercase tracking-widest text-xs">Simpan Data Tugas</button>
            </form>
        </div>
    </div>
</div>