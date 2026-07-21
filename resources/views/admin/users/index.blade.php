@extends('layouts.app')

@section('content')

@include('admin.users.components._index_action_bar')

<div class="space-y-6">
    @include('admin.users.components._index_table')
</div>

@include('admin.users.components._index_modals')
@include('admin.users.components._index_script')

@endsection