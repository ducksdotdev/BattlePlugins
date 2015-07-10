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
        <div class="grid-100">
            <h1 class="brand"><a href="/">battleplugins downloads</a></h1>
        </div>
    </div>
</nav>
<div class="grid-container">
    <div class="grid-100">
        <div class="ui message warning">
            <h3>These are not supported downloads!</h3>
            These downloads are created from every change pushed to GitHub, which means these downloads may be unstable or cause problems. Unless you have been
            instructed to use these downloads, please use a stable version.
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
        <table class="ui striped table">
            <tbody>
            @if($current_job)
                @foreach($stableBuilds as $build)
                    <tr>
                        <td><span class="ui label">{{ $build->changeSet->kind }}</span> {{ $build->fullDisplayName }}</td>
                        <td class="text-right">
                            <a href="{{ $build->url }}" class="ui button mini">Build Details</a>
                            <a href="{{ $build->url }}artifact/target/{{ $current_job->name }}.jar" class="ui button green mini">Download</a>
                        </td>
                    </tr>
                @endforeach
            @else
                @foreach($latestBuilds as $name => $build)
                    <tr>
                        <td><span class="ui label">{{ $build->changeSet->kind }}</span> {{ $build->fullDisplayName }}</td>
                        <td class="text-right">
                            <a href="{{ $build->url }}" class="ui button mini">Build Details</a>
                            <a href="{{ $build->url }}artifact/target/{{ $name }}.jar" class="ui button green mini">Download</a>
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
    <div class="grid-30 grid-parent">
        <div class="grid-100">
            <h2>All Jobs:</h2>

            <div class="ui vertical menu">
                <a href="/" class="item @if(!$current_job) active @endif">All Jobs</a>
                @foreach($jobs as $job)
                    @if(array_key_exists($job->name, $latestBuilds))
                        <a href="/{{ $job->name }}" class="item @if ($current_job && $current_job->name == $job->name) active @endif">
                            {{ $job->name }}
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
        @if($current_job)
            <div class="grid-100">
                <h2>Project Status</h2>

                <div class="ui segment">
                    @if($current_job->lastStableBuild)
                        <strong>Latest Stable Build:</strong>

                        <div class="text-center top-margin ten bottom-margin">
                            <a href="{{ $current_job->lastStableBuild->url }}" class="ui button">Build Details</a>
                            <a href="{{ $current_job->lastStableBuild->url }}artifact/target/{{ $current_job->name }}.jar" class="ui button green">Download</a>
                        </div>
                    @endif
                    @if($current_job->healthReport)
                        {{ $current_job->healthReport{0}->description }}
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
@include('footer')
</body>
</html>