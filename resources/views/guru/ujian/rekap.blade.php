@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto pb-20">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Rekap Nilai CBT</h1>
            <p class="text-gray-500 text-sm">Ujian: <span class="font-bold">{{ $ujian->judul }}</span> | Total Soal: {{ $ujian->soals->count() }} Butir</p>
        </div>
        <a href="/guru/ujian/{{ $ujian->id }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-bold transition">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-emerald-50 border-b border-emerald-100">
                <tr>
                    <th class="px-6 py-4 text-xs font-bold text-emerald-800 uppercase tracking-wider">Nama Siswa</th>
                    <th class="px-6 py-4 text-xs font-bold text-emerald-800 uppercase tracking-wider text-center">Jawaban Benar</th>
                    <th class="px-6 py-4 text-xs font-bold text-emerald-800 uppercase tracking-wider text-center">Jawaban Salah</th>
                    <th class="px-6 py-4 text-xs font-bold text-emerald-800 uppercase tracking-wider text-center">Skor Akhir</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($rekap as $userId => $jawaban)
                    @php
                        $totalSoal = $ujian->soals->count();
                        $benar = $jawaban->where('is_benar', true)->count();
                        $salah = $totalSoal - $benar;
                        $skor = ($totalSoal > 0) ? round(($benar / $totalSoal) * 100, 2) : 0;
                    @endphp
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 font-medium text-gray-900">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold mr-3">
                                    {{ substr($jawaban->first()->user->name, 0, 1) }}
                                </div>
                                {{ $jawaban->first()->user->name }}
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center text-emerald-600 font-bold">{{ $benar }}</td>
                        <td class="px-6 py-4 text-center text-red-500 font-bold">{{ $salah }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-4 py-1.5 {{ $skor >= 70 ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }} rounded-full font-black">
                                {{ $skor }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-gray-400 italic">
                            <i class="fas fa-inbox text-4xl mb-3 block text-gray-300"></i>
                            Belum ada siswa yang mengerjakan ujian ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection