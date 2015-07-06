<div class="brand item">
    <h1>
        <a href="{{ action('Admin\PageController@index') }}">battleadmin</a>
    </h1>
</div>

@foreach(config('admin_pages.all') as $name => $value)
    @include('admin.partials.menuitem')
@endforeach
@foreach(config('admin_pages.admin') as $name => $value)
    @include('admin.partials.menuitem')
@endforeach

<div class="item">
    <div class="header">
        <img src="{{ $avatar }}" class="ui mini avatar image"> {{ auth()->user()->displayname}}
    </div>
    <div class="menu">
        <a href="{{ action('Admin\PageController@settings') }}" class="item">Settings</a>
        <a href="{{ action('UserController@logout') }}" class="item">Logout</a>
    </div>
</div>