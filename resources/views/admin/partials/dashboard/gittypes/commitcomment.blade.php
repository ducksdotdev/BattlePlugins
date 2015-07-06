<a href="http://github.com/{{ $item->actor->login }}">{{ $item->actor->login }}</a> commented on commit <a
        href="{{ $item->payload->comment->html_url }}">{{ str_limit($item->payload->comment->commit_id, 7) }}</a>:
<p>{!! Markdown::convertToHTML(strip_tags($item->payload->comment->body)) !!}</p>