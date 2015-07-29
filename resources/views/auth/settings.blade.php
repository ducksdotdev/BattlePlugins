@extends('auth.layouts.layout')
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
        {!! Form::submit('Save Changes', ['class'=>'ui button primary']) !!}
    </div>
    {!! Form::close() !!}
@stop