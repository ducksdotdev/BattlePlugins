@extends('layouts.auth')
@section('content')
    {!! Form::open(['url'=>URL::to('/user/settings', [], env('HTTPS_ENABLED', true)), 'class'=>'ui fluid form']) !!}
    @if(count($errors) > 0)
        <div class="ui message negative">
            There was an error processing your request!
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @elseif(session()->has('success'))
        <div class="ui message positive">
            {{ session()->get('success') }}
        </div>
    @endif
    <div class="field">
        {!! Form::label('email', 'Your Email') !!}
        {!! Form::text('email', null, ['placeholder'=>auth()->user()->email]) !!}
    </div>
    <div class="field">
        {!! Form::label('displayname', 'Display Name (Minecraft Name)') !!}
        {!! Form::text('displayname', null, ['placeholder'=>auth()->user()->displayname]) !!}
    </div>
    <h2>Password</h2>

    <div class="field">
        {!! Form::label('password', 'New Password') !!}
        {!! Form::password('password') !!}
    </div>
    <div class="field">
        {!! Form::label('password_confirmation', 'Repeat New Password') !!}
        {!! Form::password('password_confirmation') !!}
    </div>
    <h2>Confirm Changes</h2>

    <div class="field">
        {!! Form::label('confirmation', 'Current Password') !!}
        {!! Form::password('confirmation') !!}
    </div>
    <div class="field text-right">
        @if(!auth()->user()->google2fa_secret)
            <a href="{{ action('Auth\UserController@getTwoFactorAuthentication') }}" class="pull-left ui button black">Setup 2FA</a>
        @else
            <a href="{{ action('Auth\UserController@getDisableTwoFactorAuthentication') }}" class="pull-left ui button black">Turn Off 2FA</a>
        @endif
        {!! Form::submit('Save Changes', ['class'=>'ui button primary']) !!}
    </div>
    {!! Form::close() !!}
@stop