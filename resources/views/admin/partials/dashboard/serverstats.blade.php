<h3>
    Server Status <br/>
    <small>Updated every {{ $updateMins }} minutes. Last updated {{ $serverData['updated_at']->diffForHumans() }}.
    </small>
</h3>
<ul class="stats small">
    @foreach($serverData['servers'] as $server)
        <li class="{{ $server['online'] ? 'green' : 'red' }}">
            <a href="{{ $server['server'] }}">{{ ucfirst($server['name']) }}</a>
        </li>
    @endforeach
</ul>