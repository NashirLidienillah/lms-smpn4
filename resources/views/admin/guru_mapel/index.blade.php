@extends('layouts.app')

@section('content')

{{-- Panggil Action Bar & Notifikasi --}}
@include('admin.guru_mapel.components._action_bar')

<div class="space-y-6 mb-20">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        {{-- Panggil Form Tambah Jadwal (Kiri) --}}
        @include('admin.guru_mapel.components._form_tambah')

        {{-- Panggil Grid Jadwal & Filter (Kanan) --}}
        @include('admin.guru_mapel.components._jadwal_grid')

    </div>
</div>

{{-- Panggil Modal Delete --}}
@include('admin.guru_mapel.components._modal_delete')

{{-- Panggil Script & Custom CSS --}}
@include('admin.guru_mapel.components._script_style')

@endsection