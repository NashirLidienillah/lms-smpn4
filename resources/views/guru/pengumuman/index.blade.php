@extends('layouts.guru')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Kelola Pengumuman Kelas</h1>

    {{-- Alert Notifikasi kalau berhasil atau gagal --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        {{-- BAGIAN KIRI: Form Tambah Pengumuman --}}
        <div class="col-md-4 mb-4">
            @include('guru.pengumuman.components._form')
        </div>

        {{-- BAGIAN KANAN: Tabel Daftar Pengumuman --}}
        <div class="col-md-8">
            @include('guru.pengumuman.components._table')
        </div>
    </div>
</div>
@endsection