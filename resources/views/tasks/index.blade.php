<!DOCTYPE html>
<html lang="en" ng-app="BattleTasks">
<head>
    @include('tasks.partials.head')
</head>
<body>
<div id="top"></div>
<noscript class="alert error">
    You must have Javascript enabled to use this site properly.
</noscript>
@if(!Auth::check())
    @include('tasks.partials.login')
@else
    <div class="grid-100 text-right">
        <a id="logoutButton" href="/logout" class="ui button">Logout</a>
    </div>
@endif
<div class="grid-container">
    <div class="grid-65 grid-parent grid-center">
        <div ng-controller="TasksCtrl">
            <div class="grid-container hello">
                <div class="grid-50 tablet-grid-50 hide-on-mobile">
                    @if(Auth::check())
                        Hello, {{ Auth::user()->displayname }}. Welcome to BattleTasks!
                    @endif
                    &nbsp;
                </div>
                <div class="grid-50 tablet-grid-50 mobile-grid-100 text-right">
                    <div class="field">
                        <div class="ui toggle checkbox" ng-click="toggleCompleted()">
                            <input type="checkbox">
                            <label>Show completed tasks?</label>
                        </div>
                    </div>
                </div>
            </div>
            <div id="task-header">
                <div class="grid-container">
                    <div class="grid-85 tablet-grid-85 mobile-grid-85">
                        <h2>battletasks</h2>
                    </div>
                    <div class="grid-15 tablet-grid-15 mobile-grid-15 text-right text-middle actions">
                        @if(Auth::check())
                            <button id="createTask" class="circular small ui positive icon button">
                                <i class="icon plus"></i>
                            </button>
                        @endif
                        <a href="/" id="refresh" class="circular small ui primary icon button"><i
                                    class="icon refresh"></i></a>
                    </div>
                </div>
            </div>
            @if(!$tasks)
                <div class="have-tasks">
                    There are no tasks to show!
                </div>
            @else
                <div class="ui divided list">
                    @foreach($tasks as $task)
                        @include('tasks.partials.task')
                    @endforeach
                </div>
            @endif
            @if(Auth::check())
                @include('tasks.modals.createTask')
            @endif
        </div>
        @include('footer')
    </div>
</div>
@if(session()->has('error'))
    <script type="text/javascript">
        $("#login").sidebar({duration: 0}).sidebar('toggle')
    </script>
@endif
</body>
</html>
