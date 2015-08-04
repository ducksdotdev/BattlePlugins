@if($serverData)
    <h3>
        <small>Updated every minute. Last updated <span title="{{ $serverData['updated_at'] }}">{{ $serverData['updated_at']->diffForHumans() }}</span>.</small>
    </h3>
    <ul class="stats small">
        @foreach($serverData['servers'] as $server)
            <li class="{{ $server['online'] ? 'green' : 'red' }}">
                <a href="http://{{ $server['url'] }}">{{ ucfirst($server['name']) }}</a>
            </li>
        @endforeach
    </ul>
@endif