{{-- STATS HIGHLIGHT CARDS (Hidden automatically on print for clean document archive) --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 print:hidden">
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-5 group hover:shadow-md transition-all">
        <div class="w-14 h-14 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl group-hover:scale-110 transition-transform shadow-inner">
            <i class="fas fa-chart-line"></i>
        </div>
        <div>
            <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Total Mapel</span>
            <span class="text-2xl font-black text-gray-800">{{ count($transkrip) }}</span>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-5 group hover:shadow-md transition-all">
        <div class="w-14 h-14 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl group-hover:scale-110 transition-transform shadow-inner">
            <i class="fas fa-graduation-cap"></i>
        </div>
        <div>
            <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Status Kelulusan</span>
            @php
                $tuntas = collect($transkrip)->where('total_akhir', '>=', 75)->count();
            @endphp
            <span class="text-2xl font-black text-emerald-600">{{ $tuntas }} <small class="text-gray-300 text-xs font-bold">/ {{ count($transkrip) }} Mapel</small></span>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-5 group hover:shadow-md transition-all">
        <div class="w-14 h-14 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl group-hover:scale-110 transition-transform shadow-inner">
            <i class="fas fa-star"></i>
        </div>
        <div>
            <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Rata-rata Nilai</span>
            @php
                $avg = count($transkrip) > 0 ? collect($transkrip)->avg('total_akhir') : 0;
            @endphp
            <span class="text-2xl font-black text-purple-600">{{ number_format($avg, 1) }}</span>
        </div>
    </div>
</div>