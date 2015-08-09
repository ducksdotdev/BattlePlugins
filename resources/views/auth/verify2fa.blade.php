@extends('layouts.auth')
@section('content')
    {!! Form::open(['url'=>URL::to('/user/settings/google2fa', [], env('HTTPS_ENABLED', true)), 'class'=>'ui fluid form']) !!}
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
        {!! Form::label('google2fa_secret', 'Enter Secret') !!}
        {!! Form::text('google2fa_secret') !!}
    </div>
    <div class="field text-right">
        {!! Form::submit('Confirm', ['class'=>'ui button primary']) !!}
    </div>
    {!! Form::close() !!}
@stop