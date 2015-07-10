@if(count($jenkins) > 0)
    <div class="grid-container">
        <div class="ui items">
            @foreach($jenkins as $build)
                <div class="grid-25">
                    <div class="ui segment">
                        <div class="item">
                            <div class="content">
                                <span class="header">{{ $build->fullDisplayName }}</span>

                                <div class="description">
                                    Last updated <span title="{{ Carbon::createFromTimestampUTC(str_limit($build->timestamp, 10)) }}">
                                        {{ Carbon::createFromTimestampUTC(str_limit($build->timestamp, 10))->diffForHumans() }}
                                    </span>
                                </div>
                                <div class="text-center top-margin ten">
                                    <a href="{{ $build->url }}" class="ui button mini">Build Details</a>
                                    <a href="{{ $build->url }}artifact/{{ $build->artifacts{0}->relativePath }}.jar" class="ui button green mini">Download</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif