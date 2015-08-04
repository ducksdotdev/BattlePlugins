<!DOCTYPE html>
<html lang="en" ng-app="BattleTasks">
<head>
    <meta charset="utf-8">
    @include('mobilecolor')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BattleTasks :: BattlePlugins Task Management</title>
    <link rel="icon" href="/assets/img/bt.png"/>

    <!--        Styles -->
    <link rel="stylesheet" href="/assets/css/styles.css"/>
    <link rel="stylesheet" href="/assets/css/semantic.css"/>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.12.0/components/icon.css"/>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/unsemantic/0/unsemantic-grid-responsive.css"/>
    <!--        End Styles -->

    <!-- Scripts -->
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/angular.js/1.3.11/angular.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.12.2/semantic.min.js"></script>
    <script type="text/javascript" src="/assets/js/tasks/ng-scripts.js"></script>
    <script type="text/javascript" src="/assets/js/scripts.js"></script>
    <!-- End Scripts -->
</head>
<body>
<div class="grid-container">
    @yield('content')
    <div class="grid-100">
        @include('footer')
    </div>
</div>
@if(Auth::check())
    @include('tasks.modals.createTask')
@endif
</body>
</html>
