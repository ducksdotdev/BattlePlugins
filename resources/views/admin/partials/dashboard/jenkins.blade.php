@if(count($jenkins) > 0)
    <div class="grid-100">
        <h3>Latest Jenkins Builds <a href="http://ci.battleplugins.com"><i class="icon external"></i></a></h3>
    </div>
    @foreach(array_slice($jenkins, 0, 3) as $build)
        <div class="grid-100">
            <div class="ui small message {{ $build->result == 'SUCCESS' ? 'green' : 'red' }}">
                <a href="{{ $build->url }}">{{ $build->fullDisplayName }} -
                    <span title="{{ Carbon::createFromTimestampUTC(str_limit($build->timestamp, 10)) }}">
                        {{ Carbon::createFromTimestampUTC(str_limit($build->timestamp, 10))->diffForHumans() }}
                    </span>
                </a>
            </div>
        </div>
    @endforeach
@endif