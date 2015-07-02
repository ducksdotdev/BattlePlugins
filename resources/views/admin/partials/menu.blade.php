<div class="ui vertical inverted admin menu">
    <a href="/" class="item">Dashboard</a>
    <a href="/settings" class="item">User Settings</a>
    @if(Auth::user()->admin)
        <div class="item">
            <div class="header">User Management</div>
            <div class="menu">
                <a href="/user/create" class="item">Create User</a>
                <a href="/user/modify" class="item">Modify User</a>
            </div>
        </div>
    @endif
    <div class="item">
        <div class="header">Tools</div>
        <div class="menu">
            @if(Auth::user()->admin)
                <a href="/tools/alert" class="item">Create Alert</a>
            @endif
            <a href="/tools/cms" class="item">Content Management</a>
        </div>
    </div>
    <a href="/logout" class="item">Logout</a>
</div>