@extends('admin.layouts.master')
@section('content')
    <div class="grid-100">
        <h2>{{ $title }}</h2>
    </div>
    @if(count($alerts) > 0)
        <div class="grid-100">
            <h3>Alerts ({{ count($alerts) }})</h3>
            @foreach($alerts as $alert)
                <div class="ui message {{ $alert->color }}">
                    <a href="/tools/alert/delete/{{ $alert->id }}">
                        <i class="icon remove pull-right"></i>
                    </a>
                    <strong>Posted {{ $alert->created_at->diffForHumans() }}</strong>

                    <p>
                        {{ $alert->content }}
                    </p>
                </div>
            @endforeach
        </div>
    @endif
    <div class="grid-100 grid-parent">
        <h3>Overview</h3>

        <div class="grid-50">
            <h2>BattlePlugins Websites</h2>
            <ul>
                <li>There are <a href="http://tasks.battleplugins.com/">{{ $tasks }} tasks</a> yet to be completed.
                </li>
                <li>The <a href="https://battleplugins.com/{{ $blog->id }}">last blog post</a> was created {{ $blog->created_at->diffForHumans() }}</li>
            </ul>
        </div>
        <div class="grid-50">
            <h2>Queue Information</h2>
            Queued Jobs: {{ $queuedJobs }}<br/>
            Failed Jobs: {{ $failedJobs }}
        </div>
    </div>
@stop