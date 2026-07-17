@extends('layouts.app')

@section('content')

{{-- Panggil Action Bar (Tombol Kembali, Notifikasi, dsb) --}}
@include('guru.kelas.components._action_bar')

{{-- Panggil Header Info Kelas --}}
@include('guru.kelas.components._header')

{{-- Panggil Tombol Navigasi Tab --}}
@include('guru.kelas.components._tab_navigasi')

{{-- Area Konten Tab (Materi, Tugas, Ujian) --}}
<div>
    @include('guru.kelas.components._tab_materi')
    @include('guru.kelas.components._tab_tugas')
    @include('guru.kelas.components._tab_ujian')
</div>

{{-- Panggil Modal Pop-up Pengumuman --}}
@include('guru.kelas.components._modal_pengumuman')

{{-- Panggil Kumpulan Script Interaksi --}}
@include('guru.kelas.components._script')

@endsection