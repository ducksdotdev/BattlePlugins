@if(Auth::check() && Auth::user()->id == $paste->creator)
    <div class="grid-100 text-right">
        @if($paste->public)
            <a href="/togglepub/{{ $paste->id }}" class="ui button black">Make Private</a>
        @else
            <a href="/togglepub/{{ $paste->id }}" class="ui button green">Make Public</a>
        @endif
        <a href="/delete/{{ $paste->id }}" class="ui button red">Delete Paste</a>
    </div>
@endif