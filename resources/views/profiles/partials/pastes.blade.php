<div class="grid-100">
    <h3>Pastes ({{ count($user->pastes()->wherePublic(true)->get()) }})</h3>
</div>
@foreach($user->pastes()->wherePublic(true)->get() as $paste)
    <div class="grid-100">
        <div class="ui segment">
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
                Created <span title="{{ $paste->created_at }}">{{ $paste->created_at->diffForHumans() }}</span>.<br/>
                @if($paste->created_at != $paste->updated_at)
                    Last modified <span title="{{ $paste->updated_at }}">{{ $paste->updated_at->diffForHumans() }}</span>.
                @endif
            </div>
        </div>
    </div>
@endforeach