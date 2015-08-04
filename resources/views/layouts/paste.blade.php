<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/assets/img/bp.png"/>
    <!--        Styles -->
    <link rel="stylesheet" href="/assets/css/styles.css">
    <link rel="stylesheet" href="/assets/css/semantic.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.12.0/components/icon.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/unsemantic/0/unsemantic-grid-responsive.css">
    @yield('extraStyles')
    <!--        End Styles -->
    <!--        Scripts -->
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.12.2/semantic.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/autosize.js/1.18.18/jquery.autosize.min.js"></script>
    <script type="text/javascript" src="/assets/js/paste/prettify.js"></script>
    <script type="text/javascript" src="/assets/js/scripts.js"></script>
    @yield('extraScripts')
    <!--        End Scripts -->
    
    <title>
        @if($paste->title)
            {{ $paste->title }}
        @else
            {{ $paste->slug }}
        @endif
        :: BattlePaste
    </title>
    <link rel="stylesheet" href="/assets/css/styles.css" type="text/css"/>
</head>
<body onload="prettyPrint()">
<nav>
    <div class="grid-container">
        <div class="brand grid-50 tablet-grid-50 mobile-grid-50">
            <h1><a href="/">battlepaste</a></h1>
        </div>
        <div class="grid-50 tablet-grid-50 mobile-grid-50 text-right">
            @if(!Auth::check())
                <a href="/" class="ui button primary">Login</a>
            @endif
        </div>
    </div>
</nav>
@yield('content')
@include('footer')
</body>
</html>