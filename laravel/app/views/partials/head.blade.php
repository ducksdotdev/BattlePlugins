<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="author" content="lDucks">
@if($dev)
<title>{{ $title }} :: BattlePlugins-DEV</title>
@else
<title>{{ $title }} :: BattlePlugins</title>
@endif
<link rel="icon" type="image/png" href="/assets/img/favicon.png" />

<!-- Styles -->
@if($dev && !Config::get('deploy.minify-develop'))
<link type="text/css" rel="stylesheet" href="/assets/css/style.css">
@else
<link type="text/css" rel="stylesheet" href="/assets/css/style.min.css">
@endif
<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet">
<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">
<link href="//cdnjs.cloudflare.com/ajax/libs/animate.css/3.0.0/animate.min.css" rel="stylesheet">
@yield('extraStyles')
