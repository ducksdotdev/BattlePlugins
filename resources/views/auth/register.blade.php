@extends('auth.layouts.layout')
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

    {!! Form::open(['url'=>URL::to('/auth/register', [], env('HTTPS_ENABLED', true)),'class'=>'ui form']) !!}
    <div class="field">
        <label>Minecraft Name</label>
        <input type="text" name="name" value="{{ old('name') }}">
    </div>

    <div class="field">
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}">
    </div>

    <div class="field">
        <label>Password</label>
        <input type="password" name="password">
    </div>

    <div class="field">
        <label>Confirm Password</label>
        <input type="password" name="password_confirmation">
    </div>

    <div class="field text-right">
        <button type="submit" class="ui button green">Register</button>
    </div>
    {!! Form::close() !!}
@stop