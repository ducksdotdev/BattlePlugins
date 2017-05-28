<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    @include('globalpartials.mobilecolor')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User System :: BattlePlugins</title>
    <link rel="icon" href="/assets/img/bp.png"/>
    <!--        Styles -->
    <link rel="stylesheet" href="/assets/css/semantic.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/unsemantic/0/unsemantic-grid-responsive.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.12.2/components/accordion.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.12.2/components/icon.min.css">
    <link rel="stylesheet" href="/assets/css/styles.css" type="text/css"/>
    <!--        End Styles -->
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.12.2/semantic.min.js"></script>
    <script type="text/javascript" src="/assets/js/scripts.js"></script>
</head>
<body>
<div class="grid-container">
    <div class="grid-65 grid-parent grid-center">
        <div class="task-header">
            <div class="grid-container">
                <div class="grid-100">
                    <h2><a href="{{ action('BlogController@getIndex') }}">battleplugins</a></h2>
                </div>
            </div>
        </div>
        <div class="ui divided list">
            <div class="item">
                @yield('content')
            </div>
        </div>
        @include('globalpartials.footer')
    </div>
</div>
</body>
</html>