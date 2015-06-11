<!-- Edit Blog Modal -->
<div id="editBlogModal" class="ui modal">
    <div class="header">
        Edit Blog
    </div>
    <div class="content">
        <div class="description">
            {!! Form::open(['id'=>'editBlogForm','url'=>URL::to('/edit/'.$blog->id, [], env('HTTPS_ENABLED', true)),
            'class'=>'ui form']) !!}
            <div class="twelve wide field">
                <label>Title</label>
                {!! Form::text('title', $blog->title, ['maxlength'=>64]) !!}
            </div>
            <div class="wide field">
                <label>Blog Content <small>Works with <a href="https://help.github.com/articles/markdown-basics/" target="_blank">GitHub Flavored Markdown</a>. </small></label>
                {!! Form::textarea('content', $blog->content) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    <div class="actions text-center">
        <div class="ui buttons">
            <button class="ui button">
                Cancel
            </button>
            <div class="or"></div>
            <button id="saveBlog" class="ui positive button" form="editBlogForm">
                Save Blog
            </button>
        </div>
    </div>
</div>
<!-- End Add Modal -->