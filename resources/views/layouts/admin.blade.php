<!DOCTYPE html>
<html lang="en" ng-app="BattleAdmin">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('globalpartials.mobilecolor')
    <title>{{ $title }} :: BattlePlugins Administration Panel</title>
    <link rel="icon" href="/assets/img/bp.png"/>

    <!--        Styles -->
    <link rel="stylesheet" href="/assets/css/semantic.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.12.0/components/icon.min.css"/>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/unsemantic/0/unsemantic-grid-responsive.css">
    <link rel="stylesheet" href="/assets/css/styles.css" type="text/css"/>
    <!--        End Styles -->
    <!--        Scripts -->
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.12.2/semantic.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/angular.js/1.4.1/angular.min.js"></script>
    <script type="text/javascript" src="/assets/js/admin/admin.js"></script>
    <script type="text/javascript" src="/assets/js/scripts.js"></script>
    @yield('extraScripts')
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

        ga('create', 'UA-66072914-2', 'auto');
        ga('send', 'pageview');
    </script>
            <!--       End Scripts -->
</head>
<body>
<div class="grid-100 grid-parent">
    @include('admin.partials.menu')
    <div class="grid-80 tablet-grid-100 mobile-grid-100 pull-right grid-parent">
        @include('admin.partials.alerts')
        <div class="titlebar">
            <div class="grid-container">
                <div class="grid-100">
                    <h1><i id="openMenu" class="icon sidebar pointer hide-on-desktop"></i> {{ $title }}</h1>
                </div>
            </div>
        </div>
        <div id="content" class="grid-container">
            @yield('content')
        </div>
        @include('globalpartials.footer')
    </div>
</div>
</body>
</html>