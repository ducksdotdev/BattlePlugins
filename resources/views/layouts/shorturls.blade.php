<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    @include('globalpartials.mobilecolor')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bplug.in :: BattlePlugins URL Shortener</title>
    <link rel="icon" href="/assets/img/bp.png"/>
    <!--        Styles -->
    <link rel="stylesheet" href="/assets/css/semantic.css">
    <link rel="stylesheet" href="/assets/css/styles.css" type="text/css"/>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.12.0/components/icon.min.css"/>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/unsemantic/0/unsemantic-grid-responsive.css">
    <!--        End Styles -->
    <script>
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

        ga('create', 'UA-66072914-6', 'auto');
        ga('send', 'pageview');

    </script>
    @include('globalpartials.globalanalytics')
</head>
<body>
<div class="grid-container">
    <div class="grid-65 grid-parent grid-center">
        <div class="task-header">
            <div class="grid-container">
                <div class="grid-100">
                    <h2>bplug.in</h2>
                </div>
            </div>
        </div>
        <div class="ui divided list">
            @yield('content')
        </div>
        @include('globalpartials.footer')
    </div>
</div>
</body>
</html>