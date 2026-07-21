@extends('layouts.app')

@section('content')

{{-- Panggil Action Bar & Notifikasi --}}
@include('admin.kelas.components._action_bar')

<div class="space-y-6">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Panggil Form Tambah Kelas (Kiri) --}}
        @include('admin.kelas.components._form_tambah')

        {{-- Panggil Grid Data Kelas & Filter (Kanan) --}}
        @include('admin.kelas.components._kelas_grid')

    </div>
</div>

{{-- Panggil Modal Delete --}}
@include('admin.kelas.components._modal_delete')

{{-- Panggil Script --}}
@include('admin.kelas.components._script')

@endsection