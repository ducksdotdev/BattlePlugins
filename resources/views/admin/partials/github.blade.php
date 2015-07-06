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
                    @elseif($item->type == 'CommitCommentEvent')
                        @include('admin.partials.dashboard.gittypes.commitcomment')
                    @endif
                </div>
            </div>
        </div>
    </div>
@endforeach