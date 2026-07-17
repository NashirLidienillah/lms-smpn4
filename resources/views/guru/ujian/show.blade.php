@extends('layouts.app')

@section('content')
    @include('guru.ujian.components._show_header')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        @include('guru.ujian.components._show_list_soal')
        @include('guru.ujian.components._show_form_soal')
    </div>
@endsection