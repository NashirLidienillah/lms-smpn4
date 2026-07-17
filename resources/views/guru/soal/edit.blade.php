@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto mb-20">
    
    {{-- Panggil Header (Tombol Kembali & Banner Hijau) --}}
    @include('guru.soal.components._header')

    {{-- Bento Form Card --}}
    <div class="bg-white rounded-b-3xl rounded-t-none shadow-sm border border-gray-100 border-t-0">
        
        {{-- Panggil Form Inputan Soal --}}
        @include('guru.soal.components._form')
        
    </div>
</div>
@endsection