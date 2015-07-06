<div class="grid-100">
    <h3>BattlePlugins GitHub Feed <a href="http://github.com/BattlePlugins"><i class="icon external"></i></a></h3>
</div>
<div class="grid-100">
    @foreach($github as $item)
        <div class="ui feed segment">
            <div class="event">
                <div class="label">
                    <a href="http://github.com/{{ $item->actor->login }}">
                        <img src="{{ $item->actor->avatar_url }}">
                    </a>
                </div>
                <div class="content">
                    <div class="date">
                        {{ (new \Carbon\Carbon($item->created_at))->diffForHumans() }}
                    </div>
                    <div class="summary">
                        @if($item->type == 'PushEvent')
                            @include('admin.partials.dashboard.gittypes.push')
                        @elseif($item->type == 'IssueCommentEvent')
                            @include('admin.partials.dashboard.gittypes.issuecomment')
                        @elseif($item->type == 'IssuesEvent')
                            @include('admin.partials.dashboard.gittypes.issues')
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <div class="pull-right">
        <a href="/github">More...</a>
    </div>
</div>