<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BattlePlugins :: Minecraft Plugin Development Team</title>
    <link rel="icon" href="/assets/img/bp.png" />

    <!--        Styles -->
    <link rel="stylesheet" href="/assets/css/styles.css" type="text/css"/>
    <link rel="stylesheet" href="/assets/css/semantic.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.12.0/components/icon.css" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/unsemantic/0/unsemantic-grid-responsive.css">
    <!--        End Styles -->
    <!--        Scripts -->
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.12.2/semantic.min.js"></script>
    <script type="text/javascript" src="/assets/js/blog/scripts.js"></script>
    <!--       End Scripts -->
</head>
<body>
@if(!Auth::check())
    @include('blog.partials.login')
@endif
<nav>
    <div class="grid-container">
        <div class="grid-50">
            <h1 class="brand">battleplugins</h1>
        </div>
        <div class="grid-40">
            <ul>
                <li><a href="http://ci.battleplugins.com">Jenkins</a></li>
                <li><a href="http://wiki.battleplugins.com">Wiki</a></li>
                <li><a href="http://github.com/BattlePlugins">Github</a></li>
            </ul>
        </div>
        <div class="grid-10 text-right">
            @if(Auth::check())
                <button id="createBlog" class="circular small ui positive icon button">
                    <i class="icon plus"></i>
                </button>
            @else
                <div id="loginDropDownButton" class="ui button primary">Login</div>
            @endif
        </div>
    </div>
</nav>
{{--<div class="grid-container">--}}
{{--<div class="ui items">--}}
{{--<div class="grid-25">--}}
{{--<div class="ui segment">--}}
{{--<div class="item">--}}
{{--<div class="content">--}}
{{--<span class="header">BattleArena v1.2.3 <small class="version-update">Updated 2 hours ago.</small></span>--}}
{{--<div class="description">--}}
{{--<p>BattleArena has just been updated to version 1.2.3. Download the latest version from <a href="#">Jenkins</a>.</p>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--<div class="grid-25">--}}
{{--<div class="ui segment">--}}
{{--<div class="item">--}}
{{--<div class="content">--}}
{{--<span class="header">BattleArena v1.2.3</span>--}}
{{--<div class="description">--}}
{{--<p>BattleArena has just been updated to version 1.2.3. Download the latest version from <a href="#">Jenkins</a>.</p>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--<div class="grid-25">--}}
{{--<div class="ui segment">--}}
{{--<div class="item">--}}
{{--<div class="content">--}}
{{--<span class="header">BattleArena v1.2.3</span>--}}
{{--<div class="description">--}}
{{--<p>BattleArena has just been updated to version 1.2.3. Download the latest version from <a href="#">Jenkins</a>.</p>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--<div class="grid-25">--}}
{{--<div class="ui segment">--}}
{{--<div class="item">--}}
{{--<div class="content">--}}
{{--<span class="header">BattleArena v1.2.3</span>--}}
{{--<div class="description">--}}
{{--<p>BattleArena has just been updated to version 1.2.3. Download the latest version from <a href="#">Jenkins</a>.</p>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
@if($blog)
    <div class="grid-container">
        <div class="grid-75 grid-parent" id="blog">
            @include('blog.partials.blogpost')
        </div>
        <div class="grid-25">
            <h4>Latest Blog Posts:</h4>
            <div id="latestBlogPosts" class="ui divided list">
                @foreach($list as $bp)
                    @include('blog.partials.listitem')
                @endforeach
            </div>
        </div>
    </div>
@endif
@if(Auth::check())
    @include('blog.modals.createBlog')
    @if($blog)
        @include('blog.modals.editBlog')
    @endif
@endif
<footer>
    <p>
        <a href="http://ci.battleplugins.com">Jenkins</a> | <a href="http://wiki.battleplugins.com">Wiki</a> | <a href="http://github.com/BattlePlugins">GitHub</a> | <a href="http://tasks.battleplugins.com">BattleTasks</a> | <a href="http://api.battleplugins.com">BattleWebAPI</a>
        @if(Auth::check())
            | <a href="/logout">Logout</a>
        @endif
        <br/>
        Copyright &copy; BattlePlugins. All Rights Reserved.<br/>
        BattlePlugins is not affiliated with Mojang or Minecraft.
    </p>
</footer>
@if(session()->has('error'))
    <script type="text/javascript">
        $("#login").sidebar({duration: 0}).sidebar('toggle')
    </script>
@endif
</body>
</html>