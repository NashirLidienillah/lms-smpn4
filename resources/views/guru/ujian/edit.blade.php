@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto mb-20">
    @include('guru.ujian.components._edit_header')
    <div class="bg-white rounded-b-3xl rounded-t-none shadow-sm border border-gray-100 border-t-0">
        @include('guru.ujian.components._edit_form')
    </div>
</div>
@endsection