@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto mb-20">
    
    {{-- Panggil Header (Tombol Kembali & Banner Ungu) --}}
    @include('guru.tugas.components._edit_header')

    {{-- Bento Form Card --}}
    <div class="bg-white rounded-b-3xl rounded-t-none shadow-sm border border-gray-100 border-t-0">
        
        {{-- Panggil Form Inputan Tugas --}}
        @include('guru.tugas.components._edit_form')
        
    </div>
</div>
@endsection