<tr @if(!$build->isStable()) class="warning" @endif>
    <td>
        @if(auth()->check())
            {!! Form::open(['url'=>URL::to('/job/' . $build->getData()->timestamp .'/production', [], env('HTTPS_ENABLED', true)), 'class'=>'inline']) !!}
            @if($production->find($build->getData()->timestamp))
                <button class="ui button mini red">Mark Unstable</button>
            @else
                <button class="ui button mini primary">Mark Stable</button>
            @endif
            {!! Form::close() !!}
        @elseif($build->isStable())
            <span class="ui label blue">Stable</span>
        @endif
        <strong>
            {{ $build->getJob()->getName() }}
            {{ $build->getVersion() }}
        </strong>
    </td>
    <td title="{{ $build->createdAt() }}">
        {{ $build->createdAt()->diffForHumans() }}
    </td>
    <td><span class="hide-on-desktop">Downloads:</span> {{ $build->getDownloadCount() }}</td>
    <td class="text-right">
        <a href="{{ $build->getData()->url }}" class="ui button mini icon labeled"><i class="icon book"></i> Build Details</a>
        <a href="{{ $build->getDownloadUrl() }}" class="ui button green mini labeled icon"><i class="icon download"></i> Download</a>

        <div class="ui dropdown inline">
            <button class="ui button mini icon"><i class="icon share alternate"></i></button>
            <div class="menu hidden">
                @include('download.partials.share')
            </div>
        </div>
    </td>
</tr>