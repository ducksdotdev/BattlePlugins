
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BattlePlugins :: Minecraft Plugin Development Team</title>
    <link rel="icon" href="favicon.png" />

    <!--        Styles -->
    <link rel="stylesheet" href="/assets/css/styles.css" type="text/css"/>
    <link rel="stylesheet" href="/assets/css/semantic.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.12.0/components/icon.css" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/unsemantic/0/unsemantic-grid-responsive.css">
    <!--        End Styles -->
</head>
<body>
@include('partials.login')
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
            <div id="loginDropDownButton" class="ui button primary">Login</div>
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
<div class="grid-container">
    <div class="grid-75" id="blog">
        <div class="item">
            <div class="content">
                <h1>
                    New Blog! <small class="author">Written by Zach443.</small>
                </h1>
                <div class="description">
                    <p>
                        Hey guys, this is our new blog/website! I will be posting things like development tutorials, progress/dev updates on all of the BattlePlugins, as well as any other information about BattlePlugins here. All kinds of exciting things will be coming out of this blog. Aside from the blog, this site will contain links to all BattlePlugins' resources, such as the wiki, GitHub, and Jenkins. Above this post there will be boxes that will show all the most recent updates to our plugins. Enjoy the new site!
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="grid-25">
        <h4>Latest Blog Posts:</h4>
        <div id="latestBlogPosts" class="ui divided list">
            <div class="item">
                <div class="content">
                    <a class="header">New Blog!</a>
                    <div class="description">Hey guys, this is our new blog/website! I will be posting things like...</div>
                </div>
            </div>
        </div>
    </div>
</div>
<footer>
    <p>
        <a href="http://ci.battleplugins.com">Jenkins</a> | <a href="http://wiki.battleplugins.com">Wiki</a> | <a href="http://github.com/BattlePlugins">GitHub</a> | <a href="http://tasks.battleplugins.com">BattleTasks</a> | <a href="http://api.battleplugins.com">BattleWebAPI</a><br/>
        Copyright &copy; BattlePlugins. All Rights Reserved.<br/>
        BattlePlugins is not affiliated with Mojang or Minecraft.
    </p>
</footer>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.12.2/semantic.min.js"></script>
<script type="text/javascript" src="/assets/js/scripts.js"></script>
@if(session()->has('error'))
    <script type="text/javascript">
        $("#login").sidebar({duration: 0}).sidebar('toggle')
    </script>
@endif
</body>
</html>