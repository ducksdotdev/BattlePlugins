@extends('api.layouts.master')
@section('content')
    <div id="header">
        <div class="grid-container">
            <div class="grid-100">
                <h2>API Documentation (BattleWebAPI {{env('API_VERSION')}}) <button id="manageWebhooks" class="ui small button default">Manage Webhooks</button></h2>
                <p>Your API key is <strong>{{ $apiKey }}</strong>. Please do not share this key with anyone. It allows other users or servers to act on your behalf. If your key is compromised, you can <a href="/generateKey">generate a new one</a>.</p>
                <p><a href="https://github.com/alkarinv/BattlePluginsAPI/blob/master/src/java/mc/battleplugins/api/BattlePluginsAPI.java" target="_blank">You can also use our BattlePluginsAPI in your plugins in order to make post requests, pastes, and use our statistics for your plugins.</a></p>
            </div>
            <div class="grid-100" id="authentication">
                <h3>Authentication</h3>
                <p>Please use the X-API-Key header for all requests. If you cannot, use the _key get parameter. An example request:</p>
                <pre>GET /v1/tasks HTTP/1.1<br/>Host: api.battleplugins.com<br/>X-API-Key: {{ $apiKey }}</pre>
                <h4>OR</h4>
                <pre>GET https://api.battleplugins.com/v1/tasks?_key={{ $apiKey }} HTTP/1.1</pre>
            </div>
        </div>
    </div>
    <div class="grid-container" id="docs">
        <div class="grid-75 grid-parent">
            @foreach($docs as $docType)
                <div class="grid-100 grid-parent" id="{{ $docType['name'] }}">
                    <h1>{{ $docType['name'] }}</h1>
                    @foreach($docType['methods'] as $doc)
                        <div class="grid-100" id="{{ $doc['title'] }}">
                            <h2 id="{{ $docType['name'] }}-{{ $doc['title'] }}">
                                {{ $doc['title'] }}
                                <p>
                                    @foreach($doc['methods'] as $method)
                                        <span class="ui horizontal label {{ $method['color'] }}">
                                            {{ strtoupper($method['name']) }}
                                        </span>
                                    @endforeach
                                </p>
                            </h2>
                            <p>{{ $doc['description'] }}</p>
                            <p><strong>URL: </strong><code>/{{env('API_VERSION')}}/{{ $doc['url']}}</code></p>
                            @if(array_has($doc, 'params'))
                                <p>
                                    <strong>Params:</strong>
                                <p>
                                    @foreach($doc['params'] as $param)
                                        <span class="ui horizontal label {{strpos($param,'REQUIRED') ? 'red' : 'black'}}">{{ $param }}</span>
                                    @endforeach
                                </p>
                                </p>
                            @endif
                            @if(array_has($doc, 'example'))
                                <div class="ui segment">
                                    <div class="grid-50">
                                        <strong>Success:</strong>
                                        <pre>{{ \App\Tools\Misc\JsonTools::jsonToReadable($doc['example']['success']) }}</pre>
                                    </div>
                                    <div class="grid-50">
                                        <strong>Error:</strong>
                                        <pre>{{ \App\Tools\Misc\JsonTools::jsonToReadable($doc['example']['error']) }}</pre>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
        <div class="grid-25 hide-on-mobile hide-on-tablet ui sticky">
            <div class="ui styled fluid accordion">
                <div class="title">
                    <i class="dropdown icon"></i> API Documentation
                </div>
                <div class="content">
                    <p>
                        <a href="#header"> Top</a>
                    </p>
                    <p>
                        <a href="#authentication"> Authentication</a>
                    </p>
                </div>
                @foreach($docs as $docType)
                    <div class="title">
                        <i class="dropdown icon"></i> {{ ucfirst($docType['name']) }}
                    </div>
                    <div class="content">
                        @foreach($docType['methods'] as $doc)
                            <p>
                                <a href="#{{ $docType['name'] }}-{{ $doc['title'] }}">{{ $doc['title'] }}</a>
                            </p>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @include('modals.webhooks')
@stop