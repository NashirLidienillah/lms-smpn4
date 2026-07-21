<div class="lg:col-span-2 space-y-6">
    <div class="flex justify-between items-center px-2">
        <h3 class="font-black text-gray-800 text-lg uppercase tracking-tight flex items-center gap-3">
            <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center text-sm"><i class="fas fa-list-ul"></i></div>
            List Pertanyaan
        </h3>
        <a href="/guru/ujian/{{ $ujian->id }}/rekap" class="bg-white border border-blue-200 text-blue-600 hover:bg-blue-600 hover:text-white text-[10px] font-black px-4 py-2.5 rounded-xl uppercase tracking-widest transition shadow-sm flex items-center gap-2">
            <i class="fas fa-chart-pie"></i> Rekap Nilai
        </a>
    </div>

    @forelse($ujian->soals as $index => $soal)
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 relative group transition-all duration-300 hover:shadow-xl">
            <div class="absolute -left-3 top-6 w-10 h-10 bg-blue-600 text-white font-black rounded-xl flex items-center justify-center border-4 border-white shadow-lg group-hover:scale-110 transition-transform">
                {{ $index + 1 }}
            </div>
            
            <div class="absolute right-6 top-6 flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                <a href="/guru/soal/{{ $soal->id }}/edit" class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center border border-blue-100 hover:bg-blue-600 hover:text-white transition shadow-sm">
                    <i class="fas fa-pen text-[10px]"></i>
                </a>
                <form action="/guru/soal/{{ $soal->id }}" method="POST" onsubmit="return confirm('Hapus soal ini?');">
                    @csrf @method('DELETE')
                    <button type="submit" class="w-8 h-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center border border-red-100 hover:bg-red-600 hover:text-white transition shadow-sm">
                        <i class="fas fa-trash-alt text-[10px]"></i>
                    </button>
                </form>
            </div>

            <div class="pl-8 pt-2">
                <div class="mb-6">
                    <p class="text-gray-800 font-bold leading-relaxed whitespace-pre-wrap">{{ $soal->pertanyaan }}</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach(['a', 'b', 'c', 'd'] as $opsi)
                        @php 
                            $isCorrect = ($soal->kunci_jawaban == $opsi);
                            $pilihanText = $soal->{'pilihan_' . $opsi};
                        @endphp
                        <div class="p-4 rounded-2xl border transition-all duration-300 flex items-center gap-3 {{ $isCorrect ? 'bg-blue-50 border-blue-200 ring-2 ring-blue-500/20' : 'bg-gray-50 border-gray-100 grayscale-[0.5] opacity-70' }}">
                            <div class="w-7 h-7 rounded-lg flex items-center justify-center text-[10px] font-black uppercase shrink-0 {{ $isCorrect ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-500' }}">
                                {{ $opsi }}
                            </div>
                            <span class="text-xs font-bold {{ $isCorrect ? 'text-blue-900' : 'text-gray-600' }}">{{ $pilihanText }}</span>
                            @if($isCorrect)
                                <i class="fas fa-check-circle text-blue-600 ml-auto"></i>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @empty
        <div class="bg-gray-50 border-2 border-dashed border-gray-200 rounded-3xl p-16 text-center">
            <div class="w-20 h-20 bg-white text-gray-200 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-sm text-3xl"><i class="fas fa-file-medical"></i></div>
            <h4 class="font-bold text-gray-400">Belum ada pertanyaan di bank soal.</h4>
        </div>
    @endforelse
</div>