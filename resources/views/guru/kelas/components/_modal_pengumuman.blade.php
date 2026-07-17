{{-- Modal Pop-Up Pengumuman --}}
<div id="modal-pengumuman" class="fixed inset-0 z-[100] hidden">
    <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="tutupModalPengumuman()"></div>
    
    <div class="flex items-center justify-center min-h-screen p-4 sm:p-6 text-center">
        <div class="relative bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all w-full max-w-5xl flex flex-col md:flex-row">
            
            <button onclick="tutupModalPengumuman()" class="absolute top-4 right-4 z-50 w-10 h-10 bg-white md:bg-gray-50 rounded-full flex items-center justify-center text-gray-400 hover:text-red-500 hover:bg-red-50 transition shadow-sm border border-gray-100">
                <i class="fas fa-times text-lg"></i>
            </button>

            {{-- KIRI: Riwayat Pengumuman --}}
            <div class="w-full md:w-3/5 bg-slate-50 p-6 md:p-8 md:max-h-[85vh] overflow-y-auto">
                <div class="mb-6">
                    <h3 class="text-xl font-black text-gray-800"><i class="fas fa-history text-amber-500 mr-2"></i> Riwayat Pengumuman</h3>
                    <p class="text-sm text-gray-500 mt-1">Daftar informasi yang telah dikirim ke siswa kelas ini.</p>
                </div>
                
                <div class="space-y-4">
                    @forelse($pengumumans as $p)
                        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 relative group">
                            <div class="absolute left-0 top-0 h-full w-1.5 bg-amber-500 rounded-l-2xl"></div>
                            <div class="flex justify-between items-start gap-4">
                                <div class="w-full pl-3">
                                    <h4 class="font-bold text-gray-800 text-base">{{ $p->judul }}</h4>
                                    <div class="text-[10px] font-black uppercase text-gray-400 mt-1 mb-2">
                                        <i class="far fa-clock"></i> {{ $p->created_at->format('d M Y, H:i') }}
                                    </div>
                                    <p class="text-gray-600 text-sm leading-relaxed whitespace-pre-wrap">{{ $p->isi_pengumuman }}</p>
                                </div>
                                <form id="form-hapus-pengumuman-{{ $p->id }}" action="/guru/pengumuman/{{ $p->id }}" method="POST" class="shrink-0">
                                    @csrf @method('DELETE') 
                                    <button type="button" onclick="hapusDataAdminStyle('form-hapus-pengumuman-{{ $p->id }}', 'Pengumuman: {{ $p->judul }}')" class="w-8 h-8 rounded-lg bg-gray-50 text-gray-400 hover:bg-red-50 hover:text-red-600 flex items-center justify-center transition border border-gray-100"><i class="fas fa-trash-alt text-xs"></i></button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white border-2 border-dashed border-gray-200 rounded-2xl p-10 text-center">
                            <div class="w-16 h-16 bg-amber-50 text-amber-400 rounded-full flex items-center justify-center mx-auto mb-3 text-2xl"><i class="fas fa-bullhorn"></i></div>
                            <h4 class="font-bold text-gray-500 text-sm">Belum ada pengumuman.</h4>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- KANAN: Form Bikin Pengumuman --}}
            <div class="w-full md:w-2/5 bg-white p-6 md:p-8 border-t md:border-t-0 md:border-l border-gray-100 relative">
                <div class="mb-6">
                    <span class="bg-amber-50 text-amber-600 text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-widest border border-amber-100 mb-2 inline-block">Terbitkan Baru</span>
                    <h3 class="text-xl font-black text-gray-800">Buat Pengumuman</h3>
                </div>
                
                <form action="{{ route('pengumuman.store', $jadwal->kelas_id) }}" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-xs font-black text-gray-500 uppercase mb-2">Judul Pengumuman</label>
                        <input type="text" name="judul" required placeholder="Contoh: Info Ujian Susulan" class="w-full p-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-gray-500 uppercase mb-2">Isi Pengumuman</label>
                        <textarea name="isi_pengumuman" rows="6" required placeholder="Tuliskan detail informasi di sini..." class="w-full p-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 transition"></textarea>
                    </div>
                    <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-white font-black py-4 rounded-xl shadow-lg shadow-amber-200 transition-all uppercase tracking-widest text-xs">
                        <i class="fas fa-paper-plane mr-2"></i> Kirim Pengumuman
                    </button>
                </form>
            </div>
            
        </div>
    </div>
</div>