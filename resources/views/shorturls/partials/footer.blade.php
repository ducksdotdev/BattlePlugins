<footer>
    @if(Auth::check())
        <a href="https://admin.battleplugins.com/">User Settings</a>
        | <a href="/logs">Log Viewer</a>
        | <a href="/logout">Logout</a>

        <br/>
    @endif
    Copyright BattlePlugins 2015. All Rights Reserved.
</footer>