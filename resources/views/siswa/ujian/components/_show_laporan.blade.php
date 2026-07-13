{{-- Laporan Hasil Ujian (Jika Sudah Selesai) --}}
<div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-8 md:p-12 text-center relative overflow-hidden">
    <div class="absolute top-0 right-0 p-10 opacity-5">
        <i class="fas fa-award text-9xl text-emerald-600"></i>
    </div>

    <h3 class="text-xl font-black text-gray-800 uppercase tracking-widest mb-10">Laporan Hasil Ujian</h3>

    <div class="inline-block relative mb-12">
        <div class="w-56 h-56 rounded-full border-[14px] {{ $hasil->nilai >= 75 ? 'border-emerald-500' : 'border-red-500' }} flex flex-col items-center justify-center bg-white shadow-2xl relative z-10 p-4">
            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Nilai Anda</span>
            <span class="text-7xl font-black {{ $hasil->nilai >= 75 ? 'text-emerald-600' : 'text-red-600' }} leading-none tracking-tighter">
                {{ round($hasil->nilai) }}
            </span>
        </div>
        <div class="absolute inset-0 {{ $hasil->nilai >= 75 ? 'bg-emerald-400/20' : 'bg-red-400/20' }} rounded-full blur-3xl scale-125"></div>
    </div>

    <div class="grid grid-cols-2 gap-4 max-w-md mx-auto mb-10">
        <div class="bg-emerald-50 p-6 rounded-3xl border border-emerald-100 group hover:bg-emerald-100 transition-colors">
            <span class="block text-[10px] font-black text-emerald-400 uppercase tracking-widest mb-1">Benar</span>
            <span class="text-3xl font-black text-emerald-700">{{ $hasil->jumlah_benar }}</span>
        </div>
        <div class="bg-red-50 p-6 rounded-3xl border border-red-100 group hover:bg-red-100 transition-colors">
            <span class="block text-[10px] font-black text-red-400 uppercase tracking-widest mb-1">Salah</span>
            <span class="text-3xl font-black text-red-700">{{ $hasil->jumlah_salah }}</span>
        </div>
    </div>

    <a href="/siswa/dashboard" class="inline-flex items-center justify-center gap-3 bg-gray-900 hover:bg-black text-white font-black py-4 px-10 rounded-2xl transition shadow-xl active:scale-95 uppercase tracking-widest text-xs">
        <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
    </a>
</div>