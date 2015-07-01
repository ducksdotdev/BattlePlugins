@extends('api.layouts.master')
@section('content')
    <div id="loginBox">
        <div class="grid-container">
            @include('login')
            <div class="grid-30">
                <p class="text-right"><a href="#">Register</a> | <a href="#">Forgot Password</a></p>

                <p>BattleAdmin is the web interface BattlePlugins' administration panel. You must be authorized to access the admin panel.</p>
            </div>
        </div>
    </div>
@stop