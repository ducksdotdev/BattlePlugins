@if(is_array($value))
    <div class="item">
        <div class="header">
            {{ $name }}
        </div>
        <div class="menu">
            @foreach($value as $page => $location)
                <a href="{{ action($location) }}" class="item">{{ $page }}</a>
            @endforeach
        </div>
    </div>
@else
    <a href="{{ action($value) }}" class="item">{{ $name }}</a>
@endif