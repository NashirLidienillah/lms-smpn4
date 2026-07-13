{{-- Konten Tab Tugas --}}
<div x-show="tab === 'tugas'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" style="display:none" class="space-y-4">
    @forelse($tugass as $tugas)
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-center gap-6 group hover:shadow-xl transition-all duration-300 relative overflow-hidden">
            <div class="absolute left-0 top-0 h-full w-1.5 bg-purple-500"></div>
            <div class="flex items-center gap-5 w-full">
                <div class="w-14 h-14 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-2xl shrink-0"><i class="fas fa-file-signature"></i></div>
                <div>
                    <h3 class="text-xl font-black text-gray-800 tracking-tight">{{ $tugas->judul }}</h3>
                    <div class="flex items-center gap-3 mt-1">
                        <span class="text-[10px] font-black text-red-500 uppercase tracking-widest flex items-center gap-1 bg-red-50 px-2 py-0.5 rounded">
                            <i class="fas fa-hourglass-half"></i> Batas Waktu: {{ \Carbon\Carbon::parse($tugas->batas_waktu)->format('d M, H:i') }}
                        </span>
                    </div>
                </div>
            </div>
            <a href="/siswa/tugas/{{ $tugas->id }}" class="w-full md:w-auto bg-purple-600 hover:bg-purple-700 text-white px-8 py-3.5 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] shadow-lg shadow-purple-100 transition-all flex items-center justify-center gap-2">
                Buka Tugas <i class="fas fa-chevron-right text-[10px]"></i>
            </a>
        </div>
    @empty
        <div class="bg-white rounded-[2rem] border-2 border-dashed border-gray-100 p-16 text-center">
            <div class="w-16 h-16 bg-gray-50 text-gray-200 rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl shadow-inner">
                <i class="fas fa-clipboard-check"></i>
            </div>
            <h4 class="font-bold text-gray-400">Belum ada tugas aktif saat ini.</h4>
        </div>
    @endforelse
</div>