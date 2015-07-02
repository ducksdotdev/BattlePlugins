@extends('admin.layouts.login')
@section('content')
    <div id="loginBox">
        <div class="grid-container">
            @include('login')
            <div class="grid-30">
                @include('loginlinks')
                <p>BattleAdmin is the web interface BattlePlugins' administration panel. You must be authorized to access the admin panel.</p>
            </div>
        </div>
    </div>
@stop