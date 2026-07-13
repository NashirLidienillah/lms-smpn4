{{-- Statistik Durasi & Jumlah Soal --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-center gap-4">
        <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-xl shrink-0"><i class="fas fa-hourglass-half"></i></div>
        <div>
            <span class="block text-[9px] font-black text-gray-400 uppercase">Durasi</span>
            <span class="text-lg font-black text-gray-800">{{ $ujian->durasi }} Menit</span>
        </div>
    </div>
    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-center gap-4">
        <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center text-xl shrink-0"><i class="fas fa-list-ol"></i></div>
        <div>
            <span class="block text-[9px] font-black text-gray-400 uppercase">Jumlah Soal</span>
            <span class="text-lg font-black text-gray-800">{{ $ujian->soals->count() }} Butir</span>
        </div>
    </div>
    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-center gap-4">
        <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-xl shrink-0"><i class="fas fa-check-double"></i></div>
        <div>
            <span class="block text-[9px] font-black text-gray-400 uppercase">Tipe</span>
            <span class="text-lg font-black text-gray-800">Pilihan Ganda</span>
        </div>
    </div>
</div>

{{-- Lembar Peraturan --}}
<div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-8 md:p-10">
    <h4 class="text-sm font-black text-gray-800 uppercase tracking-[0.2em] mb-6 flex items-center gap-2">
        <i class="fas fa-exclamation-circle text-amber-500"></i> Peraturan Penting:
    </h4>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-10">
        <div class="flex items-start gap-3 p-4 bg-gray-50 rounded-2xl border border-gray-100">
            <i class="fas fa-sync-alt mt-1 text-blue-500"></i>
            <p class="text-xs text-gray-600 font-medium">Dilarang me-refresh halaman atau menekan tombol 'Back' saat ujian berlangsung bray.</p>
        </div>
        <div class="flex items-start gap-3 p-4 bg-gray-50 rounded-2xl border border-gray-100">
            <i class="fas fa-wifi mt-1 text-emerald-500"></i>
            <p class="text-xs text-gray-600 font-medium">Pastikan koneksi internet stabil hingga semua jawaban terkirim ke server.</p>
        </div>
    </div>

    {{-- Pesan Khusus Jika Ujian Di-resume Guru --}}
    @if($isMengerjakan)
        <div class="mb-6 p-4 bg-amber-50 border border-amber-200 rounded-2xl flex items-start gap-3">
            <i class="fas fa-info-circle text-amber-500 mt-1"></i>
            <p class="text-xs text-amber-800 font-bold leading-relaxed">Akses ujian Anda sedang aktif / telah dibuka kembali oleh Guru. Jawaban Anda sebelumnya telah tersimpan. Silakan lanjutkan bray.</p>
        </div>
    @endif

    {{-- Tombol Mulai --}}
    <a href="/siswa/ujian/{{ $ujian->id }}/kerjakan" 
       class="w-full text-white text-center font-black py-5 rounded-[1.5rem] transition shadow-xl text-sm uppercase tracking-[0.3em] active:scale-[0.98] flex items-center justify-center gap-3 
       {{ $isMengerjakan ? 'bg-amber-500 hover:bg-amber-600 shadow-amber-200' : 'bg-emerald-600 hover:bg-emerald-700 shadow-emerald-100' }}">
        {{ $isMengerjakan ? 'Lanjutkan Ujian' : 'Mulai Ujian Sekarang' }} 
        <i class="fas {{ $isMengerjakan ? 'fa-forward' : 'fa-play' }} text-xs"></i>
    </a>
    
    <a href="/siswa/dashboard" class="block text-center mt-6 text-[10px] font-black text-gray-400 uppercase tracking-widest hover:text-gray-800 transition">
        Batal, Kembali ke Dashboard
    </a>
</div>