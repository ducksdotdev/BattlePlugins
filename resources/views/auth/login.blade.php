@extends('layouts.auth')
@section('content')
    @if(count($errors) > 0)
        <div id="loginError" class="ui message error">
            There was an error logging you in!
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    {!! Form::open(['url'=>URL::to(action('Auth\AuthController@postLogin'), [], env('HTTPS_ENABLED', true)),'class'=>'ui form']) !!}
    <div class="two fields">
        <div class="field">
            <label>Email</label>
            {!! Form::text('email', '', ['id'=>'email','placeholder'=>'Email']) !!}
        </div>
        <div class="field">
            <label>Password</label>
            {!! Form::password('password', ['placeholder'=>'Password']) !!}
        </div>
    </div>
    <div class="ui toggle checkbox">
        <label>Remember Me?</label>
        {!! Form::checkbox('remember') !!}
    </div>
    <span class="pull-right">
        @if(Settings::get('registration'))
            <a href="{{ action('Auth\AuthController@getRegister') }}">Register</a> |
        @endif
        <a href="{{ action('Auth\PasswordController@getEmail') }}">Forgot Password</a>
        <button id="loginButton" class="ui button green">Login</button>
    </span>
    {!! Form::close() !!}
@stop