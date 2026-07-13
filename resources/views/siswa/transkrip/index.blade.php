@extends('layouts.app')

@section('content')
<div class="space-y-8 pb-12 print:space-y-6 print:pb-0 text-gray-800">
    
    {{-- Komponen Header Transkrip --}}
    @include('siswa.transkrip.components._header')

    {{-- Komponen Statistik Ringkasan --}}
    @include('siswa.transkrip.components._stats')

    {{-- Komponen Tabel Rincian Nilai --}}
    @include('siswa.transkrip.components._table')

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