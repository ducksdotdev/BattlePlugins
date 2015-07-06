<!DOCTYPE html>
<html lang="en" ng-app="BattleTasks">
<head>
    @include('mobilecolor')
    @include('paste.partials.head')
    <title>BattlePaste :: BattlePlugins Paste Service</title>
    <link rel="stylesheet" href="/assets/css/styles.css" type="text/css"/>
</head>
<body>
<div class="grid-100 text-right">
    <a id="logoutButton" href="/logout" class="ui button">Logout</a>
</div>
@yield('content')
@include('footer')
</body>
</html>