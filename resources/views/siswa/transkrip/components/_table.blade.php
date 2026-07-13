{{-- DETAILED SCORE TABLE --}}
<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden print:border-none print:shadow-none print:rounded-none">
    <div class="p-6 md:p-8 border-b border-gray-50 flex justify-between items-center print:hidden">
        <h3 class="text-base font-black text-gray-800 uppercase tracking-wider flex items-center gap-2">
            <i class="fas fa-list-ul text-blue-600"></i> Rincian Capaian Akademik
        </h3>
        <button onclick="window.print()" class="bg-blue-50 hover:bg-blue-100 text-blue-700 font-black px-4 py-2.5 rounded-xl text-xs uppercase tracking-widest transition-all flex items-center gap-2 shadow-sm">
            <i class="fas fa-print"></i> Cetak PDF
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left whitespace-nowrap print:border-collapse">
            <thead class="bg-slate-50 print:bg-transparent border-b border-gray-100 print:border-black">
                <tr>
                    <th class="px-8 py-4 text-[10px] font-black text-gray-400 print:text-black uppercase tracking-widest">Mata Pelajaran</th>
                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 print:text-black uppercase tracking-widest text-center">Rata-Rata Nilia Esai</th>
                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 print:text-black uppercase tracking-widest text-center">Rata-Rata Nilai Kuis & Ujian</th>
                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 print:text-black uppercase tracking-widest text-center">Nilai Akhir</th>
                    <th class="px-8 py-4 text-[10px] font-black text-gray-400 print:text-black uppercase tracking-widest text-right">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 print:divide-y-0">
                @forelse($transkrip as $data)
                <tr class="group hover:bg-slate-50/50 transition-colors print:border-b print:border-black">
                    <td class="px-8 py-5">
                        <div class="flex items-center gap-3.5">
                            <div class="w-9 h-9 rounded-xl bg-gray-100 text-gray-500 flex items-center justify-center text-xs font-black shrink-0 print:hidden group-hover:bg-blue-600 group-hover:text-white transition-all">
                                {{ substr($data['mapel'], 0, 1) }}
                            </div>
                            <div>
                                <span class="font-bold text-gray-800 print:text-black block text-sm">{{ $data['mapel'] }}</span>
                                <span class="text-[10px] font-semibold text-gray-400 print:text-black uppercase tracking-wider block mt-0.5">{{ $data['guru'] }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-5 text-center">
                        <span class="text-sm font-mono font-black text-purple-600 bg-purple-50 print:bg-transparent px-2.5 py-1 rounded-lg">
                            {{ round($data['rata_tugas']) }}
                        </span>
                    </td>
                    <td class="px-6 py-5 text-center">
                        <span class="text-sm font-mono font-black text-emerald-600 bg-emerald-50 print:bg-transparent px-2.5 py-1 rounded-lg">
                            {{ round($data['rata_ujian']) }}
                        </span>
                    </td>
                    <td class="px-6 py-5 text-center">
                        <span class="text-base font-mono font-black {{ $data['total_akhir'] >= 75 ? 'text-blue-600' : 'text-red-500' }}">
                            {{ round($data['total_akhir']) }}
                        </span>
                    </td>
                    <td class="px-8 py-5 text-right">
                        @if($data['total_akhir'] >= 75)
                            <div class="inline-flex items-center gap-1.5 bg-emerald-500 text-white px-3.5 py-1 rounded-full text-[9px] font-black uppercase tracking-widest shadow-md shadow-emerald-100 print:text-black print:bg-transparent print:p-0 print:shadow-none">
                                <i class="fas fa-check-circle print:hidden"></i> Tuntas
                            </div>
                        @else
                            <div class="inline-flex items-center gap-1.5 bg-red-500 text-white px-3.5 py-1 rounded-full text-[9px] font-black uppercase tracking-widest shadow-md shadow-red-100 print:text-black print:bg-transparent print:p-0 print:shadow-none">
                                <i class="fas fa-exclamation-triangle print:hidden"></i> Remedial
                            </div>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-8 py-16 text-center text-gray-400">
                        <div class="w-16 h-16 bg-gray-50 text-gray-200 rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl shadow-inner print:hidden"><i class="fas fa-chart-bar"></i></div>
                        Belum ada data nilai tersedia.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>