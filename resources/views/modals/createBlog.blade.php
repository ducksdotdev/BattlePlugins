<!-- Create Blog Modal -->
<div id="createBlogModal" class="ui modal">
    <div class="header">
        Create Blog
    </div>
    <div class="content">
        <div class="description">
            {!! Form::open(['id'=>'createBlogForm','url'=>URL::to('/blog', [], true),'class'=>'ui form']) !!}
            <div class="twelve wide field">
                <label>Title</label>
                {!! Form::text('title', '', ['maxlength'=>64]) !!}
            </div>
            <div class="wide field">
                <label>Blog Content <small>Works with <a href="https://help.github.com/articles/github-flavored-markdown/" target="_blank">GitHub Flavored Markdown</a>. </small></label>
                {!! Form::textarea('content') !!}
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
            <button id="saveBlog" class="ui positive button" form="createBlogForm">
                Save Blog
            </button>
        </div>
    </div>
</div>
<!-- End Add Modal -->