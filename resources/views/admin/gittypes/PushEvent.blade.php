<a href="http://github.com/{{ $item->actor->login }}">
    {{ $item->actor->login }}
</a>
pushed {{ count($item->payload->commits) }} commits to
<a href="http://github.com/{{ $item->repo->name }}{{ str_replace('refs/heads', '/tree', $item->payload->ref) }}">{{ $item->repo->name }}{{ str_replace('refs/heads', '', $item->payload->ref) }}</a>
<ul>
    @foreach($item->payload->commits as $commit)
        <li>
            {{ str_limit($commit->message, 40) }}
            <a href="https://github.com/{{ $item->repo->name }}/tree/{{ $commit->sha }}">
                ({{ str_limit($commit->sha, 7) }})
            </a>
        </li>
    @endforeach
</ul>