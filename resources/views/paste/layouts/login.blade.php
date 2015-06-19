<!DOCTYPE html>
<html lang="en">
<head>
    @include('paste.partials.head')
    <link rel="stylesheet" href="/assets/css/styles.css" type="text/css"/>
</head>
<body>
<nav>
    <div class="grid-container">
        <div class="brand grid-50 tablet-grid-50 mobile-grid-50">
            <h1>battlepaste</h1>
        </div>
        @if(Auth::check())
            <div class="grid-50 tablet-grid-50 mobile-grid-50 text-right">
                <a href="/logout" class="ui button primary">Logout</a>
            </div>
        @endif
    </div>
</nav>
@yield('content')
@include('footer')
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.12.2/semantic.min.js"></script>
<script type="text/javascript">
    $('.ui.accordion').accordion();
    $('.ui.sticky').sticky({
        context: '#docs'
    });
    $('.ui.checkbox').checkbox();
</script>
</body>
</html>