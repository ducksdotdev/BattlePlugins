@extends('admin.layouts.master')
@section('content')
    {!! Form::open(['url'=>URL::to('/user/create', [], env('HTTPS_ENABLED', true)), 'class'=>'ui fluid form']) !!}
    @if(count($errors) > 0)
        <div class="ui message negative">
            There was an error creating that user!
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
            {!! Form::label('email', 'Email') !!}
            {!! Form::text('email', '@battleplugins.com', ['placeholder'=>'@battleplugins.com']) !!}
        </div>
        <div class="field">
            {!! Form::label('displayname', 'Display Name (Minecraft Username)') !!}
            {!! Form::text('displayname', '', ['placeholder'=>'Minecraft Username']) !!}
        </div>
        <div class="field">
            {!! Form::label('password', 'Enter Password') !!}
            {!! Form::text('password', str_random(10), ['placeholder'=>'Password']) !!}
        </div>
        <div class="field">
            <div class="ui toggle checkbox">
                {!! Form::label('isadmin', 'Is user an admin?') !!}
                {!! Form::checkbox('isadmin') !!}
            </div>
        </div>
        <div class="grid-100 text-right">
            {!! Form::submit('Add User', ['class'=>'ui button primary']) !!}
        </div>
    </div>
    {!! Form::close() !!}
@stop
