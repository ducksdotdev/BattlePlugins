<div class="item
					@if($task->status)
						completed
					@endif" id="{{ $task->id }}"
     ng-class="{highlighted: {{ $task->id }} == highlighted}"
     ng-hide="{{ $task->status }} && !showCompleted">
    <div class="content @if(Auth::check()) grid-90 @else grid-100 @endif">
        <div class="header">
            <a href="#{{ $task->id }}" ng-click="setHighlighted({{ $task->id }})"><i
                        class="icon linkify"></i></a>
            {{$task->title}}
            @if(Auth::check() && $task->public)
                (Public)
            @endif
            <small>Assigned
                @if($task->assigned_to != 0)
                    to <span class="name">{{ $displaynames[$task->assigned_to] }}</span>
                @endif
                by <span class="name">{{ $displaynames[$task->creator] }}</span>
            </small>
        </div>
        <div class="description editable">
            {!! strip_tags(Linkify::link($task->content), '<a><br>') !!}
        </div>
    </div>
    @if(Auth::check())
        <div class="actions grid-10 text-right">
            {!! Form::open(['url'=>URL::to('/tasks/complete/' . $task->id, [], env('HTTPS_ENABLED', true))]) !!}
            <button class="circular small ui positive icon button" ng-class="{disabled: {{ $task->status }} || {{$task->creator}} == 24}"><i class="icon check"></i></button>
            {!! Form::close() !!}
            {!! Form::open(['url'=>URL::to('/tasks/complete/' . $task->id, [], env('HTTPS_ENABLED', true))]) !!}
            <button class="circular red small ui icon button"><i class="icon trash"></i></button>
            {!! Form::close() !!}
        </div>
    @endif
</div>