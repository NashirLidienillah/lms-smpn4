@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gradient-to-r from-blue-50 to-white">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Transkrip Nilai Mandiri</h2>
                <p class="text-sm text-gray-500">Rangkuman capaian belajar di SMPN 4 Kota Serang</p>
            </div>
            <div class="text-right">
                <span class="block text-sm font-medium text-gray-400">Nama Siswa</span>
                <span class="font-bold text-blue-600">{{ Auth::user()->name }}</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-6 py-4 text-sm font-bold text-gray-600 uppercase tracking-wider border-b">Mata Pelajaran</th>
                        <th class="px-6 py-4 text-sm font-bold text-gray-600 uppercase tracking-wider border-b text-center">Rata-rata Tugas Esai</th>
                        <th class="px-6 py-4 text-sm font-bold text-gray-600 uppercase tracking-wider border-b text-center">Rata-rata Pilihan Ganda</th>
                        <th class="px-6 py-4 text-sm font-bold text-gray-600 uppercase tracking-wider border-b text-center">Nilai Akhir</th>
                        <th class="px-6 py-4 text-sm font-bold text-gray-600 uppercase tracking-wider border-b text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($transkrip as $data)
                    <tr class="hover:bg-blue-50/50 transition">
                        <td class="px-6 py-4">
                            <span class="font-bold text-gray-800 block">{{ $data['mapel'] }}</span>
                            <span class="text-xs text-gray-400">Guru: {{ $data['guru'] }}</span>
                        </td>
                        <td class="px-6 py-4 text-center font-semibold text-purple-600">
                            {{ $data['rata_tugas'] }}
                        </td>
                        <td class="px-6 py-4 text-center font-semibold text-emerald-600">
                            {{ $data['rata_ujian'] }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-lg font-bold {{ $data['total_akhir'] >= 75 ? 'text-blue-600' : 'text-red-500' }}">
                                {{ $data['total_akhir'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($data['total_akhir'] >= 75)
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold italic">Tuntas</span>
                            @else
                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold italic">Perlu Remedial</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-400 italic">Data nilai belum tersedia.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection