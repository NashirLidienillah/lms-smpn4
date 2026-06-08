@extends('layouts.app')

@section('content')
<div class="space-y-8 pb-12 print:space-y-6 print:pb-0 text-gray-800">
    
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
</div>

{{-- CSS WEB PRINTING CONFIGURATION --}}
<style>
    @media print {
        @page { 
            size: portrait; 
            margin: 1.5cm; 
        }
        body { 
            background-color: white !important; 
            color: black !important;
            -webkit-print-color-adjust: exact;
        }
        nav, aside, header, footer, .sidebar, button { 
            display: none !important; 
        }
        main, #app, .content, .container { 
            width: 100% !important; 
            max-width: none !important; 
            margin: 0 !important; 
            padding: 0 !important; 
        }
        table { border-collapse: collapse !important; width: 100% !important; }
        th, td { border: 1px solid black !important; padding: 10px !important; }
    }
</style>
@endsection