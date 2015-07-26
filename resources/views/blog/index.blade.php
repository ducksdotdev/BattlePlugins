<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    @include('mobilecolor')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BattlePlugins :: Minecraft Plugin Development Team</title>
    <link rel="icon" href="/assets/img/bp.png"/>

    <!--        Styles -->
    <link rel="stylesheet" href="/assets/css/styles.css" type="text/css"/>
    <link rel="stylesheet" href="/assets/css/semantic.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.12.0/components/icon.css"/>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/unsemantic/0/unsemantic-grid-responsive.css">
    <!--        End Styles -->
    <!--        Scripts -->
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.12.2/semantic.min.js"></script>
    <script type="text/javascript" src="/assets/js/blog/scripts.js"></script>
    <script type="text/javascript" src="/assets/js/scripts.js"></script>
    <!--       End Scripts -->
</head>
<body>
<nav>
    <div class="grid-container">
        <div class="grid-30 tablet-grid-100 mobile-grid-100">
            <h1 class="brand"><a href="/">battleplugins</a></h1>
        </div>
        <div class="grid-60 tablet-grid-100 mobile-grid-100">
            <ul>
                <li><a href="{{ action('Download\PageController@index') }}">Get Plugins</a></li>
                <li><a href="http://ci.battleplugins.com">Jenkins</a></li>
                <li><a href="http://wiki.battleplugins.com">Wiki</a></li>
                <li><a href="http://github.com/BattlePlugins">Github</a></li>
            </ul>
        </div>
        <div class="grid-10 tablet-grid-100 mobile-grid-100">
            @if(Auth::check())
                <button id="createBlog" class="circular small ui positive icon button">
                    <i class="icon plus"></i>
                </button>
            @else
                <a href="/auth/login" class="ui button primary">Login</a>
            @endif
        </div>
    </div>
</nav>
@include('blog.partials.jenkins')
@if(isset($blog))
    @include('blog.partials.blog')
@endif
@if(Auth::check())
    @include('blog.modals.createBlog')
@endif
@include('footer')
</body>
</html>