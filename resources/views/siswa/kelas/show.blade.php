@extends('layouts.app')
@section('content')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<div class="space-y-6">
    @include('siswa.kelas.components._action_bar')
    @include('siswa.kelas.components._header')

    {{-- Sistem Tabs --}}
    <div x-data="{ tab: 'materi' }" class="space-y-6">
        
        {{-- Tombol Navigasi Tab --}}
        @include('siswa.kelas.components._tab_navigasi')
        @include('siswa.kelas.components._tab_materi')
        @include('siswa.kelas.components._tab_tugas')
        @include('siswa.kelas.components._tab_ujian')
        
    </div>
</div>

@include('siswa.kelas.components._modal_pengumuman')
@endsection