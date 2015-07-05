<div class="grid-100">
    <h3>BattlePlugins GitHub Feed <a href="http://github.com/BattlePlugins"><i class="icon external"></i></a></h3>
</div>
<div class="grid-100">
    @foreach($github as $item)
        <div class="ui message">
            <a href="http://github.com/{{ $item->actor->login }}">{{ $item->actor->login }}</a> {{ \App\Tools\Misc\GitHub::convertEvent($item->type). 'ed' }} {{ count($item->payload->commits) }}
            commits to {{ $item->payload->ref }}
            <ul>
                @foreach($item->payload->commits as $commit)
                    <li>{{ str_limit($commit->message, 40) }} <a
                                href="https://github.com/{{ $item->repo->name }}/tree/{{ $commit->sha }}">({{ str_limit($commit->sha, 7) }})</a></li>
                @endforeach
            </ul>
        </div>
    @endforeach
</div>