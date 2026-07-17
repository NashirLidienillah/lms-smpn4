@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto pb-20">
    @include('guru.ujian.components._rekap_header')
    @include('guru.ujian.components._rekap_table')
</div>
@endsection