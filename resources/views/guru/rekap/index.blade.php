@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto pb-24">
    
    {{-- Toast Notifikasi Sukses Buka Akses --}}
    @if(session('success'))
        <div id="toast-success" class="fixed top-5 right-5 flex items-center w-full max-w-xs p-4 mb-4 text-gray-700 bg-white rounded-2xl shadow-xl border-l-4 border-emerald-500 z-50 transition-all duration-500">
            <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-emerald-500 bg-emerald-100 rounded-lg"><i class="fas fa-check"></i></div>
            <div class="ml-3 text-sm font-medium">{{ session('success') }}</div>
            <button type="button" class="ml-auto bg-white text-gray-400 hover:text-gray-900 rounded-lg p-1.5 hover:bg-gray-100 h-8 w-8 transition" onclick="document.getElementById('toast-success').remove()"><i class="fas fa-times"></i></button>
        </div>
        <script>setTimeout(() => { document.getElementById('toast-success')?.remove(); }, 3500);</script>
    @endif

    {{-- Header Actions (Hidden on Print) --}}
    <div class="print:hidden mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <a href="/guru/kelas/{{ $jadwal->id }}" class="group inline-flex items-center text-sm font-bold text-gray-400 hover:text-indigo-600 transition">
            <div class="w-8 h-8 rounded-lg bg-white border border-gray-100 group-hover:bg-indigo-50 flex items-center justify-center mr-3 transition shadow-sm">
                <i class="fas fa-arrow-left text-xs"></i>
            </div>
            Kembali ke Ruang Kelas
        </a>
        <button onclick="window.print()" class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-black px-5 py-3 rounded-xl shadow-lg shadow-indigo-100 transition-all uppercase tracking-widest text-xs flex items-center justify-center gap-2 active:scale-95">
            <i class="fas fa-print text-sm"></i> Cetak Catatan Nilai
        </button>
    </div>

    {{-- Title Section --}}
    <div class="mb-6 print:hidden">
        <h1 class="text-3xl font-black text-gray-800 tracking-tight">Rekap Nilai Siswa</h1>
        <p class="text-gray-500 text-sm mt-1">Kumpulan riwayat hasil nilai tugas esai, Kuis dan Ujian siswa.</p>
    </div>

    {{-- AREA KERTAS CETAK (Print-Optimized + Bento Info Header) --}}
    <div class="bg-white print:bg-transparent rounded-3xl print:rounded-none p-6 md:p-8 print:p-0 shadow-sm print:shadow-none border border-gray-100 print:border-none mb-6 text-gray-800">

        {{-- JUDUL SIMPLE (Hanya Muncul Saat di Print) --}}
        <div class="hidden print:block border-b-2 border-black pb-2 mb-4">
            <h2 class="text-2xl font-bold uppercase text-black">Catatan Nilai Kelas</h2>
        </div>

        {{-- INFORMASI KELAS & GURU (Bento Grid View on Screen, Clean Table on Print) --}}
        <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-end gap-4 print:mb-4">
            {{-- Screen Mode: Bento Grid Info --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 w-full print:hidden">
                <div class="bg-slate-50 border border-slate-100 p-4 rounded-2xl flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shadow-inner font-bold"><i class="fas fa-book"></i></div>
                    <div class="min-w-0 flex-1">
                        <span class="block text-[9px] text-gray-400 font-black uppercase tracking-wider">Mata Pelajaran</span>
                        <div class="text-sm font-black text-gray-800 truncate">{{ $jadwal->mapel->nama_mapel }}</div>
                    </div>
                </div>
                <div class="bg-slate-50 border border-slate-100 p-4 rounded-2xl flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shadow-inner font-bold"><i class="fas fa-door-open"></i></div>
                    <div class="min-w-0 flex-1">
                        <span class="block text-[9px] text-gray-400 font-black uppercase tracking-wider">Kelas Belajar</span>
                        <div class="text-sm font-black text-gray-800 truncate">Kelas {{ $jadwal->kelas->nama_kelas }}</div>
                    </div>
                </div>
                <div class="bg-slate-50 border border-slate-100 p-4 rounded-2xl flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shadow-inner font-bold"><i class="fas fa-user-tie"></i></div>
                    <div class="min-w-0 flex-1">
                        <span class="block text-[9px] text-gray-400 font-black uppercase tracking-wider">Guru Pengajar  </span>
                        <div class="text-sm font-black text-gray-800 truncate">{{ Auth::user()->name }}</div>
                    </div>
                </div>
            </div>

            {{-- Print Mode: Clean Text Table --}}
            <div class="hidden print:block">
                <table class="text-sm font-semibold text-black">
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
        <div class="overflow-x-auto rounded-2xl border border-gray-100 print:border-none shadow-inner print:shadow-none">
            <table class="min-w-full text-left text-sm whitespace-nowrap print:border-collapse">
                <thead class="bg-slate-50 print:bg-transparent border-b border-gray-200 print:border-black">
                    <tr>
                        <th scope="col" class="px-5 py-4 border-r border-gray-100 print:border-black w-12 text-center text-[10px] font-black text-gray-400 print:text-black uppercase tracking-widest">No</th>
                        <th scope="col" class="px-6 py-4 border-r border-gray-100 print:border-black text-[10px] font-black text-gray-400 print:text-black uppercase tracking-widest">Nama Lengkap Siswa</th>
                        
                        {{-- Loop Header Tugas Esai --}}
                        @foreach($listTugas as $tugas)
                            <th scope="col" class="px-4 py-4 border-r border-gray-100 print:border-black text-center bg-purple-50/50 print:bg-transparent text-purple-700 print:text-black" title="{{ $tugas->judul }}">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-file-alt mb-1 text-sm print:hidden opacity-70"></i>
                                    <span class="text-[10px] font-black uppercase tracking-wider truncate w-24 inline-block">{{ $tugas->judul }}</span>
                                </div>
                            </th>
                        @endforeach

                        {{-- Loop Header Ujian CBT --}}
                        @foreach($listUjian as $ujian)
                            <th scope="col" class="px-4 py-4 border-r border-gray-100 print:border-black text-center bg-emerald-50/50 print:bg-transparent text-emerald-700 print:text-black" title="{{ $ujian->judul }}">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-laptop-code mb-1 text-sm print:hidden opacity-70"></i>
                                    <span class="text-[10px] font-black uppercase tracking-wider truncate w-24 inline-block">{{ $ujian->judul }}</span>
                                </div>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 print:divide-y-0">
                    @forelse($rekapSiswa as $index => $row)
                        <tr class="hover:bg-blue-50/40 transition-colors group print:hover:bg-transparent">
                            <td class="px-5 py-4 border-r border-gray-100 print:border-black text-center font-medium text-gray-400 print:text-black">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 border-r border-gray-100 print:border-black">
                                <div class="flex items-center gap-3">
                                    {{-- Avatar Inisial --}}
                                    <div class="w-8 h-8 rounded-lg bg-gray-100 text-gray-500 font-bold text-xs uppercase flex items-center justify-center shrink-0 print:hidden group-hover:bg-indigo-600 group-hover:text-white transition-all">
                                        {{ substr($row['nama'], 0, 1) }}
                                    </div>
                                    {{-- Nama Siswa (Sisa NIS yang strip sudah dihapus) --}}
                                    <div class="font-bold text-gray-800 print:text-black text-sm">
                                        {{ $row['nama'] }}
                                    </div>
                                </div>
                            </td>

                            {{-- Loop Nilai Tugas Siswa Ini --}}
                            @foreach($listTugas as $tugas)
                                @php $nilaiT = $row['nilai_tugas'][$tugas->id]; @endphp
                                <td class="px-4 py-4 border-r border-gray-100 print:border-black text-center font-mono font-black text-sm print:text-black {{ $nilaiT === '-' ? 'text-gray-300' : ($nilaiT < 70 ? 'text-red-500' : 'text-purple-600') }}">
                                    <span class="{{ $nilaiT !== '-' && $nilaiT >= 70 ? 'bg-purple-50 print:bg-transparent px-2 py-1 rounded' : '' }}">{{ $nilaiT }}</span>
                                </td>
                            @endforeach

                            {{-- Loop Nilai Ujian Siswa Ini --}}
                            @foreach($listUjian as $ujian)
                                @php $nilaiU = $row['nilai_ujian'][$ujian->id]; @endphp
                                <td class="px-4 py-4 border-r border-gray-100 print:border-black text-center font-mono font-black text-sm print:text-black {{ $nilaiU === '-' ? 'text-gray-300' : ($nilaiU < 70 ? 'text-red-500' : 'text-emerald-600') }}">
                                    <span class="{{ $nilaiU !== '-' && $nilaiU >= 70 ? 'bg-emerald-50 print:bg-transparent px-2 py-1 rounded' : '' }}">{{ $nilaiU }}</span>
                                </td>
                            @endforeach
                        </tr>
                    @empty
                        <tr>
                            <td colspan="100" class="px-6 py-16 text-center text-gray-400 print:text-black font-bold border-none border-b print:border-black">
                                <div class="w-16 h-16 bg-gray-50 text-gray-200 rounded-2xl flex items-center justify-center mx-auto mb-4 text-3xl shadow-inner print:hidden"><i class="fas fa-users-slash"></i></div>
                                Belum ada siswa yang terdaftar di kelas ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
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