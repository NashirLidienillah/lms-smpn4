@extends('layouts.app')

@section('content')
<div class="space-y-8 pb-10">
    
    <div class="bg-gradient-to-br from-indigo-600 to-blue-700 rounded-[2.5rem] p-8 md:p-12 text-white shadow-xl relative overflow-hidden">
        <div class="absolute right-0 top-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-20 -mt-20"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="text-center md:text-left">
                <div class="flex items-center justify-center md:justify-start gap-2 mb-3">
                    <span class="bg-white/20 backdrop-blur-md text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-[0.2em] border border-white/30">Akademik</span>
                    <span class="text-blue-200 opacity-50">•</span>
                    <span class="text-sm font-bold text-blue-100">SMPN 4 Kota Serang</span>
                </div>
                <h1 class="text-3xl md:text-5xl font-black tracking-tight mb-2">Transkrip Nilai</h1>
                <p class="text-blue-100 text-sm md:text-base font-medium opacity-80">Rangkuman hasil belajar mandiri Anda selama satu semester.</p>
            </div>
            
            <div class="bg-white/10 backdrop-blur-md p-6 rounded-3xl border border-white/20 text-center min-w-[200px]">
                <span class="block text-[10px] font-black uppercase tracking-widest opacity-70 mb-1">Nama Siswa</span>
                <span class="text-xl font-black">{{ Auth::user()->name }}</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100 flex items-center gap-5 group hover:shadow-md transition-all">
            <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                <i class="fas fa-chart-line"></i>
            </div>
            <div>
                <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Total Mapel</span>
                <span class="text-2xl font-black text-gray-800">{{ count($transkrip) }}</span>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100 flex items-center gap-5 group hover:shadow-md transition-all">
            <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
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

        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100 flex items-center gap-5 group hover:shadow-md transition-all">
            <div class="w-14 h-14 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                <i class="fas fa-star"></i>
            </div>
            <div>
                <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Rata-rata IP</span>
                @php
                    $avg = count($transkrip) > 0 ? collect($transkrip)->avg('total_akhir') : 0;
                @endphp
                <span class="text-2xl font-black text-purple-600">{{ number_format($avg, 1) }}</span>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-8 border-b border-gray-50 flex justify-between items-center">
            <h3 class="text-lg font-black text-gray-800 uppercase tracking-tighter">Rincian Capaian</h3>
            <button onclick="window.print()" class="text-[10px] font-black text-blue-600 uppercase tracking-widest hover:underline">
                <i class="fas fa-print mr-1"></i> Cetak PDF
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Mata Pelajaran</th>
                        <th class="px-6 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] text-center">Avg Esai</th>
                        <th class="px-6 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] text-center">Avg CBT</th>
                        <th class="px-6 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] text-center">Nilai Akhir</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($transkrip as $data)
                    <tr class="group hover:bg-slate-50 transition-all duration-300">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-500 flex items-center justify-center text-xs font-black group-hover:bg-blue-600 group-hover:text-white transition-all">
                                    {{ substr($data['mapel'], 0, 1) }}
                                </div>
                                <div>
                                    <span class="font-black text-gray-800 block text-base">{{ $data['mapel'] }}</span>
                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $data['guru'] }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-sm font-black text-purple-500 bg-purple-50 px-3 py-1.5 rounded-lg border border-purple-100">
                                {{ round($data['rata_tugas']) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-sm font-black text-emerald-500 bg-emerald-50 px-3 py-1.5 rounded-lg border border-emerald-100">
                                {{ round($data['rata_ujian']) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-xl font-black {{ $data['total_akhir'] >= 75 ? 'text-blue-600' : 'text-red-500' }}">
                                {{ round($data['total_akhir']) }}
                            </span>
                        </td>
                        <td class="px-8 py-4 text-right">
                            @if($data['total_akhir'] >= 75)
                                <div class="inline-flex items-center gap-2 bg-emerald-500 text-white px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest shadow-lg shadow-emerald-100">
                                    <i class="fas fa-check-circle"></i> Tuntas
                                </div>
                            @else
                                <div class="inline-flex items-center gap-2 bg-red-500 text-white px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest shadow-lg shadow-red-100">
                                    <i class="fas fa-exclamation-triangle"></i> Remedial
                                </div>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center">
                            <div class="w-16 h-16 bg-gray-50 text-gray-200 rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl shadow-inner">
                                <i class="fas fa-chart-bar"></i>
                            </div>
                            <h4 class="font-bold text-gray-400">Belum ada data nilai tersedia.</h4>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection