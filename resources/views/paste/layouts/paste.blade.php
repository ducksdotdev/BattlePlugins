<!DOCTYPE html>
<html lang="en">
<head>
    @include('paste.partials.head')
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