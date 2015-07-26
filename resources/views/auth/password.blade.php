@extends('auth.layouts.layout')
@section('content')
@if(count($errors) > 0)
    <div class="ui message red">
        There was an error processing your request! Please make sure your email is valid.
    </div>
@elseif(session()->has('status'))
    <div class="ui message green">
        We have sent you an email with instructions on how to change your password.
    </div>
@endif
{!! Form::open(['url'=>URL::to('/password/email', [], env('HTTPS_ENABLED', true)),'class'=>'ui form']) !!}
<div class="field">
    <label for="email">Your Email</label>
    {!! Form::text('email', '', ['placeholder'=>'Your Email']) !!}
</div>
<div class="text-right">
    <button class="ui button green">Submit</button>
</div>
{!! Form::close() !!}
@stop