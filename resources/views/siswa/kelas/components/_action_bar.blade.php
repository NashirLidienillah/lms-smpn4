{{-- Action Bar & Notifikasi Lonceng Pintar --}}
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <a href="/siswa/dashboard" class="group inline-flex items-center text-sm font-bold text-gray-400 hover:text-blue-600 transition">
        <div class="w-8 h-8 rounded-lg bg-gray-100 group-hover:bg-blue-50 flex items-center justify-center mr-3 transition">
            <i class="fas fa-arrow-left text-xs"></i>
        </div>
        Kembali ke Beranda Siswa
    </a>

    @if($pengumumans->count() > 0)
        <div x-data="{
            totalPengumuman: {{ $pengumumans->count() }},
            dibaca: parseInt(localStorage.getItem('pengumuman_kelas_{{ $jadwal->kelas_id }}')) || 0,
            bukaNotif() {
                this.dibaca = this.totalPengumuman;
                localStorage.setItem('pengumuman_kelas_{{ $jadwal->kelas_id }}', this.totalPengumuman);
                bukaModalPengumuman();
            }
        }">
            <button @click="bukaNotif()" class="relative bg-white border border-amber-200 text-amber-600 hover:bg-amber-50 hover:text-amber-700 text-sm font-bold px-5 py-2.5 rounded-xl shadow-sm transition-all duration-300 flex items-center gap-2 group w-full sm:w-auto justify-center">
                <i class="fas fa-bell" :class="totalPengumuman > dibaca ? 'animate-bounce' : ''"></i> 
                Lihat Pengumuman Kelas
                
                <span x-show="totalPengumuman > dibaca" style="display: none;" class="absolute -top-2 -right-2 flex h-6 w-6">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-6 w-6 bg-red-500 text-white text-[10px] font-black items-center justify-center shadow-md" x-text="totalPengumuman - dibaca"></span>
                </span>
            </button>
        </div>
    @endif
</div>