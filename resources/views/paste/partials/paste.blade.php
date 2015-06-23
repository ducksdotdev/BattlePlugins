<div class="paste-item grid-33">
    <div class="header">
        <a href="/{{ $paste->slug }}">
            @if($paste->title)
                {{ $paste->title }}
            @else
                {{ $paste->slug }}
            @endif
        </a>
        @if($paste->public)
            (Public)
        @endif
    </div>
    <div class="description">
        Created <span title="{{ $paste->created_at }}">{{ $paste->created_at->diffForHumans() }}</span>.<br/>
        @if($paste->created_at != $paste->updated_at)Last modified <span title="{{ $paste->updated_at }}">{{ $paste->updated_at->diffForHumans()
                }}</span>.
        @endif
    </div>
</div>