{{-- SIDEBAR NAVIGASI NOMOR SOAL (KANAN) --}}
<div class="lg:col-span-4">
    <div class="sticky top-24 md:top-32 bg-white rounded-2xl md:rounded-[2rem] border border-gray-100 shadow-sm p-5 md:p-6 text-center">
        <h4 class="text-[9px] md:text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-4 md:mb-6">Navigasi Soal</h4>
        
        <div class="grid grid-cols-5 gap-2 md:gap-3">
            @foreach($ujian->soals as $index => $soal)
            <a href="#soal-card-{{ $index + 1 }}" 
               id="nav-number-{{ $index + 1 }}"
               class="w-full aspect-square rounded-lg md:rounded-xl bg-gray-50 text-gray-400 border border-gray-100 flex items-center justify-center text-[10px] md:text-xs font-black transition-all hover:bg-gray-100">
                {{ $index + 1 }}
            </a>
            @endforeach
        </div>
        
        <div class="mt-6 md:mt-8 pt-4 md:pt-6 border-t border-dashed border-gray-200">
            <p class="text-[8px] md:text-[9px] font-black text-red-500 uppercase leading-relaxed flex items-center justify-center gap-1">
                <i class="fas fa-lock text-[10px]"></i> Mode Aman Aktif
            </p>
        </div>
    </div>
</div>