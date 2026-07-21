{{-- Konten Tab Ujian --}}
<div x-show="tab === 'ujian'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" style="display:none" class="space-y-4">
    @forelse($ujians as $ujian)
        <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-center gap-6 group hover:shadow-xl transition-all duration-300 relative overflow-hidden">
            <div class="absolute left-0 top-0 h-full w-2 bg-blue-500 group-hover:w-3 transition-all"></div>
            <div class="text-center md:text-left flex items-center gap-6">
                <div class="w-16 h-16 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-3xl shrink-0 shadow-inner rotate-3 group-hover:rotate-0 transition-transform">
                    <i class="fas fa-laptop-code"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-black text-gray-800 tracking-tight group-hover:text-blue-600 transition-colors">{{ $ujian->judul }}</h3>
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-4 text-[10px] font-black text-gray-400 uppercase tracking-widest mt-2">
                        <span class="flex items-center gap-1.5"><i class="fas fa-stopwatch text-blue-500"></i> Durasi: {{ $ujian->durasi }} Menit</span>
                        <span class="flex items-center gap-1.5"><i class="fas fa-calendar-alt text-gray-400"></i> Tanggal: {{ $ujian->mulai->format('d M Y') }}</span>
                        <span class="flex items-center gap-1.5 text-blue-600 bg-blue-50 px-2 py-0.5 rounded">{{ $ujian->soals->count() }} Butir Soal</span>
                    </div>
                </div>
            </div>
            <a href="/siswa/ujian/{{ $ujian->id }}" class="w-full md:w-auto bg-blue-600 text-white px-10 py-4 rounded-2xl font-black hover:bg-blue-700 shadow-xl shadow-blue-100 transition-all uppercase tracking-widest text-xs flex items-center justify-center gap-2 group-hover:gap-4">
                Mulai Pengerjaan <i class="fas fa-play text-[10px]"></i>
            </a>
        </div>
    @empty
        <div class="bg-white rounded-[2rem] border-2 border-dashed border-gray-200 p-16 text-center">
            <div class="w-16 h-16 bg-gray-50 text-gray-200 rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl shadow-inner">
                <i class="fas fa-vial"></i>
            </div>
            <h4 class="font-bold text-gray-400">Belum ada jadwal kuis atau ujian saat ini.</h4>
        </div>
    @endforelse
</div>