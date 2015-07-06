<h3>General Overview</h3>
<ul class="stats">
    <li class="has-small">
        {{ $pastes }}
        <div class="small">Pastes</div>
    </li>
    <li class="has-small">
        {{ $urls }}
        <div class="small">Short URLs</div>
    </li>
    <li class="has-small">
        {{ $blogs }}
        <div class="small">Blog Posts</div>
    </li>
    <li class="has-small @if($hitChange > 0) green @endif">
        {{ $hits  }} ({{ $hitChange }})
        <div class="small">Blog Hits</div>
    </li>
</ul>