@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto mb-20">
    
    {{-- Panggil Tombol Batal & Header Biru --}}
    @include('guru.materi.components._header')

    {{-- Bento Form Card --}}
    <div class="bg-white rounded-b-3xl rounded-t-none shadow-sm border border-gray-100 border-t-0">
        
        {{-- Panggil Form Inputan Materi --}}
        @include('guru.materi.components._form')
        
    </div>
</div>
@endsection