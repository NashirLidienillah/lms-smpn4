@extends('layouts.app')

@section('content')

{{-- Panggil Action Bar & Notifikasi --}}
@include('admin.mapel.components._action_bar')

<div class="space-y-6">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Panggil Form Tambah Mapel (Kiri) --}}
        @include('admin.mapel.components._form_tambah')

        {{-- Panggil Grid Data Mapel & Filter (Kanan) --}}
        @include('admin.mapel.components._mapel_grid')

    </div>
</div>

{{-- Panggil Modal Delete --}}
@include('admin.mapel.components._modal_delete')

{{-- Panggil Script --}}
@include('admin.mapel.components._script')

@endsection