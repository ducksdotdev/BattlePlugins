@extends('layouts.email')
@section('content')
<div class="panel-body">
    <p>Hello {{ $username }},</p>
    <p>A password reset was requested for your account at <a href="http://battleplugins.com/">BattlePlugins</a>. If this was not you who sent the request, please ignore this email and we won't bother you again. If you did request this email, please click the following link to reset your password:</p>
    <p class="text-center"><a href="http://battleplugins.com/login/help/reset?key={{ $key }}">http://battleplugins.com/login/help/reset?key={{ $key }}</a></p>
</div>
@stop
