@if(UserSettings::hasNode(auth()->user(), UserSettings::DEVELOPER))
    <h3>Latest Log <a href="{{ action('AdminController@getLogs') }}"><i class="icon external"></i></a></h3>

    <div class="ui message {{$log['level_class']}} log">
        <strong>{{ ucfirst($log['level']) }} - {{ (new Carbon($log['date']))->diffForHumans() }}
            ({{ $log['date'] }})</strong>

        <p>{{ $log['text'] }}
            @if (isset($log['in_file']))
                {{ $log['in_file'] }}
            @endif
        </p>
        @if ($log['stack'])
            <a class="pointer" onclick="$('#stack').toggleClass('hidden')"><i
                        class="icon archive"></i> Toggle Stack</a>
            <pre id="stack" class="hidden">{!! trim($log['stack']) !!}</pre>
        @endif
    </div>
@endif