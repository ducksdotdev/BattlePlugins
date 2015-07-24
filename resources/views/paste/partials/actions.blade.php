@if(Auth::check() && Auth::user()->id == $paste->creator->id)
    <div class="grid-100 text-right">
        {!! Form::open(['url'=>URL::to('/togglepub/' . $paste->id, [], env('HTTPS_ENABLED', true)), 'class'=>'inline']) !!}
        @if($paste->public)
            <button class="ui button black">Make Private</button>
        @else
            <button class="ui button green">Make Public</button>
        @endif
        {!! Form::close() !!}
        {!! Form::open(['url'=>URL::to('/delete/' . $paste->id, [], env('HTTPS_ENABLED', true)), 'class'=>'inline']) !!}
        <button class="ui button red">Delete Paste</button>
        {!! Form::close() !!}
    </div>
@endif