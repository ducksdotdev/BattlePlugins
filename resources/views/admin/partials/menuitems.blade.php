<div class="brand item">
    <h1>
        <a href="/">battleadmin</a>
    </h1>
</div>

<a href="/" class="item">Dashboard</a>

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
        <a href="/tools/cms" class="item">Manage Content</a>
    </div>
</div>
<div class="item">
    <div class="header"><img src="{{ $avatar }}" class="ui mini avatar image"> {{ auth()->user()->displayname}}
    </div>
    <div class="menu">
        <a href="/settings" class="item">Settings</a>
        <a href="/logout" class="item">Logout</a>
    </div>
</div>