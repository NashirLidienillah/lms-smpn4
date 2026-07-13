{{-- Konten Tab Materi --}}
<div x-show="tab === 'materi'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" class="grid grid-cols-1 md:grid-cols-2 gap-4">
    @forelse($materis as $materi)
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
            <div class="flex items-start gap-4 mb-4">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl shrink-0 transition-transform group-hover:rotate-6 {{ !empty($materi->file_path) ? 'bg-orange-50 text-orange-500' : 'bg-red-50 text-red-500' }}">
                    <i class="fas {{ !empty($materi->file_path) ? 'fa-file-pdf' : 'fa-play-circle' }}"></i>
                </div>
                <div>
                    <span class="text-[10px] font-black text-gray-300 uppercase tracking-widest">Diterbitkan: {{ $materi->created_at->format('d M Y') }}</span>
                    <h3 class="text-lg font-black text-gray-800 leading-tight group-hover:text-blue-600 transition-colors">{{ $materi->judul }}</h3>
                </div>
            </div>
            <p class="text-gray-500 text-sm leading-relaxed mb-6 line-clamp-2">{{ $materi->deskripsi ?? 'Silakan akses materi yang telah diunggah guru untuk dipelajari.' }}</p>
            
            <div class="flex flex-wrap gap-2 mt-auto">
                @if(!empty($materi->file_path))
                    <a href="{{ asset('storage/materi/' . $materi->file_path) }}" target="_blank" class="flex-1 inline-flex items-center justify-center px-4 py-3 bg-orange-50 text-orange-600 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-orange-600 hover:text-white transition-all border border-orange-100">
                        <i class="fas fa-file-download mr-2"></i> Unduh Berkas
                    </a>
                @endif
                @if(!empty($materi->url_youtube))
                    <a href="{{ $materi->url_youtube }}" target="_blank" class="flex-1 inline-flex items-center justify-center px-4 py-3 bg-red-50 text-red-600 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-red-600 hover:text-white transition-all border border-red-100">
                        <i class="fab fa-youtube mr-2"></i> Putar Video
                    </a>
                @endif
            </div>
        </div>
    @empty
        <div class="col-span-full bg-white rounded-[2rem] border-2 border-dashed border-gray-100 p-16 text-center">
            <div class="w-16 h-16 bg-gray-50 text-gray-200 rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl shadow-inner">
                <i class="fas fa-folder-open"></i>
            </div>
            <h4 class="font-bold text-gray-400">Belum ada materi pembelajaran yang diunggah oleh guru.</h4>
        </div>
    @endforelse
</div>