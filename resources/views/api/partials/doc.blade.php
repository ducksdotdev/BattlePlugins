<div class="grid-100 grid-parent" id="{{ $docType['name'] }}">
    <div class="grid-100">
        <h1>{{ $docType['name'] }}</h1>
    </div>
    @foreach($docType['methods'] as $doc)
        <div class="grid-100" id="{{ $doc['title'] }}">
            <h2 id="{{ $docType['name'] }}-{{ $doc['title'] }}">
                {{ $doc['title'] }}
                <p>
                    @foreach($doc['methods'] as $method)
                        <span class="ui horizontal label {{ $method['color'] }}">{{ strtoupper($method['name']) }}</span>
                    @endforeach
                </p>
            </h2>
            <p>{{ $doc['description'] }}</p>

            <p><strong>URL: </strong><code>/{{env('API_VERSION')}}/{{ $doc['url']}}</code></p>
            @if(array_has($doc, 'params'))
                <strong>Params:</strong>
                <p>
                    @foreach($doc['params'] as $param)
                        <span class="ui horizontal label {{strpos($param,'REQUIRED') ? 'red' : 'black'}}">{{ $param }}</span>
                    @endforeach
                </p>
            @endif
        </div>
        @include('api.partials.example')
    @endforeach
</div>