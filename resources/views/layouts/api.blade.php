<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('mobilecolor')
    <title>BattleWebAPI :: Website API for BattlePlugins</title>
    <link rel="icon" href="/assets/img/api.png"/>
    <!--        Styles -->
    <link rel="stylesheet" href="/assets/css/styles.css" type="text/css"/>
    <link rel="stylesheet" href="/assets/css/semantic.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.12.0/components/icon.min.css"/>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/unsemantic/0/unsemantic-grid-responsive.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.12.2/components/accordion.min.css">
    <!--        End Styles -->
</head>
<body>
<nav class="header-follow">
    <div class="grid-container">
        <div class="grid-100 brand">
            <h1>battlewebapi</h1>
        </div>
    </div>
</nav>
@yield('content')
@include('footer')
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.12.2/semantic.min.js"></script>
<script type="text/javascript" src="/assets/js/scripts.js"></script>
<script type="text/javascript">
    $('.accordion').accordion();
    $('.ui.sticky').sticky({context: '#docs'});
</script>
@yield('extraScripts')
</body>
</html>