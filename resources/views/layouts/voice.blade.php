<!DOCTYPE html>
<html lang="en" ng-app="BattleTeamSpeak">
<head>
    <meta charset="utf-8">
    @include('globalpartials.mobilecolor')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TeamSpeak :: BattlePlugins Voice Chat</title>
    <link rel="icon" href="/assets/img/bp.png"/>
    <!--        Styles -->
    <link rel="stylesheet" href="/assets/css/semantic.css">
    <link rel="stylesheet" href="/assets/css/styles.css" type="text/css"/>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.12.0/components/icon.min.css"/>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/unsemantic/0/unsemantic-grid-responsive.css">
    <!--        End Styles -->
    <!--        Scripts -->
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/angular.js/1.3.11/angular.min.js"></script>
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

        ga('create', 'UA-66072914-8', 'auto');
        ga('send', 'pageview');

    </script>
            <!--        End Scripts -->
    <style>
        .query {
            display: none;
        }
    </style>
</head>
<body>
<div class="grid-container">
    <div class="grid-65 grid-parent grid-center">
        <div class="task-header">
            <div class="grid-container">
                <div class="grid-85 tablet-grid-85 mobile-grid-85">
                    <h2>teamspeak</h2>
                </div>
                <div class="grid-15 tablet-grid-15 mobile-grid-15 text-right text-middle actions">
                    <a href="ts3://voice.battleplugins.com" class="circular small ui primary icon button"><i
                                class="icon forward mail"></i></a>
                </div>
            </div>
        </div>
        @yield('content')
        @include('globalpartials.footer')
    </div>
</div>
</body>
</html>