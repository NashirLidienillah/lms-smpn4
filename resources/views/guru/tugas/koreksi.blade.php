@extends('layouts.app')

@section('content')

<div class="space-y-6">
    
    {{-- Panggil Header Statistik Koreksi --}}
    @include('guru.tugas.components._koreksi_header')

    {{-- Panggil Tabel Form Penilaian --}}
    @include('guru.tugas.components._koreksi_table')

</div>

@endsection