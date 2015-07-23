<!DOCTYPE html>
<html lang="en" ng-app="BattleTasks">
<head>
    @include('tasks.partials.head')
</head>
<body>
<div id="top"></div>
@if(!Auth::check())
    <div class="grid-100 text-right">
        <a id="loginButton" href="/login" class="ui button">Login</a>
    </div>
@endif
@include('tasks.partials.tasks')
@if(session()->has('error'))
    <script type="text/javascript">
        $("#login").sidebar({duration: 0}).sidebar('toggle')
    </script>
@endif
</body>
</html>
