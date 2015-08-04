@extends('layouts.download')
@section('content')
    <div class="grid-70">
        <h2>
            Latest
            @if($current_job)
                {{ $current_job->getName() }}
            @endif
            Builds:
        </h2>
        @if($server_online)
            @if(count($stableBuilds) > 0)
                <table class="ui striped table">
                    <thead class="hide-on-mobile">
                    <tr>
                        <th>Build Number</th>
                        <th>Created</th>
                        <th>Downloads</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($stableBuilds as $build)
                        @include('download.partials.build')
                    @endforeach
                    </tbody>
                </table>
            @else
                <div class="ui message info">There are no builds!</div>
            @endif
        @else
            <div class="ui message negative">The download server is offline!</div>
        @endif
    </div>
    <div class="grid-30 grid-parent">
        <div class="grid-100">
            <h2>All Jobs:</h2>

            <div class="ui vertical menu">
                <a href="/" class="item @if(!$current_job) active @endif">All Jobs</a>
                @foreach($jobs as $job)
                    <a href="/job/{{ $job->getName() }}"
                       class="item @if ($current_job && $current_job->getName() == $job->getName()) active @endif">
                        {{ $job->getName() }}
                    </a>
                @endforeach
            </div>
        </div>
        @if($current_job && $server_online)
            <div class="grid-100">
                <h2>Job Status</h2>

                <div class="ui segment">
                    @if($stableBuilds)
                        <strong>Latest Build:</strong>

                        <div class="text-center top-margin ten bottom-margin">
                            <a href="{{ $stableBuilds[0]->getData()->url }}" class="ui button icon small labeled">
                                <i class="icon book"></i> Build Details
                            </a>
                            <a href="{{ $stableBuilds[0]->downloadPlugin() }}" class="ui button green labeled small icon">
                                <i class="icon download"></i> Download
                            </a>
                        </div>
                    @endif
                    @if($current_job->getData()->healthReport)
                        @foreach($current_job->getData()->healthReport as $report)
                            {{ $report->description }}
                        @endforeach
                    @else
                        <div class="text-center">
                            <strong>This job has never been built!</strong>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
@stop