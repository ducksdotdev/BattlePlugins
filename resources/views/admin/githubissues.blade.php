@extends('layouts.admin')
@section('content')
    <div class="grid-100 text-right">
        <a href="{{ action('AdminController@getGithub') }}" class="ui labeled icon button"><i class="ui icon reply"></i> Back</a>
    </div>
    <div class="grid-100">
        @if(!$gitIssues)
            <div class="ui message info">
                There are no tasks to show!
            </div>
        @else
            @foreach($gitIssues as $issue)
                <div class="ui segment">
                    <a href="{{ $issue->html_url }}"><i class="icon external"></i></a>
                    {{$issue->title}}
                    <small>Assigned
                        @if($issue->assignee)
                            to <span class="name">{{ $issue->assignee->login }}</span>
                        @endif
                        by <span class="name">{{ $issue->user->login }}</span> {{ (new \Carbon\Carbon($issue->created_at))->diffForHumans() }}
                    </small>
                    @if(count($issue->labels) > 0)
                        <p>
                            @foreach($issue->labels as $label)
                                <span class="ui label" style="background-color: #{{ $label->color }}">{{ $label->name }}</span>
                            @endforeach
                        </p>
                    @endif
                    {!! Markdown::convertToHTML(strip_tags($issue->body)) !!}
                </div>
            @endforeach
        @endif
    </div>
@stop