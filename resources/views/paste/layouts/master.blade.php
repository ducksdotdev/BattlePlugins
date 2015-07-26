<!DOCTYPE html>
<html lang="en">
<head>
    @include('mobilecolor')
    @include('paste.partials.head')
    <title>BattlePaste :: BattlePlugins Paste Service</title>
    <link rel="stylesheet" href="/assets/css/styles.css" type="text/css"/>
    <script type="text/javascript" src="/assets/js/scripts.js"></script>
</head>
<body>
@yield('content')
@include('footer')
</body>
</html>