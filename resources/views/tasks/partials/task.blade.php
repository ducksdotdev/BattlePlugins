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