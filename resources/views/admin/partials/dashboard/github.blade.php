<div class="grid-100">
    <h3>BattlePlugins GitHub Feed <a href="http://github.com/BattlePlugins"><i class="icon external"></i></a></h3>
</div>
<div class="grid-100">
    @foreach($github as $item)
        <div class="ui feed segment">
            <div class="event">
                <div class="label">
                    <img src="{{ $item->actor->avatar_url }}">
                </div>
                <div class="content">
                    <div class="date">
                        {{ (new \Carbon\Carbon($item->created_at))->diffForHumans() }}
                    </div>
                    <div class="summary">
                        <a href="http://github.com/{{ $item->actor->login }}">
                            {{ $item->actor->login }}
                        </a>
                        {{ \App\Tools\Misc\GitHub::convertEvent($item->type). 'ed' }} {{ count($item->payload->commits) }} commits
                        to <a href="http://github.com/{{ $item->repo->name }}{{ str_replace('refs/heads', '/tree', $item->payload->ref) }}">{{ $item->repo->name }}{{ str_replace('refs/heads', '', $item->payload->ref) }}</a>
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
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>