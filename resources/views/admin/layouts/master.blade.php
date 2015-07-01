<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} :: BattlePlugins Administration Panel</title>
    <link rel="icon" href="/assets/img/bp.png"/>

    <!--        Styles -->
    <link rel="stylesheet" href="/assets/css/semantic.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.12.0/components/icon.min.css"/>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.12.0/components/menu.min.css"/>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/unsemantic/0/unsemantic-grid-responsive.css">
    <link rel="stylesheet" href="/assets/css/styles.css" type="text/css"/>
    <!--        End Styles -->
    <!--        Scripts -->
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.12.2/semantic.min.js"></script>
    <!--       End Scripts -->
</head>
<body class="black">
<nav>
    <div class="grid-container">
        <div class="grid-100">
            <h1 class="brand"><a href="/">battleadmin</a></h1>
        </div>
    </div>
</nav>
@include('admin.partials.menu')
<div class="body">
    <div class="grid-container">
        <div class="grid-100 grid-parent">
            @yield('content')
        </div>
        <div class="grid-100">
            @include('footer')
        </div>
    </div>
</div>
<script type="text/javascript">
    $('.ui.checkbox').checkbox();
</script>
</body>
</html>