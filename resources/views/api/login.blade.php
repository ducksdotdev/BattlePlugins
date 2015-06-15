@extends('api.layouts.master')
@section('content')
    <div id="loginBox">
        <div class="grid-container">
            <div class="grid-100">
                @if(session()->has('error'))
                    <div id="loginError" class="alert error">
                        {{session('error')}}
                    </div>
                @endif
            </div>
            <div class="grid-70 grid-parent">
                {!! Form::open(['url'=>URL::to('/login', [], env('HTTPS_ENABLED', true)),'class'=>'ui form']) !!}
                <div class="grid-container">
                    <div class="grid-50">
                        <label>Email</label>
                        {!! Form::text('email', '', ['id'=>'email','placeholder'=>'@battleplugins.com']) !!}
                    </div>
                    <div class="grid-40">
                        <label>Password</label>
                        {!! Form::password('password', ['placeholder'=>'Password']) !!}
                    </div>
                </div>
                <div class="grid-container">
                    <div class="grid-50">
                        <div class="ui toggle checkbox">
                            <label>Remember Me?</label>
                            {!! Form::checkbox('rememberMe') !!}
                        </div>
                    </div>
                    <div class="grid-40 text-right">
                        <button id="loginButton" class="ui button green">
                            Login
                        </button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
            <div class="grid-30">
                <p class="text-right"><a href="#">Register</a> | <a href="#">Forgot Password</a></p>

                <p>BattleWebAPI is a website for BattlePlugins' website API and API documentation. You must be authorized to access the API.</p>
            </div>
        </div>
    </div>
@stop