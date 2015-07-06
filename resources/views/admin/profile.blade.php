@extends('admin.layouts.master')
@section('content')
    <div class="grid-100">
        <h2><img src="{{ $avatar }}" class="ui mini avatar image"> lDucks</h2>
        {{ $user->email }}
    </div>
@stop