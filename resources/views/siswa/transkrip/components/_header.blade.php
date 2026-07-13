{{-- TOP HERO HEADER (Bento style on screen, clean title layout on print) --}}
<div class="bg-gradient-to-br from-indigo-600 to-blue-700 rounded-3xl p-8 md:p-12 text-white shadow-xl relative overflow-hidden print:bg-none print:text-black print:shadow-none print:p-0 print:border-b-2 print:border-black print:rounded-none">
    <div class="absolute right-0 top-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-20 -mt-20 print:hidden"></div>
    
    <div class="relative z-10 flex flex-col sm:flex-row justify-between items-center gap-6">
        <div class="text-center sm:text-left">
            <div class="flex items-center justify-center sm:justify-start gap-2 mb-3 print:hidden">
                <span class="bg-white/20 backdrop-blur-md text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-[0.2em] border border-white/30">Akademik</span>
                <span class="text-blue-200 opacity-50">•</span>
                <span class="text-sm font-bold text-blue-100">SMPN 4 Kota Serang</span>
            </div>
            <h1 class="text-3xl md:text-5xl font-black tracking-tight mb-2 print:text-3xl print:text-black">Transkrip Nilai Siswa</h1>
            <p class="text-blue-100 text-sm md:text-base font-medium opacity-80 print:text-black">Rangkuman akumulasi hasil capaian belajar mandiri Anda.</p>
        </div>
        
        <div class="bg-white/10 backdrop-blur-md p-6 rounded-2xl border border-white/20 text-center min-w-[200px] print:bg-transparent print:border-none print:p-0 print:text-right">
            <span class="block text-[10px] font-black uppercase tracking-widest opacity-70 mb-1 print:text-black">Nama Siswa</span>
            <span class="text-xl font-black print:text-black">{{ Auth::user()->name }}</span>
        </div>
    </div>
</div>