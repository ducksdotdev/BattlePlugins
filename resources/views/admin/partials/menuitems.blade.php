<div class="brand item">
    <h1>
        <a href="{{ action('AdminController@getIndex') }}">battleadmin</a>
    </h1>
</div>

@foreach(config('admin_pages') as $name => $value)
    @include('admin.partials.menuitem')
@endforeach