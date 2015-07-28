<div class="brand item">
    <h1>
        <a href="{{ action('Admin\PageController@index') }}">battleadmin</a>
    </h1>
</div>

@foreach(config('admin_pages') as $name => $value)
    @include('admin.partials.menuitem')
@endforeach

<div class="item">
    <div class="header">
        {{ auth()->user()->displayname }}
    </div>
    <div class="menu">
        <a href="{{ action('Admin\PageController@settings') }}" class="item">Settings</a>
        <a href="{{ action('Auth\AuthController@getLogout') }}" class="item">Logout</a>
    </div>
</div>