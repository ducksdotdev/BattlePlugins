<h3>Tasks Overview <a href="{{ action('Tasks\PageController@index') }}"><i class="icon external"></i></a></h3>
<ul class="stats">
    <li class="yellow has-small">
        {{ count($tasks->where('assigned_to', auth()->user()->id)->where('status', false)->get()) }}
        <div class="small">Assigned to You</div>
    </li>
    <li class="yellow has-small">
        {{ count($tasks->where('status', false)->get()) }}
        <div class="small">Incomplete</div>
    </li>
    <li class="red has-small">
        {{ count($tasks->where('status', false)->where('creator', 24)->get()) }}
        <div class="small">GitHub Issues</div>
    </li>
    <li class="green has-small">
        {{ count($tasks->where('status', true)->get()) }}
        <div class="small">Completed</div>
    </li>
</ul>