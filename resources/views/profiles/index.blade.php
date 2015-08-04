@extends('layouts.profile')
@section('content')
    <div class="grid-container">
        <div class="grid-100">
            <h1>{{ $user->displayname }}</h1>
        </div>
    </div>
    <div class="grid-container">
        <div class="grid-33 grid-parent">
            @include('profiles.partials.pastes')
        </div>
    </div>
    <div class="grid-container">
        <div class="grid-100">
            {{--        @include('profiles.partials.comments')--}}
        </div>
    </div>
@stop