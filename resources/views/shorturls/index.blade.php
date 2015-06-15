<!DOCTYPE html>
<html lang="en" ng-app="BattleTasks">
<head>
    @include('shorturls.partials.head')
    <link rel="stylesheet" href="/assets/css/styles.css" type="text/css"/>
</head>
<body>
<div class="grid-100 text-right">
    <a id="logoutButton" href="/logout" class="ui button">Logout</a>
</div>
<div class="grid-container">
    <div class="grid-65 grid-parent grid-center">
        <div id="task-header">
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
                        <a href="https://bplug.in/{{ session()->get('url_path') }}" class="link">
                            https://bplug.in/{{ session()->get('url_path') }}
                        </a>
                    </div>
                @endif
                {!! Form::open(['url'=>URL::to('/create', [], env('HTTPS_ENABLED', true)),'class'=>'ui form']) !!}
                <div class="fields">
                    <div class="thirteen wide field">
                        {!! Form::text('url', '', ['id'=>'url','placeholder'=>'URL to Shorten']) !!}
                    </div>
                    <div class="text-right three wide field">
                        <button class="ui button green">Shorten URL</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
        @include('shorturls.partials.footer')
    </div>
</div>
</body>
</html>