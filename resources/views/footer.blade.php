<footer>
    <p>
        <a href="http://ci.battleplugins.com">Jenkins</a> | <a href="http://wiki.battleplugins.com">Wiki</a> | <a
                href="http://github.com/BattlePlugins">GitHub</a> | <a
                href="http://tasks.battleplugins.com">BattleTasks</a> | <a href="http://api.battleplugins.com">BattleWebAPI</a>
        |
        <a href="http://bplug.in">bplug.in</a>
        @if(Auth::check())
            <a href="https://admin.battleplugins.com/">User Settings</a>
            | <a href="/logs">Log Viewer</a>
            | <a href="/logout">Logout</a>
        @endif
        <br/>
        Copyright &copy; BattlePlugins. All Rights Reserved.<br/>
        BattlePlugins is not affiliated with Mojang or Minecraft.
    </p>
</footer>