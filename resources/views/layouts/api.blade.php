<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('globalpartials.mobilecolor')
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
@include('globalpartials.footer')
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.12.2/semantic.min.js"></script>
<script type="text/javascript" src="/assets/js/scripts.js"></script>
<script type="text/javascript">
    $('.accordion').accordion();
    $('.ui.sticky').sticky({context: '#docs'});

    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
        a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

    ga('create', 'UA-66072914-3', 'auto');
    ga('send', 'pageview');

</script>
@include('globalpartials.globalanalytics')
@yield('extraScripts')
</body>
</html>