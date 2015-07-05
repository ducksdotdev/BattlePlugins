<a href="http://github.com/{{ $item->actor->login }}">
    {{ $item->actor->login }}
</a> commented on issue <a href="{{ $item->payload->issue->html_url }}">{{ $item->payload->issue->title }}</a>