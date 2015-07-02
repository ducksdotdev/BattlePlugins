@extends('admin.layouts.master')
@section('content')
    <div class="grid-100">
        <h1>{{ $title }}</h1>
    </div>
    <div class="grid-60 grid-parent">
        <div class="grid-100">
            <h3>
                Server Status <br/>
                <small>Updated every {{ $updateMins }} minutes. Last
                    updated {{ $serverData['updated_at']->diffForHumans() }}.
                </small>
            </h3>
            <ul class="stats small">
                @foreach($serverData['servers'] as $server)
                    <li class="{{ $server['online'] ? 'green' : 'red' }}">
                        {{ ucfirst($server['name']) }}
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="grid-100">
            <h3>Tasks Overview</h3>
            <ul class="stats">
                <li class="yellow has-small">
                    {{ count($tasks->where('assigned_to', auth()->user()->id)->where('status', false)->get()) }}
                    <div class="small">Assigned to You</div>
                </li>
                <li class="yellow has-small">
                    {{ count($tasks->where('status', false)->get()) }}
                    <div class="small">Incomplete</div>
                </li>
                <li class="red has-small">
                    {{ count($tasks->where('status', false)->where('creator', 24)->get()) }}
                    <div class="small">GitHub Issues</div>
                </li>
                <li class="green has-small">
                    {{ count($tasks->where('status', true)->get()) }}
                    <div class="small">Completed</div>
                </li>
            </ul>
        </div>
        <div class="grid-100">
            <h3>Blog Overview</h3>
            <ul class="stats">
                <li class="has-small">
                    {{ count($blogs) }}
                    <div class="small">Blog Posts</div>
                </li>
                <li class="has-small">
                    {{ \App\Tools\Models\ServerSettings::whereKey('blogviews')->pluck('value')  }}
                    <div class="small">Page Hits</div>
                </li>
            </ul>
        </div>
    </div>
    <div class="grid-40 grid-parent">
        <div class="grid-100">
            <h3>Latest From the Blog</h3>

            <div class="ui middle aligned divided list segment">
                @foreach($blogList as $post)
                    <div class="item">
                        <div class="header">
                            <a href="{{ action('Blog\PageController@getBlog', ['id'=>$post->id]) }}">{{ $post->title }}</a>
                            <small>
                                Written by {{ $displaynames[$post->author] }} <span
                                        title="{{ $post->created_at }}">{{ $post->created_at->diffForHumans() }}</span>
                                @if($post->updated_at != $post->created_at)
                                    <span title="Edited {{ $post->updated_at->diffForHumans()
                                         }} ({{ $post->updated_at }})">*</span>
                                @endif
                            </small>
                        </div>
                        <div class="description">
                            {{ str_limit($post->content, 75) }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @if($jenkins)
            <div class="grid-100 grid-parent">
                <h3>Latest CI Builds</h3>
                @foreach($rssFeed as $item)
                    <div class="grid-100">
                        <div class="ui small message {{ str_contains($item->get_title(), 'broken') ? 'red' : 'green' }}">
                            <div class="header">
                                <a href="{{ $item->get_permalink()}}">{{ $item->get_title() }}</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@stop