{{-- DETAILED SCORE TABLE WITH ACCORDION --}}
<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden print:border-none print:shadow-none print:rounded-none" x-data="{ openRow: null }">
    <div class="p-6 md:p-8 border-b border-gray-50 flex justify-between items-center print:hidden">
        <div>
            <h3 class="text-base font-black text-gray-800 uppercase tracking-wider flex items-center gap-2">
                <i class="fas fa-list-ul text-blue-600"></i> Rincian Capaian Akademik
            </h3>
            <p class="text-xs text-gray-400 font-medium mt-1">Klik pada baris mata pelajaran untuk melihat rincian tiap tugas & kuis.</p>
        </div>
        <button onclick="window.print()" class="bg-blue-50 hover:bg-blue-100 text-blue-700 font-black px-4 py-2.5 rounded-xl text-xs uppercase tracking-widest transition-all flex items-center gap-2 shadow-sm">
            <i class="fas fa-print"></i> Cetak PDF
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left whitespace-nowrap print:whitespace-normal">
            <thead class="bg-slate-50 print:bg-gray-100 border-b border-gray-100 print:border-black">
                <tr>
                    <th class="px-8 py-4 print:px-3 print:py-2 text-[10px] font-black text-gray-400 print:text-black uppercase tracking-widest print:border print:border-black">Mata Pelajaran</th>
                    <th class="px-6 py-4 print:px-3 print:py-2 text-[10px] font-black text-gray-400 print:text-black uppercase tracking-widest text-center print:border print:border-black">Rata Tugas</th>
                    <th class="px-6 py-4 print:px-3 print:py-2 text-[10px] font-black text-gray-400 print:text-black uppercase tracking-widest text-center print:border print:border-black">Rata Ujian</th>
                    <th class="px-6 py-4 print:px-3 print:py-2 text-[10px] font-black text-gray-400 print:text-black uppercase tracking-widest text-center print:border print:border-black">Nilai Akhir</th>
                    <th class="px-8 py-4 print:px-3 print:py-2 text-[10px] font-black text-gray-400 print:text-black uppercase tracking-widest text-right print:text-center print:border print:border-black">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 print:divide-y-0">
                @forelse($transkrip as $index => $data)
                {{-- BARIS UTAMA --}}
                <tr @click="openRow = (openRow === {{ $index }} ? null : {{ $index }})" 
                    class="group hover:bg-slate-50/70 transition-colors cursor-pointer print:bg-gray-50 print:border print:border-black"
                    :class="{ 'bg-blue-50/30': openRow === {{ $index }} }">
                    <td class="px-8 py-5 print:px-3 print:py-2 print:border print:border-black">
                        <div class="flex items-center gap-3.5">
                            <div class="w-9 h-9 rounded-xl bg-gray-100 text-gray-500 flex items-center justify-center text-xs font-black shrink-0 print:hidden group-hover:bg-blue-600 group-hover:text-white transition-all">
                                {{ substr($data['mapel'], 0, 1) }}
                            </div>
                            <div>
                                <span class="font-bold text-gray-800 print:text-black block text-sm print:text-xs">{{ $data['mapel'] }}</span>
                                <span class="text-[10px] font-semibold text-gray-400 print:text-gray-700 uppercase tracking-wider block mt-0.5">Pengampu: {{ $data['guru'] }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-5 print:px-3 print:py-2 text-center print:border print:border-black">
                        <span class="text-sm print:text-xs font-mono font-black text-blue-600 bg-blue-50 print:bg-transparent print:text-black px-2.5 py-1 rounded-lg">
                            {{ round($data['rata_tugas']) }}
                        </span>
                    </td>
                    <td class="px-6 py-5 print:px-3 print:py-2 text-center print:border print:border-black">
                        <span class="text-sm print:text-xs font-mono font-black text-emerald-600 bg-emerald-50 print:bg-transparent print:text-black px-2.5 py-1 rounded-lg">
                            {{ round($data['rata_ujian']) }}
                        </span>
                    </td>
                    <td class="px-6 py-5 print:px-3 print:py-2 text-center print:border print:border-black">
                        <span class="text-base print:text-xs font-mono font-black {{ $data['total_akhir'] >= 75 ? 'text-blue-600' : 'text-red-500' }} print:text-black">
                            {{ round($data['total_akhir']) }}
                        </span>
                    </td>
                    <td class="px-8 py-5 print:px-3 print:py-2 text-right print:text-center print:border print:border-black">
                        <div class="flex items-center justify-end print:justify-center gap-3">
                            @if($data['total_akhir'] >= 75)
                                <div class="inline-flex items-center gap-1.5 bg-emerald-500 text-white px-3.5 py-1 rounded-full text-[9px] font-black uppercase tracking-widest shadow-md shadow-emerald-100 print:text-black print:bg-transparent print:p-0 print:shadow-none print:font-bold">
                                    <i class="fas fa-check-circle print:hidden"></i> TUNTAS
                                </div>
                            @else
                                <div class="inline-flex items-center gap-1.5 bg-red-500 text-white px-3.5 py-1 rounded-full text-[9px] font-black uppercase tracking-widest shadow-md shadow-red-100 print:text-black print:bg-transparent print:p-0 print:shadow-none print:font-bold">
                                    <i class="fas fa-exclamation-triangle print:hidden"></i> REMEDIAL
                                </div>
                            @endif

                            {{-- Tombol Toggle Arrow --}}
                            <span class="w-7 h-7 rounded-lg bg-gray-100 text-gray-400 flex items-center justify-center text-xs transition-transform duration-300 print:hidden"
                                  :class="{ 'rotate-180 bg-blue-600 text-white': openRow === {{ $index }} }">
                                <i class="fas fa-chevron-down"></i>
                            </span>
                        </div>
                    </td>
                </tr>

                {{-- BARIS DETAIL (ACCORDION EXTENSION - OTOMATIS TERBUKA SAAT PRINT) --}}
                <tr x-show="openRow === {{ $index }}" x-collapse transition class="bg-slate-50/50 print:!table-row print-detail-show print:border-b print:border-l print:border-r print:border-black">
                    <td colspan="5" class="px-8 py-6 print:px-3 print:py-3">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 print:gap-4 bg-white p-6 print:p-0 rounded-2xl border border-gray-100 shadow-sm print:border-none print:shadow-none">
                            
                            {{-- DETAIL NILAI TUGAS --}}
                            <div>
                                <h4 class="text-xs font-black text-gray-700 uppercase tracking-wider mb-3 flex items-center gap-2 print:text-black print:font-bold">
                                    <i class="fas fa-tasks text-blue-500 print:hidden"></i> Rincian Tugas ({{ count($data['detail_tugas']) }})
                                </h4>
                                <div class="space-y-2">
                                    @forelse($data['detail_tugas'] as $tugas)
                                        <div class="flex justify-between items-center p-3 print:p-1.5 bg-gray-50 print:bg-transparent rounded-xl text-xs border border-gray-100 print:border-b print:border-gray-300 print:rounded-none">
                                            <div>
                                                <div class="font-bold text-gray-800 print:text-black">{{ $tugas->judul }}</div>
                                                <div class="text-[10px] text-gray-400 print:text-gray-600 mt-0.5">
                                                    Dikumpul: {{ \Carbon\Carbon::parse($tugas->created_at)->format('d M Y, H:i') }}
                                                </div>
                                            </div>
                                            <span class="font-mono font-black text-blue-600 print:text-black text-sm print:text-xs bg-blue-50 print:bg-transparent px-2.5 py-1">
                                                Nilai: {{ round($tugas->nilai) }}
                                            </span>
                                        </div>
                                    @empty
                                        <div class="text-xs text-gray-400 italic p-3 text-center bg-gray-50 print:bg-transparent rounded-xl">Belum ada tugas yang dikumpulkan/dinilai.</div>
                                    @endforelse
                                </div>
                            </div>

                            {{-- DETAIL NILAI KUIS & UJIAN --}}
                            <div>
                                <h4 class="text-xs font-black text-gray-700 uppercase tracking-wider mb-3 flex items-center gap-2 print:text-black print:font-bold">
                                    <i class="fas fa-laptop-code text-emerald-500 print:hidden"></i> Rincian Kuis & Ujian ({{ count($data['detail_ujian']) }})
                                </h4>
                                <div class="space-y-2">
                                    @forelse($data['detail_ujian'] as $ujian)
                                        <div class="flex justify-between items-center p-3 print:p-1.5 bg-gray-50 print:bg-transparent rounded-xl text-xs border border-gray-100 print:border-b print:border-gray-300 print:rounded-none">
                                            <div>
                                                <div class="font-bold text-gray-800 print:text-black">{{ $ujian->judul }}</div>
                                                <div class="text-[10px] text-gray-400 print:text-gray-600 mt-0.5">
                                                    Selesai: {{ \Carbon\Carbon::parse($ujian->updated_at)->format('d M Y, H:i') }}
                                                </div>
                                            </div>
                                            <span class="font-mono font-black text-emerald-600 print:text-black text-sm print:text-xs bg-emerald-50 print:bg-transparent px-2.5 py-1">
                                                Nilai: {{ round($ujian->nilai) }}
                                            </span>
                                        </div>
                                    @empty
                                        <div class="text-xs text-gray-400 italic p-3 text-center bg-gray-50 print:bg-transparent rounded-xl">Belum ada kuis/ujian yang dikerjakan.</div>
                                    @endforelse
                                </div>
                            </div>

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-8 py-16 text-center text-gray-400">
                        Belum ada data nilai tersedia.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>