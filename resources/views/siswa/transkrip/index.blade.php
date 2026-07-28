@extends('layouts.app')

@section('content')
<div class="space-y-8 pb-12 print:space-y-4 print:pb-0 text-gray-800">
    
    {{-- Header Web Normal (Hilang saat Print) --}}
    <div class="print:hidden">
        @include('siswa.transkrip.components._header')
    </div>

    {{-- FILTER TAHUN AKADEMIK / SEMESTER (MUNCUL DI TAMPILAN WEB) --}}
    <div class="print:hidden bg-white p-5 rounded-3xl border border-gray-100 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-sm shrink-0">
                <i class="fas fa-filter"></i>
            </div>
            <div>
                <h4 class="text-xs font-black text-gray-800 uppercase tracking-wider">Filter Periode Semester</h4>
                <p class="text-[11px] text-gray-400 font-medium">Pilih semester untuk melihat riwayat nilai akademik kamu.</p>
            </div>
        </div>

        <form method="GET" action="{{ route('siswa.transkrip') }}" class="flex items-center gap-2">
            <select name="tahun_akademik_id" onchange="this.form.submit()" class="bg-gray-50 hover:bg-gray-100 border border-gray-200 text-gray-800 text-xs font-bold rounded-2xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all outline-none cursor-pointer">
                <option value="all" {{ $tahunAkademikId == 'all' ? 'selected' : '' }}>
                    📚 Semua History Semester
                </option>
                @foreach($daftarTahunAkademik as $ta)
                    <option value="{{ $ta->id }}" {{ $tahunAkademikId == $ta->id ? 'selected' : '' }}>
                        Tahun {{ $ta->nama_tahun }} - Semester {{ $ta->semester }} {{ $ta->status_aktif ? '⭐ (Aktif)' : '' }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>

    {{-- HEADER DOKUMEN TRANSKRIP MODERN (MUNCUL SAAT CETAK/PDF) --}}
    <div class="hidden print:block border-b-2 border-gray-800 pb-4 mb-4">
        <div class="flex justify-between items-end">
            <div>
                <h1 class="text-xl font-black text-gray-900 uppercase tracking-wide">Transkrip Capaian Nilai</h1>
                <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mt-0.5">LMS SMP Negeri 4 Kota Serang</p>
            </div>
            <div class="text-right">
                <span class="text-[10px] font-mono text-gray-400 block">TANGGAL CETAK</span>
                <span class="text-xs font-bold text-gray-800">{{ date('d M Y, H:i') }} WIB</span>
            </div>
        </div>

        {{-- INFO IDENTITAS SISWA --}}
        <div class="grid grid-cols-2 gap-4 mt-4 pt-3 border-t border-gray-100 text-xs">
            <div class="space-y-1">
                <div class="flex"><span class="w-24 text-gray-400 font-medium">Nama Siswa</span> <span class="font-bold text-gray-800">: {{ Auth::user()->name }}</span></div>
                <div class="flex"><span class="w-24 text-gray-400 font-medium">Peran</span> <span class="font-bold text-gray-800">: Siswa</span></div>
            </div>
            <div class="space-y-1 text-right">
                <div class="flex justify-end"><span class="w-28 text-gray-400 font-medium text-left">Standar KKM</span> <span class="font-bold text-gray-800">: 75</span></div>
            </div>
        </div>
    </div>

    {{-- Komponen Tabel Rincian Nilai --}}
    @include('siswa.transkrip.components._table')

</div>

{{-- CONFIGURASI PRINT CSS --}}
<style>
    @media print {
        @page { 
            size: A4 portrait; 
            margin: 1cm; 
        }
        body { 
            background-color: white !important; 
            color: black !important;
            -webkit-print-color-adjust: exact;
        }
        nav, aside, header, footer, .sidebar, button, .print\:hidden { 
            display: none !important; 
        }
        main, #app, .content, .container { 
            width: 100% !important; 
            max-width: none !important; 
            margin: 0 !important; 
            padding: 0 !important; 
            box-shadow: none !important;
        }
        .print-detail-show {
            display: table-row !important;
        }
    }
</style>
@endsection