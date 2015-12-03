@if(UserSettings::hasNode(auth()->user(), UserSettings::VIEW_TASK))
    <h3>Tasks Overview <a href="{{ action('AdminController@getTasks') }}"><i class="icon external"></i></a></h3>
    <ul class="stats">
        <li class="{{ $myTasks ? 'yellow' : 'green' }} has-small">
            {{ $myTasks }}
            <div class="small">Assigned to You</div>
        </li>
        <li class="{{ $issues ? 'red' : 'green' }} has-small">
            {{ $issues }}
            <div class="small">GitHub Issues</div>
        </li>
        <li class="{{ $closedTasks ? 'green' : 'red'}} has-small">
            {{ $closedTasks }}
            <div class="small">Completed</div>
        </li>
    </ul>
@endif