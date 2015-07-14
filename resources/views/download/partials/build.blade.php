<tr @if(!$production->find($build->timestamp)) class="warning" @endif>
    <td>
        @if(auth()->check())
            {!! Form::open(['url'=>URL::to('/job/' . $build->timestamp .'/production', [],
            env('HTTPS_ENABLED', true)), 'class'=>'inline']) !!}
            @if($production->find($build->timestamp))
                <button class="ui button mini red">Mark Unstable</button>
            @else
                <button class="ui button mini primary">Mark Stable</button>
            @endif
            {!! Form::close() !!}
        @elseif($production->find($build->timestamp))
            <span class="ui label blue">Stable</span>
        @endif
        <strong>{{ explode(' ', $build->fullDisplayName)[0] }}
            {{ Jenkins::getBuildVersion(Jenkins::getJobFromBuild($build), $build->number) }}</strong>
    </td>
    <td>{{ Carbon::createFromTimestampUTC(str_limit($build->timestamp, 10))->diffForHumans() }}</td>
    <td><span class="hide-on-desktop">Downloads:</span> {{ Jenkins::getDownloadCount($build) }}</td>
    <td class="text-right">
        <a href="{{ $build->url }}" class="ui button mini icon labeled"><i class="icon book"></i>
            Build Details</a>
        <a href="/job/{{ explode(' ', $build->fullDisplayName)[0] }}/download/{{ $build->number }}"
           class="ui button green mini labeled icon"><i class="icon download"></i> Download</a>

        <div class="ui dropdown inline">
            <button class="ui button mini icon"><i class="icon share alternate"></i></button>
            <div class="menu hidden">
                @include('download.partials.share')
            </div>
        </div>
    </td>
</tr>