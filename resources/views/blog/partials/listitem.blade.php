<div class="item">
    <div class="content">
        <a href="/{{ $bp->id }}-{{ str_slug($bp->title) }}" class="header">{{ $bp->title }}</a>

        <div class="description">
            <small>
                Written by {{ $bp->user->displayname }} <span title="{{ $bp->created_at }}">{{ $bp->created_at->diffForHumans() }}</span>
                @if($bp->updated_at != $bp->created_at)
                    <span title="Edited {{ $bp->updated_at->diffForHumans() }} ({{ $bp->updated_at }})">*</span>
                @endif
            </small>
        </div>
    </div>
</div>