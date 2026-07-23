@extends('layouts.app')

@section('content')
<div class="space-y-8 pb-12 print:space-y-4 print:pb-0 text-gray-800">
    
    {{-- Header Web Normal (Hilang saat Print) --}}
    <div class="print:hidden">
        @include('siswa.transkrip.components._header')
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