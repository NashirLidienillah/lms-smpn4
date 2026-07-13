{{-- KOLOM DAFTAR PERTANYAAN (KIRI) --}}
<div class="lg:col-span-8 space-y-4 md:space-y-6">
    @foreach($ujian->soals as $index => $soal)
    <div id="soal-card-{{ $index + 1 }}" class="bg-white rounded-2xl md:rounded-[2rem] shadow-sm border border-gray-100 p-5 md:p-10 transition-all">
        <div class="flex items-start gap-3 md:gap-5 mb-6">
            <div class="w-8 h-8 md:w-11 md:h-11 rounded-lg md:rounded-xl bg-gray-900 text-white flex items-center justify-center font-black shrink-0 shadow-lg text-sm md:text-base">
                {{ $index + 1 }}
            </div>
            <p class="text-base md:text-xl font-bold text-gray-800 leading-relaxed whitespace-pre-wrap">{{ $soal->pertanyaan }}</p>
        </div>
        
        {{-- Opsi Pilihan Ganda --}}
        <div class="grid grid-cols-1 gap-2 md:gap-3">
            @foreach(['a', 'b', 'c', 'd'] as $huruf)
            @php $nama_kolom = 'pilihan_' . $huruf; @endphp
            <label class="group relative flex items-center p-3 md:p-5 border-2 border-gray-100 rounded-xl md:rounded-2xl cursor-pointer transition-all hover:bg-emerald-50/50 hover:border-emerald-200 has-[:checked]:bg-emerald-50 has-[:checked]:border-emerald-500 shadow-sm">
                <input type="radio" name="jawaban[{{ $soal->id }}]" value="{{ strtoupper($huruf) }}" 
                       onchange="markAnswered({{ $index + 1 }})"
                       class="hidden peer" required>
                
                <div class="w-8 h-8 md:w-10 md:h-10 rounded-lg md:rounded-xl bg-gray-100 text-gray-500 font-black flex items-center justify-center transition-all peer-checked:bg-emerald-600 peer-checked:text-white shrink-0 uppercase text-xs md:text-sm shadow-sm">
                    {{ $huruf }}
                </div>
                
                <span class="ml-3 md:ml-4 text-xs md:text-base font-bold text-gray-600 peer-checked:text-emerald-900 transition-colors">
                    {{ $soal->$nama_kolom }}
                </span>

                <i class="fas fa-check-circle ml-auto text-emerald-500 opacity-0 peer-checked:opacity-100 transition-opacity text-sm md:text-lg"></i>
            </label>
            @endforeach
        </div>
    </div>
    @endforeach
</div>