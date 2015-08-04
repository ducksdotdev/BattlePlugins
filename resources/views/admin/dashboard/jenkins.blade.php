@if(count($jenkins))
    <div class="grid-100">
        <h3>Latest Jenkins Builds <a href="http://ci.battleplugins.com"><i class="icon external"></i></a></h3>
    </div>
    @if(!$jenkins_online)
        <div class="grid-100">
            <div class="ui message negative text-center">
                <h2>The Jenkins Server is OFFLINE!</h2>
            </div>
        </div>
    @else
        @foreach($jenkins as $build)
            <div class="grid-100">
                <div class="ui small message {{ $build->getData()->result == 'SUCCESS' ? 'green' : 'red' }}">
                    <a href="{{ $build->getData()->url }}">{{ $build->getData()->fullDisplayName }} -
                    <span title="{{ $build->createdAt() }}">
                        {{ $build->createdAt()->diffForHumans() }}
                    </span>
                    </a>
                    @if($build->getJob()->getData()->healthReport)
                        <p>
                            @foreach($build->getJob()->getData()->healthReport as $report)
                                {{ $report->description }}
                            @endforeach
                        </p>
                    @endif
                </div>
            </div>
        @endforeach
    @endif
@endif