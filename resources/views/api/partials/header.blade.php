<div id="header">
    <div class="grid-container">
        <div class="grid-100">
            <h2>API Documentation (BattleWebAPI {{env('API_VERSION')}})
                <button id="manageWebhooks" class="ui small button default">Manage Webhooks</button>
            </h2>
            Your API key is <strong>{{ $apiKey }}</strong>. Please do not share this key with anyone. It allows other users or servers to act on your behalf. If your key is
            compromised, you can
            {!! Form::open(['url'=>URL::to('/generateKey', [], env('HTTPS_ENABLED', true)), 'class'=>'inline']) !!}
            <button class="ui button link">generate a new one.</button>
            {!! Form::close() !!}

            <p class="top-margin ten">
                <a href="https://github.com/BattlePlugins/BattleWebApi.java">Use BattleWebAPI.java in your plugins in order to make a connection to the API for your
                    plugins.</a>
            </p>
        </div>
        <div class="grid-100" id="authentication">
            <h3>Authentication</h3>

            <p>Please use the X-API-Key header for all requests. If you cannot, use the _key get parameter. An example request:</p>
            <pre>GET /{{env('API_VERSION')}}/tasks HTTP/1.1<br/>Host: {{ action('API\PageController@index') }}<br/>X-API-Key: {{ $apiKey }}</pre>
            <h4>OR</h4>
            <pre>GET {{ action('API\PageController@index') }}/v1/tasks?_key={{ $apiKey }} HTTP/1.1</pre>
        </div>
    </div>
</div>