<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BattleWebAPI :: Website API for BattlePlugins</title>
    <link rel="icon" href="/assets/img/api.png"/>
    @include('api.partials.styles')
</head>
<body>
<nav class="header-follow">
    <div class="grid-container">
        <div class="grid-50 tablet-grid-50 mobile-grid-50 brand">
            <h1>battlewebapi</h1>
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
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.12.2/semantic.min.js"></script>
<script type="text/javascript">
    $('.ui.checkbox').checkbox();
</script>
@yield('extraScripts')
</body>
</html>