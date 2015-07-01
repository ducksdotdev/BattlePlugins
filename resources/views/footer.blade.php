<footer>
    <p>
        <a href="http://battleplugins.com">Home</a> | <a href="http://wiki.battleplugins.com">Wiki</a> | <a
                href="http://ci.battleplugins.com">Jenkins</a> | <a
                href="http://github.com/BattlePlugins">GitHub</a><br/>
        <a href="http://tasks.battleplugins.com">BattleTasks</a> | <a
                href="http://api.battleplugins.com">BattleWebAPI</a>
        | <a href="http://paste.battleplugins.com">BattlePaste</a> | <a href="http://bplug.in">bplug.in</a>
        @if(Auth::check())
            <br/>
            <a href="https://admin.battleplugins.com/">BattleAdmin</a>
            | <a href="/logs">Log Viewer</a>
            | <a href="/logout">Logout</a>
        @endif
    </p>
    <p>
        Copyright &copy; 2012 - {{ date('Y') }} BattlePlugins. All Rights Reserved.<br/>
        BattlePlugins is not affiliated with Mojang or Minecraft.
    </p>
</footer>
