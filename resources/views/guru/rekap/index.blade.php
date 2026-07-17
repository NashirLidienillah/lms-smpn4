@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto pb-24">
    
    {{-- Panggil Action Bar (Tombol Kembali, Print, dan Judul) --}}
    @include('guru.rekap.components._action_bar')

    {{-- Kertas Utama Cetak Rekap --}}
    <div class="bg-white print:bg-transparent rounded-3xl print:rounded-none p-6 md:p-8 print:p-0 shadow-sm print:shadow-none border border-gray-100 print:border-none mb-6 text-gray-800">

        {{-- Panggil Informasi Kelas (Layar & Print) --}}
        @include('guru.rekap.components._info_kelas')

        {{-- Panggil Tabel Rekapitulasi Nilai --}}
        @include('guru.rekap.components._table_nilai')

    </div>
</div>

{{-- Panggil Custom CSS Print Landscape --}}
@include('guru.rekap.components._style')

@endsection