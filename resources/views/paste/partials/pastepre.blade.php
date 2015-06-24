@include('paste.partials.actions')
<div class="grid-100">
    <small>{{ strlen($content) }}/{{ env("PASTE_MAX_LEN", 500000) }} characters. {{ $lines }} lines.</small>
    <div class="paste">
        @if($lang != 'txt')
            <div class="ui top attached blue label">{{ $lang }}</div>
        @endif
        <pre class="prettyprint linenums lang-{{ $lang }}">{{ $content }}</pre>
    </div>
    <small>{{ strlen($content) }}/{{ env("PASTE_MAX_LEN", 500000) }} characters. {{ $lines }} lines.</small>
</div>
@include('paste.partials.actions')