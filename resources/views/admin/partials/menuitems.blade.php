<div class="brand item">
  <h1>
    <a href="{{ action('AdminController@getIndex') }}">battleadmin</a>
  </h1>
</div>

@foreach(config('admin-pages') as $name => $value)
  @if(!array_has($value, 'action'))
    <div class="item top-level">
      <div class="header">
        {{ $name }}
      </div>
      <div class="menu">
        @foreach($value as $page => $values)
          @if(!array_has($values, 'node') || UserSettings::hasNode(auth()->user(), $values['node']))
            <a href="{{ action($values['action']) }}" class="item">{{ $page }}</a>
          @endif
        @endforeach
      </div>
    </div>
  @else
    @if(!array_has($value, 'node') || UserSettings::hasNode(auth()->user(), $value['node']))
      <a href="{{ action($value['action']) }}" class="item">{{ $name }}</a>
    @endif
  @endif
@endforeach