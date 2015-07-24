<h3>Tasks Overview <a href="{{ action('Tasks\PageController@index') }}"><i class="icon external"></i></a></h3>
<ul class="stats">
    <li class="{{ $myTasks ? 'yellow' : 'green' }} has-small">
        {{ $myTasks }}
        <div class="small">Assigned to You</div>
    </li>
    <li class="{{ count($tasks->whereCompleted(false)->get()) ? 'yellow' : 'green' }} has-small">
        {{ count($tasks->whereCompleted(false)->get()) }}
        <div class="small">Incomplete</div>
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