<a href="http://github.com/{{ $item->actor->login }}">
    {{ $item->actor->login }}
</a> {{ $item->payload->action }} issue <a href="{{ $item->payload->issue->html_url }}">{{ $item->payload->issue->title }}</a>.