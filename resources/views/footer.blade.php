@if(ServerSetting::get('footer'))
    <footer>
        <p>
            <a href="{{ action('Blog\PageController@index') }}">Home</a>
            | <a href="http://wiki.battleplugins.com">Wiki</a>
            | <a href="http://ci.battleplugins.com">Jenkins</a>
            | <a href="http://github.com/BattlePlugins">GitHub</a>
            | <a href="{{ action('Download\PageController@index') }}">Download</a>
            | <a href="{{ action('Voice\PageController@index') }}">TeamSpeak</a>
            <br/>
            <a href="{{ action('Tasks\PageController@index') }}">BattleTasks</a>
            | <a href="{{ action('API\PageController@index') }}">BattleWebAPI</a>
            | <a href="{{ action('Paste\PageController@index') }}">BattlePaste</a>
            | <a href="{{ action('ShortUrls\PageController@index') }}">bplug.in</a>
            @if(Auth::check())
                <br/>
                <a href="{{ action('Admin\PageController@index') }}">BattleAdmin</a>
                | <a href="{{ action('Admin\PageController@logs') }}">Log Viewer</a>
                | <a href="{{ action('Auth\AuthController@getLogout') }}">Logout</a>
            @endif
        </p>

        <p>
            Copyright &copy; 2012 - {{ date('Y') }} BattlePlugins. All Rights Reserved.<br/>
            BattlePlugins is not affiliated with Mojang or Minecraft.
        </p>
    </footer>
@endif