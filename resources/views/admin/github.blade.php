@extends('admin.layouts.master')
@section('content')
    <div class="grid-70 grid-parent">
        <div class="grid-100">
            <h3>Events Feed</h3>
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
        </div>
    </div>
    <div class="grid-30 grid-parent">
        <div class="grid-100">
            <h3>Organization Members</h3>
        </div>
        <div class="grid-100 grid-parent">
            @foreach($members as $member)
                <div class="grid-50 bottom-margin ten">
                    <div class="ui segment text-center">
                        <div class="ui avatar image">
                            <a href="{{ $member->html_url }}"><img src="{{ $member->avatar_url }}"></a>
                        </div>
                        <div class="content">
                            <a class="header" href="{{ $member->html_url }}">{{ $member->login }}</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="grid-100">
            <h3>Repositories</h3>
        </div>
        <div class="grid-100 grid-parent">
            <div class="ui segment">
                @foreach($repos as $repo)
                    <div class="grid-50">
                        <div class="content">
                            <a class="header" href="{{ $repo->html_url }}">{{ $repo->name }}</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@stop