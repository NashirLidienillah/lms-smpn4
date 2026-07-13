{{-- Modal Pop-Up Pengumuman --}}
<div id="modal-pengumuman" class="fixed inset-0 z-[100] hidden">
    <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="tutupModalPengumuman()"></div>
    
    <div class="flex items-center justify-center min-h-screen p-4 sm:p-6 text-center">
        <div class="relative bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all w-full max-w-2xl flex flex-col">
            
            <div class="bg-amber-500 px-6 md:px-8 py-5 flex justify-between items-center relative overflow-hidden">
                <i class="fas fa-bullhorn absolute right-5 -bottom-4 text-amber-400/30 text-7xl"></i>
                <div class="relative z-10">
                    <span class="bg-amber-400/50 text-amber-900 text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-widest border border-amber-300 mb-2 inline-block">Info Kelas</span>
                    <h3 class="text-xl font-black text-white">Papan Pengumuman</h3>
                </div>
                <button onclick="tutupModalPengumuman()" class="relative z-10 w-10 h-10 bg-amber-400/50 rounded-full flex items-center justify-center text-white hover:bg-amber-400 transition shadow-sm">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>

            <div class="p-6 md:p-8 max-h-[70vh] overflow-y-auto bg-slate-50 space-y-4">
                @forelse($pengumumans as $p)
                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:border-amber-200 transition-all duration-300 relative group">
                        <div class="absolute left-0 top-0 h-full w-1.5 bg-amber-400 rounded-l-2xl"></div>
                        <div class="pl-3">
                            <h4 class="font-bold text-gray-800 text-base md:text-lg mb-1">{{ $p->judul }}</h4>
                            <div class="flex items-center gap-2 mb-3">
                                <span class="text-[10px] font-bold text-amber-600 bg-amber-50 px-2 py-0.5 rounded">
                                    <i class="far fa-clock mr-1"></i> {{ $p->created_at->format('d M Y, H:i') }}
                                </span>
                                <span class="text-[10px] font-bold text-gray-400">Dari Guru</span>
                            </div>
                            <p class="text-gray-600 text-sm leading-relaxed whitespace-pre-wrap">{{ $p->isi_pengumuman }}</p>
                        </div>
                    </div>
                @empty
                    <div class="bg-white border-2 border-dashed border-gray-200 rounded-2xl p-10 text-center">
                        <div class="w-16 h-16 bg-amber-50 text-amber-400 rounded-full flex items-center justify-center mx-auto mb-3 text-2xl"><i class="fas fa-check-circle"></i></div>
                        <h4 class="font-bold text-gray-500 text-sm">Tidak ada pengumuman baru.</h4>
                    </div>
                @endforelse
            </div>
            
        </div>
    </div>
</div>

<script>
    function bukaModalPengumuman() {
        document.getElementById('modal-pengumuman').classList.remove('hidden');
        document.body.style.overflow = 'hidden'; 
    }
    function tutupModalPengumuman() {
        document.getElementById('modal-pengumuman').classList.add('hidden');
        document.body.style.overflow = 'auto'; 
    }
</script>