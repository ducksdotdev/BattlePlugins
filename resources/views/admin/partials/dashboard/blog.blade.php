<h3>Blog Overview <a href="{{ action('Blog\PageController@index') }}"><i class="icon external"></i></a></h3>
<ul class="stats">
    <li class="has-small">
        {{ count($blogs) }}
        <div class="small">Blog Posts</div>
    </li>
    <li class="has-small">
        {{ $hits  }}
        @if($hitChange > 0)
            <small class="green">(+{{ $hitChange }})</small>
        @else
            <small>({{ $hitChange }})</small>
        @endif
        <div class="small">Page Hits</div>
    </li>
</ul>