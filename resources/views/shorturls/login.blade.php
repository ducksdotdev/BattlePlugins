@extends('shorturls.layouts.login')
@section('content')
    <div id="loginBox">
        <div class="grid-container">
            @include('login')
            <div class="grid-30">
                <p class="text-right"><a href="#">Register</a> | <a href="#">Forgot Password</a></p>
                <p>bplug.in is a URL shortening website for BattlePlugins. You must be authorized to access this tool.</p>
            </div>
        </div>
    </div>
@stop