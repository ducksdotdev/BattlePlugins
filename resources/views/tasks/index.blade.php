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
                        <div class="item
					@if($task->status)
						completed
					@endif" id="task{{ $task->id }}"
                             ng-class="{highlighted: {{ $task->id }} == highlighted}"
                             ng-hide="{{ $task->status }} && !showCompleted">
                            <div class="content @if(Auth::check()) grid-90 @else grid-100 @endif">
                                <div class="header">
                                    <a href="#task{{ $task->id }}" ng-click="setHighlighted({{ $task->id }})"><i
                                                class="icon linkify"></i></a>
                                    {{$task->title}}
                                    @if(Auth::check() && $task->public)
                                        (Public)
                                    @endif
                                    <small>Assigned
                                        @if($task->assigned_to != 0)
                                            to
                                            <span class="name">
											{{ User::find($task->assigned_to)->displayname }}
										</span>
                                        @endif
                                        by
									<span class="name">
										{{ User::find($task->creator)->displayname }}
									</span>
                                    </small>
                                </div>
                                <div class="description editable">
                                    {!! strip_tags(Linkify::link($task->content), '<a><br>') !!}
                                </div>
                            </div>
                            @if(Auth::check())
                                <div class="actions grid-10 text-right">
                                    <div ng-click="completeTask($event, {{ $task->id }})"
                                         class="pull-left circular small ui positive icon button"
                                         ng-class="{disabled: {{ $task->status }} || {{$task->creator}} == 24}">
                                        <i class="icon check"></i>
                                    </div>
                                    <div ng-click="deleteTask($event, {{ $task->id }})"
                                         class="delete-task pull-left circular red small ui icon button">
                                        <i class="icon trash"></i>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
            @if(Auth::check())
                @include('tasks.modals.createTask')
            @endif
        </div>
        @include('tasks.partials.footer')
    </div>
</div>
@if(session()->has('error'))
    <script type="text/javascript">
        $("#login").sidebar({duration: 0}).sidebar('toggle')
    </script>
@endif
</body>
</html>