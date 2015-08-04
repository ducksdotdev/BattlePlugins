@extends('layouts.tasks')
@section('content')
    <div ng-controller="TasksCtrl">
        <div class="grid-100">
            @include('tasks.partials.header')
            <div id="taskList">
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
            </div>
        </div>
        <div class="grid-100">
            <div class="field">
                <div class="ui toggle checkbox" ng-click="toggleCompleted()">
                    <input type="checkbox">
                    <label>Show completed tasks?</label>
                </div>
            </div>
        </div>
    </div>
    <div class="grid-100">
        <div class="task-header">
            <div class="grid-container">
                <div class="grid-85 tablet-grid-85 mobile-grid-85">
                    <h2><i class="icon github"></i> issues</h2>
                </div>
                <div class="grid-15 tablet-grid-15 mobile-grid-15 text-right text-middle actions">
                    @if(Auth::check())
                        <a href="/refreshIssues" class="circular small ui green icon button"><i class="icon refresh"></i></a>
                    @endif
                    <button id="minimizeIssues" class="circular small ui primary icon button"><i class="icon compress"></i></button>
                </div>
            </div>
        </div>
        <div id="issueList">
            @if(!$tasks)
                <div class="have-tasks">
                    There are no issues to show!
                </div>
            @else
                <div class="ui divided list">
                    @foreach($gitIssues as $issue)
                        @include('tasks.partials.issue')
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@stop