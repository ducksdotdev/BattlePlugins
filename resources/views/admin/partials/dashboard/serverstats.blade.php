<h3>
    Server Status <br/>
    <small>Updated every {{ $updateMins }} minutes. Last updated {{ $serverData['updated_at']->diffForHumans() }}.
    </small>
</h3>
<ul class="stats small">
    @foreach($serverData['servers'] as $server)
        <li class="{{ $server['online'] ? 'green' : 'red' }}">
            {{ ucfirst($server['name']) }}
        </li>
    @endforeach
</ul>