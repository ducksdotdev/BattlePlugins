@extends('layouts.master')
@section('content')
<div class="content-section-a">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2>API Documentation</h2>
                <p>Your API key is <strong>{{ $apiKey }}</strong>. Please do not share this key with anyone. It allows other users or servers to act on your behalf. If your key is compromised, you can <a href="/api/generateKey">generate a new one</a>.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <h3>Limitations</h3>
                <p>You are only able to make one API request per {{ $timeout }} second(s) in order to decrease traffic, and all requests are logged. If you make a request within the timeout period, you will get a response containing exactly how long you must wait.</p>
                <p><strong>Example:</strong></p>
                <pre>{<br/>   "result": "failure",<br/>   "reason": "You may not make any requests until 57 seconds from now"<br/>   "timestamp": 1392261110<br/>}</pre>
                <small>** The timestamp represents the end of the timeout, NOT the time of the request. **</small>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <h4>Lowering Limitations</h4>
                <p>In order to lower the limitations to your account, you must contact <a href="/profile/lDucks">lDucks</a> on <a href="http://webchat.esper.net/?nick=&channels=battleplugins">IRC</a>. Explain what your project is and why it needs to send more requests. The limitations are in place in order to lower the number of requests being made to our servers. The server we are using would not be able to take large amounts of requests at once. These limitations can be easily edited with valid reason.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <h3>Authentication</h3>
                <p>Please use the X-API-Key header for all requests. If you cannot, use the _key get parameter. An example request:</p>
                <pre>GET /api/web/blog/all HTTP/1.1<br/>Host: battleplugins.com<br/>X-API-Key: {{ $apiKey }}</pre>
                <h4 class="text-center">OR</h4>
                <pre>GET /api/web/blog/all?_key={{ $apiKey }} HTTP/1.1</pre>
            </div>
        </div>
    </div>
</div>
<div class="content-section-b">
    <div class="container">
        @foreach($docs as $docType)
        <h1>{{ $docType['name'] }}</h1>
        @foreach($docType as $doc)
        @if(count(array_intersect($doc['group'], $userGroups)) > 0)
        <div class="row" id="{{ $doc['title'] }}">
            <div class="col-lg-12">
                <hr />
                <h3>{{ $doc['title'] }} @foreach($doc['methods'] as $method)<span class="label label-{{ $method['color'] }}">{{ strtoupper($method['name']) }}</span> @endforeach</h3>
                <p>{{ $doc['description'] }}</p>
                <p><strong>URL: </strong><code>{{ $doc['url']}}</code></p>
                @if(is_array($doc['params']))
                <p><strong>Post Params:</strong> @foreach($doc['params'] as $param)<span class="label label-@if(strpos($param,'REQUIRED')) label-danger @else label-default @endif">{{ $param }}</span> @endforeach</p>
                @endif
                @if(strlen($doc['example']) > 0)
                <p><strong>Example Output:</strong></p>
                <pre>{{{ $doc['example'] }}}</pre>
                @endif
            </div>
        </div>
        @endif
        @endforeach
        @endforeach
    </div>
</div>
@stop
