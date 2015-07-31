@if($github)
    @foreach($github as $item)
        <div class="ui feed segment">
            <div class="event">
                <div class="label">
                    <a href="http://github.com/{{ $item->actor->login }}">
                        <img src="{{ $item->actor->avatar_url }}">
                    </a>
                </div>
                <div class="content">
                    <div class="date" title="{{ $item->created_at }}">
                        {{ $item->created_at->diffForHumans() }}
                    </div>
                    <div class="summary">
                        @include('admin.partials.dashboard.gittypes.'.$item->type)
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="ui message negative text-center">
        <strong>We can't connect GitHub's api!</strong>
    </div>
@endif