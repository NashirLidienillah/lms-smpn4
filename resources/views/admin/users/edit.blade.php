@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto mb-24">
    @include('admin.users.components._edit_header')
    @include('admin.users.components._edit_form')
</div>
@endsection