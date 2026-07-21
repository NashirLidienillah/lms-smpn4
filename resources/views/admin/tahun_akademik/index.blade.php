@extends('layouts.app')

@section('content')

{{-- Panggil Action Bar & Notifikasi --}}
@include('admin.tahun_akademik.components._action_bar')

<div class="space-y-6 mb-20">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Panggil Form Tambah Periode (Kiri) --}}
        @include('admin.tahun_akademik.components._form_tambah')

        {{-- Panggil Tabel Periode Aktif (Kanan) --}}
        @include('admin.tahun_akademik.components._table_periode')

    </div>
</div>

{{-- Panggil Modal Delete & Activate --}}
@include('admin.tahun_akademik.components._modal_delete')
@include('admin.tahun_akademik.components._modal_activate')

{{-- Panggil Script Modals --}}
@include('admin.tahun_akademik.components._script')

@endsection