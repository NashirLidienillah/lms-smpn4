@extends('layouts.app')

@section('content')

{{-- Panggil Action Bar & Notifikasi --}}
@include('admin.rombel.components._action_bar')

<div class="space-y-6 pb-20">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        
        {{-- Panggil Folder Kelas (Kiri) --}}
        @include('admin.rombel.components._sidebar_kelas')

        {{-- Panggil Manajemen Siswa (Kanan) --}}
        @include('admin.rombel.components._manajemen_siswa')

    </div>
</div>

{{-- Panggil Modal Hapus Siswa --}}
@include('admin.rombel.components._modal_remove')

{{-- Panggil Script & Custom CSS --}}
@include('admin.rombel.components._script')

@endsection