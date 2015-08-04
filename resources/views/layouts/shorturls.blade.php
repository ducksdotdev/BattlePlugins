<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    @include('mobilecolor')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bplug.in :: BattlePlugins URL Shortener</title>
    <link rel="icon" href="/assets/img/bp.png"/>
    <!--        Styles -->
    <link rel="stylesheet" href="/assets/css/semantic.css">
    <link rel="stylesheet" href="/assets/css/styles.css" type="text/css"/>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.12.0/components/icon.min.css"/>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/unsemantic/0/unsemantic-grid-responsive.css">
    <!--        End Styles -->
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
        @include('footer')
    </div>
</div>
</body>
</html>