<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    @include('mobilecolor')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BattlePlugins :: Download Center</title>
    <link rel="icon" href="/assets/img/bp.png"/>

    <!--        Styles -->
    <link rel="stylesheet" href="/assets/css/styles.css" type="text/css"/>
    <link rel="stylesheet" href="/assets/css/semantic.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.12.0/components/icon.css"/>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/unsemantic/0/unsemantic-grid-responsive.css">
    <!--        End Styles -->
    <!--        Scripts -->
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.12.2/semantic.min.js"></script>
    <script type="text/javascript" src="/assets/js/blog/scripts.js"></script>
    <!--       End Scripts -->
</head>
<body>
@if(!Auth::check())
    @include('blog.partials.login')
@endif
<nav>
    <div class="grid-container">
        <div class="grid-90">
            <h1 class="brand"><a href="/">battleplugins</a></h1>
        </div>
        <div class="grid-10">
            @if(!Auth::check())
                <button id="loginDropDownButton" class="ui button primary">Login</button>
            @endif
        </div>
    </div>
</nav>
<div class="grid-container">
    <div class="grid-100">
        <div class="ui message warning">
            <h3>NOTICE: Not all of these builds are stable!</h3>
            Most of the files listed bellow are developer builds and are not meant to be run on live servers as they
            have not been tested in depth. Only builds labeled <span class="ui label blue">Stable</span> have been
            tested and approved.
        </div>
    </div>
    <div class="grid-70">
        <h2>
            Latest
            @if($current_job)
                {{ $current_job->name }}
            @endif
            Builds:
        </h2>
        @if(count($stableBuilds) > 0)
            <table class="ui striped table">
                <thead>
                <tr>
                    <th>Build Number</th>
                    <th>Created</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($stableBuilds as $build)
                    <tr @if(!$production->find($build->timestamp)) class="warning" @endif>
                        <td>
                            @if($production->find($build->timestamp))
                                <span class="ui label blue">Stable</span>
                            @endif
                            <span class="ui label">{{ $build->changeSet->kind }}</span> {{ $build->fullDisplayName }}
                        </td>
                        <td>{{ Carbon::createFromTimestampUTC(str_limit($build->timestamp, 10))->diffForHumans() }}</td>
                        <td class="text-right">
                            <a href="{{ $build->url }}" class="ui button mini icon labeled"><i class="icon book"></i>
                                Build Details</a>
                            <a href="{{ $build->url }}artifact/{{ $build->artifacts{0}->relativePath }}.jar"
                               class="ui button green mini labeled icon"><i class="icon download"></i> Download</a>
                            @if(auth()->check())
                                {!! Form::open(['url'=>URL::to('/job/' . $build->timestamp .'/production', [],
                                env('HTTPS_ENABLED', true)), 'class'=>'inline']) !!}
                                @if($production->find($build->timestamp))
                                    <button class="ui button mini red">Unmark Stable</button>
                                @else
                                    <button class="ui button mini primary">Mark Stable</button>
                                @endif
                                {!! Form::close() !!}
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <div class="ui message info">There are no builds!</div>
        @endif
    </div>
    <div class="grid-30 grid-parent">
        <div class="grid-100">
            <h2>All Jobs:</h2>

            <div class="ui vertical menu">
                <a href="/" class="item @if(!$current_job) active @endif">All Jobs</a>
                @foreach($jobs as $job)
                    <a href="/job/{{ $job->name }}"
                       class="item @if ($current_job && $current_job->name == $job->name) active @endif">
                        {{ $job->name }}
                    </a>
                @endforeach
            </div>
        </div>
        @if($current_job)
            <div class="grid-100">
                <h2>Job Status</h2>

                <div class="ui segment">
                    @if($current_job->lastStableBuild)
                        <strong>Latest Stable Build:</strong>

                        <div class="text-center top-margin ten bottom-margin">
                            <a href="{{ $current_job->lastStableBuild->url }}" class="ui button icon labeled"><i class="icon book"></i> Build Details</a>
                            <a href="{{ $current_job->lastStableBuild->url }}artifact/target/{{ $current_job->name }}.jar"
                               class="ui button green labeled icon"><i class="icon download"></i> Download</a>
                        </div>
                    @endif
                    @if($current_job->healthReport)
                        {{ $current_job->healthReport{0}->description }}
                    @else
                        <div class="text-center">
                            <strong>This job has never been built!</strong>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
@include('footer')
</body>
</html>