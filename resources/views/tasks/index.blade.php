<!DOCTYPE html>
<html lang="en" ng-app="BattleTasks">
<head>
    @include('tasks.partials.head')
</head>
<body>
<div id="top"></div>
@if(!Auth::check())
    @include('tasks.partials.login')
@else
    <div class="grid-100 text-right">
        <a id="logoutButton" href="/logout" class="ui button">Logout</a>
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
