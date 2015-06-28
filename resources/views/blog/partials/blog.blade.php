<div class="grid-container">
    <div class="grid-75 grid-parent" id="blog">
        @include('blog.partials.blogpost')
    </div>
    <div class="grid-25">
        <h4>Latest Blog Posts:</h4>
        <div id="latestBlogPosts" class="ui divided list">
            @foreach($list as $bp)
                @include('blog.partials.listitem')
            @endforeach
        </div>
    </div>
</div>
@if(Auth::check())
    @include('blog.modals.editBlog')
@endif