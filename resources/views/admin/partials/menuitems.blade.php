<a href="/" class="item">Dashboard</a>

<div class="item">
    <div class="header">User Management</div>
    <div class="menu">
        <a href="/settings" class="item">User Settings</a>
        @if(Auth::user()->admin)
            <a href="/user/create" class="item">Create User</a>
            <a href="/user/modify" class="item">Modify User</a>
        @endif
    </div>
</div>
<div class="item">
    <div class="header">Tools</div>
    <div class="menu">
        @if(Auth::user()->admin)
            <a href="/tools/alert" class="item">Create Alert</a>
        @endif
        <a href="/tools/cms" class="item">Manage Content</a>
    </div>
</div>
<a href="/logout" class="item">
    <img src="{{ $avatar }}" class="ui mini avatar image"> <span>Logout</span>
</a>