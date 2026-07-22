{{-- Konten Tab Kuis & Ujian --}}
<div id="konten-ujian" class="grid grid-cols-1 lg:grid-cols-3 gap-8 hidden transition-all">
    <div class="lg:col-span-2 space-y-4">
        @forelse($ujians as $ujian)
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-center gap-6 group hover:shadow-xl transition-all duration-300">
                <div class="flex items-center gap-5 w-full">
                    <div class="w-16 h-16 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-3xl shrink-0 group-hover:rotate-6 transition-transform">
                        <i class="fas fa-laptop-code"></i>
                    </div>
                    <div class="w-full">
                        <div class="flex items-center gap-2 mb-1">
                            <h4 class="font-bold text-gray-800 text-xl leading-tight group-hover:text-blue-600 transition-colors">{{ $ujian->judul }}</h4>
                            @if(isset($ujian->is_published) && $ujian->is_published)
                                <span class="bg-blue-100 text-blue-700 text-[9px] font-black px-2.5 py-0.5 rounded-full uppercase tracking-wider flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-600 animate-pulse"></span> Diterbitkan
                                </span>
                            @else
                                <span class="bg-gray-100 text-gray-500 text-[9px] font-black px-2.5 py-0.5 rounded-full uppercase tracking-wider">Draft</span>
                            @endif
                        </div>
                        <div class="flex flex-wrap gap-4 text-[10px] font-black text-gray-400 uppercase tracking-widest mt-2">
                            <span><i class="fas fa-stopwatch text-blue-500 mr-1"></i> Durasi: {{ $ujian->durasi }} Menit</span>
                            <span><i class="far fa-clock text-gray-400 mr-1"></i> Mulai: {{ $ujian->mulai ? $ujian->mulai->format('d M, H:i') : '-' }}</span>
                        </div>
                        
                        <div class="mt-4 flex flex-wrap items-center gap-2">
                            {{-- Tombol Atur Soal --}}
                            <a href="/guru/ujian/{{ $ujian->id }}" class="bg-blue-600 hover:bg-blue-700 text-white text-[10px] font-black px-4 py-2.5 rounded-xl uppercase tracking-wider transition shadow-lg shadow-blue-100 flex items-center gap-2">
                                <i class="fas fa-list-check"></i> Atur Daftar Soal
                            </a>

                            {{-- Tombol Terbitkan / Sembunyikan --}}
                            <form action="/guru/ujian/{{ $ujian->id }}/publish" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="border border-gray-200 hover:bg-gray-50 text-gray-600 text-[10px] font-black px-4 py-2.5 rounded-xl uppercase tracking-wider transition flex items-center gap-1.5">
                                <i class="fas {{ isset($ujian->is_published) && $ujian->is_published ? 'fa-eye-slash text-amber-500' : 'fa-paper-plane text-blue-600' }}"></i>
                            {{ isset($ujian->is_published) && $ujian->is_published ? 'Batal Terbitkan' : 'Terbitkan' }}
                        </button>
                    </form>
                        </div>
                    </div>
                </div>

                {{-- Tombol Akses Edit & Hapus --}}
                <div class="flex sm:flex-col gap-2 w-full sm:w-auto shrink-0">
                    <a href="/guru/ujian/{{ $ujian->id }}/edit" class="flex-1 sm:w-10 sm:h-10 rounded-xl bg-gray-50 text-gray-400 hover:bg-blue-50 flex items-center justify-center border border-gray-100 hover:text-blue-600 transition-colors" title="Edit Pengaturan">
                        <i class="fas fa-cog"></i>
                    </a>
                    <form id="form-hapus-ujian-{{ $ujian->id }}" action="/guru/ujian/{{ $ujian->id }}" method="POST" class="flex-1">
                        @csrf 
                        @method('DELETE') 
                        <button type="button" onclick="hapusDataAdminStyle('form-hapus-ujian-{{ $ujian->id }}', 'Evaluasi: {{ $ujian->judul }}')" class="w-full sm:w-10 sm:h-10 rounded-xl bg-gray-50 text-gray-400 hover:bg-red-50 flex items-center justify-center border border-gray-100 text-red-500 hover:text-red-700 transition-colors" title="Hapus Ujian">
                            <i class="fas fa-trash-alt text-sm"></i>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-gray-50 border-2 border-dashed border-gray-200 rounded-3xl p-16 text-center">
                <div class="w-20 h-20 bg-white text-gray-200 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-sm text-3xl"><i class="fas fa-vial"></i></div>
                <h4 class="font-bold text-gray-400">Belum ada evaluasi kuis atau ujian.</h4>
            </div>
        @endforelse
    </div>

    {{-- Form Tambah Ujian (Sudah Dilengkapi Input Mulai & Selesai) --}}
    <div class="lg:col-span-1">
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden sticky top-6">
            <div class="bg-blue-600 px-6 py-5 flex items-center gap-3">
                <i class="fas fa-plus-circle text-white text-xl"></i>
                <h3 class="font-bold text-white uppercase tracking-wider text-sm">Tambah Ujian</h3>
            </div>
            <form action="/guru/kelas/{{ $jadwal->id }}/ujian" method="POST" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-black text-gray-500 uppercase mb-2">Judul Evaluasi</label>
                    <input type="text" name="judul" required placeholder="Contoh: Ulangan Harian Bab 1" class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-black text-gray-500 uppercase mb-2">Durasi (Menit)</label>
                    <input type="number" name="durasi" required placeholder="60" class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                
                {{-- Input Waktu Mulai --}}
                <div>
                    <label class="block text-xs font-black text-blue-800 uppercase mb-2">Waktu Dibuka (Mulai)</label>
                    <input type="datetime-local" name="mulai" required class="w-full p-3 bg-blue-50/50 border border-blue-100 rounded-xl text-xs font-bold text-blue-700 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                {{-- Input Waktu Selesai --}}
                <div>
                    <label class="block text-xs font-black text-red-800 uppercase mb-2">Waktu Ditutup (Selesai)</label>
                    <input type="datetime-local" name="selesai" required class="w-full p-3 bg-red-50/50 border border-red-100 rounded-xl text-xs font-bold text-red-700 focus:ring-2 focus:ring-red-500 outline-none">
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-4 rounded-2xl shadow-lg shadow-blue-100 transition-all uppercase tracking-widest text-xs mt-2">
                    Simpan Jadwal Kuis
                </button>
            </form>
        </div>
    </div>
</div>  