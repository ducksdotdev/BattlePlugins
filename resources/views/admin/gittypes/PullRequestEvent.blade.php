<a href="http://github.com/{{ $item->actor->login }}">
    {{ $item->actor->login }}
</a> {{ $item->payload->action }} pull request <a href="{{ $item->payload->pull_request->html_url }}">{{ $item->payload->pull_request->title }}</a>.