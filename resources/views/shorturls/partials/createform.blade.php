<div class="ui divided list">
    <div class="item">
        @if(isset($error))
            <div class="ui negative message">
                <div class="content">
                    {{ $error }}
                </div>
            </div>
        @elseif(isset($url_path))
            <div class="ui positive message text-center">
                <a href="https://bplug.in/{{ $url_path }}" class="short-link">
                    http://bplug.in/{{ $url_path }}
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