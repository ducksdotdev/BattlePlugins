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
        @if(Auth::check())
            <div class="grid-50 tablet-grid-50 mobile-grid-50 text-right">
                <a href="/logout" class="ui button primary">Logout</a>
            </div>
        @endif
    </div>
</nav>
@yield('content')
@include('footer')
</body>
</html>