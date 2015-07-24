@if($download_server && $jenkins)
    <div class="grid-container">
        <div class="grid-100 grid-parent">
            <div class="ui items">
                @foreach($jenkins as $build)
                    <div class="grid-25">
                        <div class="ui segment">
                            <div class="item">
                                <div class="content">
                                    <strong>
                                        {{ explode(' ', $build->fullDisplayName)[0] }}
                                        {{ Jenkins::getBuildVersion(Jenkins::getJobFromBuild($build), $build->number) }}
                                    </strong>

                                    <span class="pull-right">
                                        <a href="{{ action('Download\JenkinsController@download', ['job'=>explode(' ', $build->fullDisplayName)[0], 'build'=>$build->number]) }}"
                                           class="ui button green mini circular icon"><i class="icon download"></i></a>
                                    </span>
                                    <div class="description">
                                        Last updated
                                            <span title="{{ Carbon::createFromTimestampUTC(str_limit($build->timestamp, 10)) }}">
                                        {{ Carbon::createFromTimestampUTC(str_limit($build->timestamp, 10))->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif