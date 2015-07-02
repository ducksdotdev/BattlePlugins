@extends('api.layouts.master')
@section('content')
    <div id="loginBox">
        <div class="grid-container">
            @include('login')
            <div class="grid-30">
                @include('loginlinks')
                <p>BattleWebAPI is a website for BattlePlugins' website API and API documentation. You must be
                    authorized to access the API.</p>
            </div>
        </div>
    </div>
@stop