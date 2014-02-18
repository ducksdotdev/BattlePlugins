@extends('layouts.email')
@section('content')
<p>Hello,</p>
<p>You have asked for your username at <a href="http://battleplugins.com">BattlePlugins</a>. If you did not send this request, please ignore this email and we won't bother you again.</p>
<p class="text-center">Your login username is <strong>{{ $username }}</strong>. <a href="http://battleplugins.com/login">Click here to login</a>.</p>
@stop
