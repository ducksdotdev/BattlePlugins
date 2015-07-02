@extends('admin.layouts.master')
@section('content')
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
    <div class="grid-100 grid-parent text-center">
        <h3>Server Status</h3>
        <small>Updated every 30 minutes.</small>
        <ul class="serverstats">
            @foreach($serverData as $server)
                @if($server['online'])
                    <li class="green">
                        {{ strtoupper($server['name']) }}
                    </li>
                @else
                    <li class="red">
                        {{ strtoupper($server['name']) }}
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
    <div class="grid-100 grid-parent">
        <div class="grid-50">
            <h3>BattlePlugins Websites</h3>
            <ul>
                <li>There are <a href="http://tasks.battleplugins.com/">{{ $tasks }} incomplete tasks</a>.
                </li>
                <li>The <a href="https://battleplugins.com/{{ $blog->id }}">last blog post</a> was
                    created {{ $blog->created_at->diffForHumans() }}.
                </li>
            </ul>
        </div>
        <div class="grid-50">
            <h3>Queue Information</h3>
            Queued Jobs: {{ $queuedJobs }}<br/>
            Failed Jobs: {{ $failedJobs }}
        </div>
    </div>
@stop