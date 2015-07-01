@extends('admin.layouts.master')
@section('content')
    {!! Form::open(['id'=>'contactForm','url'=>URL::to('/settings', [], env('HTTPS_ENABLED', true)), 'class'=>'ui fluid form segment']) !!}
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
        <h2>User Information</h2>

        <div class="field">
            {!! Form::label('email', 'Your Email (Can\'t be changed)') !!}
            {!! Form::text('email', $email, ['disabled'=>true]) !!}
        </div>
        <div class="field">
            {!! Form::label('displayname', 'Display Name') !!}
            {!! Form::text('displayname', null, []) !!}
        </div>
    </div>
    <div class="grid-100">
        <h2>Password</h2>

        <div class="field">
            {!! Form::label('newpassword', 'New Password') !!}
            {!! Form::text('newpassword', null, []) !!}
        </div>
        <div class="field">
            {!! Form::label('newpassword2', 'Repeat New Password') !!}
            {!! Form::text('newpassword2', null, []) !!}
        </div>
    </div>
    <div class="col-lg-12">
        <h2>Confirm Changes</h2>

        <div class="field">
            {!! Form::label('password', 'Current Password') !!}
            {!! Form::text('password', null, []) !!}
        </div>
    </div>
    {!! Form::submit('Save Changes', ['class'=>'ui button primary']) !!}
    {!! Form::close() !!}
@stop