{{-- Bagian Kiri: Detail & Instruksi Tugas --}}
<div class="lg:col-span-2 space-y-6">
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 md:p-10 border-b border-gray-50">
            <div class="flex items-center gap-2 mb-4">
                <span class="bg-purple-50 text-purple-600 text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-widest border border-purple-100">Lembar Tugas Esai</span>
            </div>
            
            <h1 class="text-3xl md:text-4xl font-black text-gray-800 tracking-tight mb-6">{{ $tugas->judul }}</h1>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="flex items-center gap-4 bg-slate-50 p-4 rounded-2xl border border-slate-100">
                    <div class="w-10 h-10 rounded-xl bg-white shadow-sm flex items-center justify-center text-blue-500">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div>
                        <span class="block text-[9px] text-gray-400 font-black uppercase tracking-wider">Guru Pengampu</span>
                        <span class="text-sm font-bold text-gray-700">{{ $tugas->guruMapel->user->name ?? 'Guru Mapel' }}</span>
                    </div>
                </div>
                <div class="flex items-center gap-4 bg-red-50 p-4 rounded-2xl border border-red-100">
                    <div class="w-10 h-10 rounded-xl bg-white shadow-sm flex items-center justify-center text-red-500">
                        <i class="fas fa-hourglass-end"></i>
                    </div>
                    <div>
                        <span class="block text-[9px] text-red-400 font-black uppercase tracking-wider">Batas Pengumpulan</span>
                        <span class="text-sm font-bold text-red-600">{{ \Carbon\Carbon::parse($tugas->batas_waktu)->format('d M, H:i') }} WIB</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-6 md:p-10">
            <h4 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-4">Instruksi Pengerjaan</h4>
            <div class="prose max-w-none text-gray-600 leading-relaxed font-medium">
                {!! nl2br(e($tugas->deskripsi)) !!}
            </div>

            @if($tugas->file_tugas)
            <div class="mt-10 p-6 bg-blue-50 rounded-2xl border border-blue-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-white rounded-xl shadow-sm flex items-center justify-center text-blue-600 text-xl">
                        <i class="fas fa-file-invoice"></i>
                    </div>
                    <div>
                        <h5 class="font-bold text-blue-900 text-sm">Lampiran Soal dari Guru</h5>
                        <p class="text-xs text-blue-600 opacity-70">Silakan download untuk melihat detail soal.</p>
                    </div>
                </div>
                <a href="{{ asset('storage/tugas/' . $tugas->file_tugas) }}" target="_blank" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition shadow-lg shadow-blue-100 flex items-center justify-center gap-2">
                    <i class="fas fa-download"></i> Download File
                </a>
            </div>
            @endif
        </div>
    </div>
</div>