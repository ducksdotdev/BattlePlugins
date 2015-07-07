<!DOCTYPE html>
<html lang="en" ng-app="BattleTasks">
<head>
    @include('shorturls.partials.head')
    <link rel="stylesheet" href="/assets/css/styles.css" type="text/css"/>
</head>
<body>
<div class="grid-100 text-right">
    <a id="logoutButton" href="/logout" class="ui button">Logout</a>
</div>
<div class="grid-container">
    <div class="grid-65 grid-parent grid-center">
        <div class="task-header">
            <div class="grid-container">
                <div class="grid-100">
                    <h2>password reset</h2>
                </div>
            </div>
        </div>
        <div class="ui divided list">
            <div class="item">
                @yield('content')
            </div>
        </div>
        @include('footer')
    </div>
</div>
</body>
</html>