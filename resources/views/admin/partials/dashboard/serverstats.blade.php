@if($serverData)
    <h3>
        <small>Updated every minute. Last updated {{ $serverData['updated_at']->diffForHumans() }}.</small>
    </h3>
    <ul class="stats small">
        @foreach($serverData['servers'] as $server)
            <li class="{{ $server['online'] ? 'green' : 'red' }}">
                <a href="http://{{ $server['url'] }}">{{ ucfirst($server['name']) }}</a>
            </li>
        @endforeach
    </ul>
@endif