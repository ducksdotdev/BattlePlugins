<a href="http://github.com/{{ $item->actor->login }}">{{ $item->actor->login }}</a> forked repo <a
        href="{{ $item->payload->forkee->html_url }}">{{ $item->payload->forkee->name }}</a>.