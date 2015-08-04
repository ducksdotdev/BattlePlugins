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
    <script type="text/javascript" src="/assets/js/scripts.js"></script>
    <!--       End Scripts -->
</head>
<body>
<nav>
    <div class="grid-container">
        <div class="grid-90">
            <h1 class="brand"><a href="/">battleplugins</a></h1>
        </div>
        <div class="grid-10">
            @if(!Auth::check())
                <a href="{{ action('Auth\AuthController@getLogin') }}" class="ui button primary">Login</a>
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
    @yield('content')
</div>
@include('footer')
</body>
</html>