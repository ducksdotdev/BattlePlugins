<div class="ui vertical inverted admin menu">
    <a href="/" class="item">Home</a>
    <a href="/settings" class="item">User Settings</a>
    @if(Auth::user()->admin)
        <div class="item">
            <div class="header">User Management</div>
            <div class="menu">
                <a href="/user/create" class="item">Create User</a>
                <a href="/user/modify" class="item">Modify User</a>
            </div>
        </div>
        <div class="item">
            <div class="header">Tools</div>
            <div class="menu">
                <a href="/tools/alert" class="item">Create Alert</a>
            </div>
        </div>
    @endif
    <a href="/logout" class="item">Logout</a>
</div>