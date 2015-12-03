@extends('layouts.admin')
@section('content')
    <div ng-controller="TasksCtrl">
        <div id="taskList">
            @if(!$tasks)
                <div class="have-tasks">
                    There are no tasks to show!
                </div>
            @else
                @foreach($tasks as $task)
                    <div class="ui segment" id="{{ $task->id }}"
                         ng-class="{'highlighted': {{ $task->id }} == highlighted}">
                        <div class="content @if(Auth::check()) grid-90 @else grid-100 @endif">
                            <div class="header">
                                <a href="#{{ $task->id }}" ng-click="setHighlighted({{ $task->id }})"><i
                                            class="icon linkify"></i></a>
                                {{$task->title}}
                                @if(Auth::check() && $task->public)
                                    (Public)
                                @endif
                                <small>Assigned
                                    @if($task->assignee_id)
                                        to <span class="name">{{ $task->assignee->displayname }}</span>
                                    @endif
                                    by <span class="name">{{ $task->creator->displayname }}</span>
                                </small>
                            </div>
                            <div class="description">
                                {!! Markdown::convertToHTML(strip_tags($task->content)) !!}
                            </div>
                        </div>
                        @if(Auth::check())
                            <div class="actions grid-10 text-right">
                                @if(UserSettings::hasNode(auth()->user(), UserSettings::DELETE_TASK))
                                    {!! Form::open(['url'=>URL::to('/tasks/delete/' . $task->id, [], env('HTTPS_ENABLED', true))]) !!}
                                    <button class="circular red small ui icon button"><i class="icon trash"></i></button>
                                    {!! Form::close() !!}
                                @endif
                            </div>
                        @endif
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@stop