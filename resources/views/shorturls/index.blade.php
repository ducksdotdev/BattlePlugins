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
            <div class="item">
                @if(session()->has('error'))
                    <div class="ui negative message">
                        <div class="content">
                            {{ session()->get('error') }}
                        </div>
                    </div>
                @elseif(session()->has('url_path'))
                    <div class="ui positive message text-center">
                        <a href="https://bplug.in/{{ session()->get('url_path') }}" class="short-link">
                            http://bplug.in/{{ session()->get('url_path') }}
                        </a>
                    </div>
                @endif
                {!! Form::open(['url'=>URL::to('/create', [], env('HTTPS_ENABLED', true)),'class'=>'ui form']) !!}
                <div class="fields">
                    <div class="thirteen wide field">
                        {!! Form::text('url', '', ['id'=>'url','placeholder'=>'URL to Shorten', 'autofocus'=>'autofocus']) !!}
                    </div>
                    <div class="text-right three wide field">
                        <button class="ui button green">Shorten URL</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
        @include('footer')
    </div>
</div>
</body>
</html>