@extends('admin.layouts.master')
@section('content')
    {!! Form::open(['url'=>URL::to('/settings', [], env('HTTPS_ENABLED', true)), 'class'=>'ui fluid form']) !!}
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
    <div class="grid-100">
        <h2>{{ $title }}</h2>

        <div class="field">
            {!! Form::label('email', 'Your Email (Can\'t be changed)') !!}
            {!! Form::text('email', Auth::user()->email, ['disabled'=>true]) !!}
        </div>
        <div class="field">
            {!! Form::label('displayname', 'Display Name') !!}
            {!! Form::text('displayname', Auth::user()->displayname, []) !!}
        </div>
    </div>
    <div class="grid-100">
        <h2>Password</h2>

        <div class="field">
            {!! Form::label('password', 'New Password') !!}
            {!! Form::password('password', null, []) !!}
        </div>
        <div class="field">
            {!! Form::label('password_confirmation', 'Repeat New Password') !!}
            {!! Form::password('password_confirmation', null, []) !!}
        </div>
    </div>
    <div class="grid-100">
        <h2>Confirm Changes</h2>

        <div class="field">
            {!! Form::label('confirmation', 'Current Password') !!}
            {!! Form::password('confirmation', null, []) !!}
        </div>
    </div>
    <div class="grid-100 text-right">
        {!! Form::submit('Save Changes', ['class'=>'ui button primary']) !!}
    </div>
    {!! Form::close() !!}
@stop