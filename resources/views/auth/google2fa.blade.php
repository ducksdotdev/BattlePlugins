@extends('layouts.auth')
@section('content')
    @if(UserSettings::hasNode(auth()->user(), UserSettings::FORCE_2FA) && !auth()->user()->google2fa_secret)
        <div class="ui message info">
            Because of your elevated permissions, you must use two factor authentication.
        </div>
    @endif
    {!! Form::open(['url'=>URL::to('/user/settings/google2fa', [], env('HTTPS_ENABLED', true)), 'class'=>'ui fluid form']) !!}
    {!! Form::hidden('google2fa_secret', $google2fa_secret) !!}
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
    <div class="text-center">
        <small>{{ $google2fa_secret }}</small>
        <br/>
        {!! HTML::image(Google2FA::getQRCodeGoogleUrl('BattlePlugins', auth()->user()->email, $google2fa_secret)) !!}
        <br/>Scan this QR code into your authentication app or enter the key manually. Afterwards, enter the number it gives you in the box below to confirm that your 2FA has
        been set up properly.
    </div>
    <div class="field">
        {!! Form::label('google2fa_secret_confirmation', 'Enter Secret') !!}
        {!! Form::text('google2fa_secret_confirmation') !!}
    </div>
    <div class="field text-right">
        @if(!(UserSettings::hasNode(auth()->user(), UserSettings::FORCE_2FA) && !auth()->user()->google2fa_secret))
            <a href="{{ action('Auth\UserController@getSettings') }}" class="pull-left ui button black">Back</a>
        @endif
        {!! Form::submit('Enable 2FA', ['class'=>'ui button primary']) !!}
    </div>
    {!! Form::close() !!}
@stop