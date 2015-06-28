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