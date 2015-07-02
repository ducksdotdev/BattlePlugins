@extends('admin.layouts.master')
@section('content')
    @if(count($alerts) > 0)
        <div class="grid-100 alerts">
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
    <div class="grid-50 grid-parent">
        <h3>
            Server Status <br/>
            <small>Updated every 30 minutes.</small>
        </h3>
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
    <div class="grid-50 grid-parent">
        <div class="grid-100">
            <table class="ui celled table">
                <thead>
                <tr>
                    <th>BattlePlugins Websites</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>There are <a href="http://tasks.battleplugins.com/">{{ $tasks }} incomplete tasks</a>.</td>
                </tr>
                <tr>
                    <td>The <a href="https://battleplugins.com/{{ $blog->id }}">last blog post</a> was created {{ $blog->created_at->diffForHumans() }}.</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="grid-100">
            <table class="ui celled table">
                <thead>
                <tr>
                    <th>Queue Information</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Queued Jobs: {{ $queuedJobs }}</td>
                </tr>
                <tr>
                    <td>Failed Jobs: {{ $failedJobs }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@stop