@if(Settings::get('footer'))
    <footer>
        <ul>
            <li>
                <a href="{{ action('Blog\PageController@index') }}"><i class="icon home large"></i><br/> Homepage</a>
            </li>
            <li>
                <a href="http://wiki.battleplugins.com"><i class="icon book large"></i><br/> BattleWiki</a>
            </li>
            <li>
                <a href="http://ci.battleplugins.com"><i class="icon server large"></i><br/> Jenkins CI</a>
            </li>
            <li>
                <a href="http://github.com/BattlePlugins"><i class="icon github large"></i><br/> GitHub</a>
            </li>
            <li>
                <a href="{{ action('Download\PageController@index') }}"><i class="icon download large"></i><br/> Download</a>
            </li>
        </ul>
        <p>
            <a href="{{ action('Voice\PageController@index') }}">TeamSpeak</a>
            | <a href="{{ action('Tasks\PageController@index') }}">BattleTasks</a>
            | <a href="{{ action('API\PageController@index') }}">BattleWebAPI</a>
            | <a href="{{ action('Paste\PageController@index') }}">BattlePaste</a>
            | <a href="{{ action('ShortUrls\PageController@index') }}">bplug.in</a>
            @if(Auth::check())
                | @if(\App\Tools\Misc\UserSettings::hasNode(auth()->user(), \App\Tools\Misc\UserSettings::ADMIN_PANEL))
                    <a href="{{ action('Admin\PageController@index') }}">BattleAdmin</a> |
                @endif
                @if(\App\Tools\Misc\UserSettings::hasNode(auth()->user(), \App\Tools\Misc\UserSettings::DEVELOPER))
                    <a href="{{ action('Admin\PageController@logs') }}">Log Viewer</a> |
                @endif
                <a href="{{ action('Auth\UserController@getSettings') }}">Your Settings</a>
                | <a href="{{ action('Auth\AuthController@getLogout') }}">Logout</a>
            @elseif(\App\Tools\Misc\Settings::get('registration'))
                <br/><a href="{{ action('Auth\AuthController@getLogin') }}">Login</a>
                | <a href="{{ action('Auth\AuthController@getRegister') }}">Register</a>
            @endif
        </p>

        <p>
            Copyright &copy; 2012 - {{ date('Y') }} BattlePlugins. All Rights Reserved. BattlePlugins is not affiliated with Mojang or Minecraft.
        </p>
    </footer>
@endif