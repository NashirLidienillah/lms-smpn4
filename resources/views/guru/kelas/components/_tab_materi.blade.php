{{-- Konten Tab Materi --}}
<div id="konten-materi" class="grid grid-cols-1 lg:grid-cols-3 gap-8 transition-all">
    <div class="lg:col-span-2 space-y-4">
        @forelse($materis as $materi)
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex flex-col sm:flex-row justify-between items-start gap-4 hover:shadow-xl transition-all duration-300 group">
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl shrink-0 transition-transform group-hover:scale-110 {{ $materi->tipe === 'file' ? 'bg-orange-50 text-orange-500' : 'bg-red-50 text-red-500' }}">
                        <i class="fas {{ $materi->tipe === 'file' ? 'fa-file-pdf' : 'fa-play-circle' }}"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800 text-lg group-hover:text-blue-600 transition-colors">{{ $materi->judul }}</h4>
                        <p class="text-gray-400 text-xs leading-relaxed mt-1 mb-4">{{ $materi->deskripsi ?? 'Belum ada deskripsi tambahan.' }}</p>
                        <div class="flex flex-wrap items-center gap-3">
                            <span class="text-[10px] font-black text-gray-300 uppercase tracking-widest"><i class="far fa-clock mr-1"></i> {{ $materi->created_at->diffForHumans() }}</span>
                            @if($materi->tipe === 'file')
                                <a href="{{ asset('storage/materi/' . $materi->file_path) }}" target="_blank" class="text-[10px] font-black bg-orange-100 text-orange-600 px-4 py-2 rounded-lg uppercase tracking-wider hover:bg-orange-600 hover:text-white transition-all"><i class="fas fa-file-download mr-1"></i> Unduh Materi</a>
                            @else
                                <a href="{{ $materi->url_youtube }}" target="_blank" class="text-[10px] font-black bg-red-100 text-red-600 px-4 py-2 rounded-lg uppercase tracking-wider hover:bg-red-600 hover:text-white transition-all"><i class="fab fa-youtube mr-1"></i> Tautan Video</a>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="flex sm:flex-col gap-2 w-full sm:w-auto">
                    <a href="/guru/materi/{{ $materi->id }}/edit" class="flex-1 sm:w-10 sm:h-10 rounded-xl bg-gray-50 text-gray-400 hover:bg-blue-50 hover:text-blue-600 flex items-center justify-center transition border border-gray-100"><i class="fas fa-pen text-sm"></i></a>
                    <form id="form-hapus-materi-{{ $materi->id }}" action="/guru/materi/{{ $materi->id }}" method="POST" class="flex-1">
                        @csrf @method('DELETE') 
                        <button type="button" onclick="hapusDataAdminStyle('form-hapus-materi-{{ $materi->id }}', 'Materi: {{ $materi->judul }}')" class="w-full sm:w-10 sm:h-10 rounded-xl bg-gray-50 text-gray-400 hover:bg-red-50 hover:text-red-600 flex items-center justify-center transition border border-gray-100"><i class="fas fa-trash-alt text-sm"></i></button>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-gray-50 border-2 border-dashed border-gray-200 rounded-3xl p-16 text-center">
                <div class="w-20 h-20 bg-white text-gray-200 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-sm text-3xl"><i class="fas fa-folder-open"></i></div>
                <h4 class="font-bold text-gray-400">Belum ada materi pembelajaran tercatat.</h4>
            </div>
        @endforelse
    </div>
    
    <div class="lg:col-span-1">
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden sticky top-6">
            <div class="bg-blue-600 px-6 py-5 flex items-center gap-3">
                <i class="fas fa-plus-circle text-white text-xl"></i>
                <h3 class="font-bold text-white uppercase tracking-wider text-sm">Tambah Materi</h3>
            </div>
            <form action="/guru/kelas/{{ $jadwal->id }}/materi" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
                @csrf
                <div>
                    <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Judul Materi</label>
                    <input type="text" name="judul" required placeholder="Contoh: Pertemuan 1 - Pengenalan Dasar" class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:bg-white transition">
                </div>
                <div>
                    <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Jenis Sumber</label>
                    <select name="tipe" id="tipe_materi" onchange="toggleTipeInput()" class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="file">📄 Berkas Dokumen (PDF / Word)</option>
                        <option value="youtube">📺 Video Pembelajaran (YouTube)</option>
                    </select>
                </div>
                <div id="box_file" class="p-4 bg-orange-50/50 border border-orange-100 rounded-2xl">
                    <label class="block text-[10px] font-black text-orange-700 uppercase mb-2">Pilih File</label>
                    <input type="file" name="file_materi" class="w-full text-xs text-orange-600 font-medium">
                </div>
                <div id="box_youtube" class="p-4 bg-red-50/50 border border-red-100 rounded-2xl hidden">
                    <label class="block text-[10px] font-black text-red-700 uppercase mb-2">Link YouTube</label>
                    <input type="url" name="url_youtube" placeholder="https://youtube.com/..." class="w-full p-2.5 bg-white border border-red-200 rounded-xl text-xs">
                </div>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-4 rounded-2xl shadow-lg shadow-blue-100 transition-all active:scale-95 uppercase tracking-widest text-xs">Simpan Data Materi</button>
            </form>
        </div>
    </div>
</div>