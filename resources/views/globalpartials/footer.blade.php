<footer>
    <ul>
        <li>
            <a href="{{ action('BlogController@getIndex') }}"><i class="icon home large"></i><br/> Homepage</a>
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
            <a href="{{ action('DownloadController@getIndex') }}"><i class="icon download large"></i><br/> Download</a>
        </li>
    </ul>
    <p>
        <a href="{{ action('VoiceController@getIndex') }}">TeamSpeak</a>
        | <a href="{{ action('ApiController@getIndex') }}">BattleWebAPI</a>
        | <a href="{{ action('PasteController@getIndex') }}">BattlePaste</a>
        @if(Auth::check())
            <br/>@if(UserSettings::hasNode(auth()->user(), UserSettings::ADMIN_PANEL))
                <a href="{{ action('AdminController@getIndex') }}">BattleAdmin</a> |
            @endif
            @if(UserSettings::hasNode(auth()->user(), UserSettings::DEVELOPER))
                <a href="{{ action('AdminController@getLogs') }}">Log Viewer</a> |
            @endif
            <a href="{{ action('Auth\UserController@getSettings') }}">Your Settings</a>
            | <a href="{{ action('Auth\AuthController@getLogout') }}">Logout</a>
        @elseif(Settings::get('registration'))
            <br/><a href="{{ action('Auth\AuthController@getLogin') }}">Login</a>
            | <a href="{{ action('Auth\AuthController@getRegister') }}">Register</a>
        @endif
    </p>

    <p>
        Copyright &copy; 2012 - {{ date('Y') }} BattlePlugins. All Rights Reserved. BattlePlugins is not affiliated with Mojang or Minecraft.
    </p>
</footer>