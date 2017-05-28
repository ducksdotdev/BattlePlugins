@extends('layouts.auth')
@section('content')
    @if(count($errors) > 0)
        <div class="ui message red">
            There was an error processing your request!
            <ul>
                @foreach($errors as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    {!! Form::open(['url'=>URL::to(action('Auth\PasswordController@postReset'), [], env('HTTPS_ENABLED', true)),'class'=>'ui form']) !!}
    {!! Form::hidden('token', $token) !!}
    <div class="field">
        <label for="email">Your Email</label>
        {!! Form::text('email', null, ['placeholder'=>'Your Email']) !!}
    </div>
    <div class="field">
        <label for="password">New Password</label>
        {!! Form::password('password', null, ['placeholder'=>'New Password']) !!}
    </div>
    <div class="field">
        <label for="password_confirmation">New Password (Confirm)</label>
        {!! Form::password('password_confirmation', null, ['placeholder'=>'New Password (Confirm)']) !!}
    </div>
    <div class="text-right">
        <button class="ui button green">Reset Password</button>
    </div>
    {!! Form::close() !!}
@stop