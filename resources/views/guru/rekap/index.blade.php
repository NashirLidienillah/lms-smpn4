@extends('layouts.app')

@section('content')

{{-- Bagian yang hanya muncul di layar, disembunyikan saat print --}}
<div class="print:hidden mb-4 flex justify-between items-center">
    <a href="/guru/kelas/{{ $jadwal->id }}" class="inline-flex items-center text-sm text-gray-500 hover:text-blue-600 transition font-medium">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Ruang Kelas
    </a>
    <button onclick="window.print()" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg shadow-sm transition flex items-center">
        <i class="fas fa-print mr-2"></i> Cetak Catatan Nilai
    </button>
</div>

{{-- AREA KERTAS CETAK (Print-Optimized) --}}
<div class="bg-white print:bg-transparent rounded-2xl print:rounded-none p-6 print:p-0 shadow-sm print:shadow-none border border-gray-200 print:border-none mb-6 text-gray-800">

    {{-- JUDUL SIMPLE (Hanya Muncul Saat di Print) --}}
    <div class="hidden print:block border-b-2 border-black pb-2 mb-4">
        <h2 class="text-2xl font-bold uppercase text-black">Catatan Nilai Kelas</h2>
    </div>

    {{-- INFORMASI KELAS & GURU --}}
    <div class="mb-6 flex justify-between items-end print:mb-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 print:hidden mb-2">Buku Nilai Kelas</h2>
            <table class="text-sm font-semibold text-gray-700 print:text-black">
                <tr><td class="pr-6 py-1">Mata Pelajaran</td><td>: {{ $jadwal->mapel->nama_mapel }}</td></tr>
                <tr><td class="pr-6 py-1">Kelas</td><td>: {{ $jadwal->kelas->nama_kelas }}</td></tr>
                <tr><td class="pr-6 py-1">Guru Pengampu</td><td>: {{ Auth::user()->name }}</td></tr>
            </table>
        </div>
        {{-- Tanggal cetak untuk referensi guru --}}
        <div class="hidden print:block text-sm text-gray-600 font-medium">
            Dicetak pada: {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
        </div>
    </div>

    {{-- TABEL NILAI --}}
    <div class="overflow-x-auto">
        <table class="min-w-full text-left text-sm whitespace-nowrap print:border-collapse">
            <thead class="border-b-2 border-gray-200 print:border-black bg-gray-50 print:bg-transparent">
                <tr>
                    <th scope="col" class="px-4 py-3 border-r border-gray-200 print:border-black w-10 text-center font-bold print:text-black">No</th>
                    <th scope="col" class="px-4 py-3 border-r border-gray-200 print:border-black font-bold print:text-black">Nama Siswa</th>
                    
                    {{-- Loop Header Tugas Esai --}}
                    @foreach($listTugas as $tugas)
                        <th scope="col" class="px-4 py-3 border-r border-gray-200 print:border-black text-center bg-purple-50 print:bg-transparent text-purple-700 print:text-black" title="{{ $tugas->judul }}">
                            <i class="fas fa-file-alt mb-1 block text-lg print:hidden"></i>
                            <span class="text-xs font-bold truncate w-20 inline-block">{{ $tugas->judul }}</span>
                        </th>
                    @endforeach

                    {{-- Loop Header Ujian CBT --}}
                    @foreach($listUjian as $ujian)
                        <th scope="col" class="px-4 py-3 border-r border-gray-200 print:border-black text-center bg-emerald-50 print:bg-transparent text-emerald-700 print:text-black" title="{{ $ujian->judul }}">
                            <i class="fas fa-laptop-code mb-1 block text-lg print:hidden"></i>
                            <span class="text-xs font-bold truncate w-20 inline-block">{{ $ujian->judul }}</span>
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @forelse($rekapSiswa as $index => $row)
                    <tr class="border-b border-gray-100 print:border-black hover:bg-blue-50 transition print:hover:bg-transparent">
                        <td class="px-4 py-3 border-r border-gray-100 print:border-black text-center text-gray-500 print:text-black">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3 border-r border-gray-100 print:border-black font-bold text-gray-800 print:text-black">
                            {{ $row['nama'] }}
                            <span class="block text-xs font-normal text-gray-400 print:text-gray-800">{{ $row['nis'] }}</span>
                        </td>

                        {{-- Loop Nilai Tugas Siswa Ini --}}
                        @foreach($listTugas as $tugas)
                            @php $nilaiT = $row['nilai_tugas'][$tugas->id]; @endphp
                            <td class="px-4 py-3 border-r border-gray-100 print:border-black text-center font-bold print:text-black {{ $nilaiT === '-' ? 'text-gray-300' : ($nilaiT < 70 ? 'text-red-500' : 'text-purple-600') }}">
                                {{ $nilaiT }}
                            </td>
                        @endforeach

                        {{-- Loop Nilai Ujian Siswa Ini --}}
                        @foreach($listUjian as $ujian)
                            @php $nilaiU = $row['nilai_ujian'][$ujian->id]; @endphp
                            <td class="px-4 py-3 border-r border-gray-100 print:border-black text-center font-bold print:text-black {{ $nilaiU === '-' ? 'text-gray-300' : ($nilaiU < 70 ? 'text-red-500' : 'text-emerald-600') }}">
                                {{ $nilaiU }}
                            </td>
                        @endforeach
                    </tr>
                @empty
                    <tr>
                        <td colspan="100" class="px-6 py-10 text-center text-gray-500 print:text-black font-medium border print:border-black">
                            Belum ada siswa yang terdaftar di kelas ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

{{-- CSS KHUSUS UNTUK MEMPERBAIKI TAMPILAN KERTAS --}}
<style>
    @media print {
        @page { 
            size: landscape; 
            margin: 1.5cm; 
        }
        body { 
            background-color: white !important; 
            color: black !important;
            -webkit-print-color-adjust: exact;
        }
        nav, aside, header, footer, .sidebar { 
            display: none !important; 
        }
        main, #app, .content, .container, .max-w-7xl { 
            width: 100% !important; 
            max-width: none !important; 
            margin: 0 !important; 
            padding: 0 !important; 
        }
        table { border-collapse: collapse !important; width: 100% !important; }
        th, td { border: 1px solid black !important; }
    }
</style>

@endsection