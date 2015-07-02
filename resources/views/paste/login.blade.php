@extends('paste.layouts.login')
@section('content')
    <div id="loginBox">
        <div class="grid-container">
            @include('login')
            <div class="grid-30">
                @include('loginlinks')
                <p>BattlePaste is a paste service for BattlePlugins. You must be authorized to access the paste feature.</p>
            </div>
        </div>
    </div>
@stop