<div class="item">
    <div class="content @if(Auth::check()) grid-90 @else grid-100 @endif">
        <div class="header">
            <a href="/{{ $paste->slug }}">
                @if($paste->title)
                    {{ $paste->title }}
                @else
                    {{ $paste->slug }}
                @endif
            </a>
        </div>
        <div class="description">
            @if($paste->public)
                (Public)
            @endif
            Created {{ $paste->created_at->diffForHumans() }}.
            @if($paste->created_at != $paste->updated_at)
                Last modified {{ $paste->updated_at->diffForHumans() }}
            @endif
        </div>
    </div>
    @if(Auth::check())
        <div class="actions grid-10 text-right">
            <a href="/delete/{{ $paste->id }}"
               class="delete-paste pull-left circular red small ui icon button">
                <i class="icon trash"></i>
            </a>
        </div>
    @endif
</div>