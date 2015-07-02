<h3>Blog Overview</h3>
<ul class="stats">
    <li class="has-small">
        {{ count($blogs) }}
        <div class="small">Blog Posts</div>
    </li>
    <li class="has-small">
        {{ \App\Tools\Models\ServerSettings::whereKey('blogviews')->pluck('value')  }}
        <div class="small">Page Hits</div>
    </li>
</ul>