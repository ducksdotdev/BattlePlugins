@if(array_has($doc, 'example'))
    <div class="grid-50">
        <strong>Success:</strong>
        <pre>{{ \App\Tools\Misc\JsonTools::jsonToReadable($doc['example']['success']) }}</pre>
    </div>
    <div class="grid-50">
        <strong>Error:</strong>
        <pre>{{ \App\Tools\Misc\JsonTools::jsonToReadable($doc['example']['error']) }}</pre>
    </div>
@endif