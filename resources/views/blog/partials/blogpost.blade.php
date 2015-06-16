<div class="item">
    <div class="content">
        <div class="grid-85">
            <h1>
                {{ $blog->title }}
                <small class="author">
                    Written by {{ $author }} <span
                            title="{{ $blog->created_at }}">{{ $blog->created_at->diffForHumans() }}</span>
                    @if($blog->updated_at != $blog->created_at)
                        <span title="Edited {{ $blog->updated_at->diffForHumans()
                                         }} ({{ $blog->updated_at }})">*</span>
                    @endif
                </small>
            </h1>
        </div>
        <div class="grid-15">
            @if(Auth::check())
                <button id="editBlog" class="circular black ui icon button">
                    <i class="icon pencil"></i>
                </button>
                <a id="delete" href="/delete/{{ $blog->id }}" class="circular red ui icon button">
                    <i class="icon trash"></i>
                </a>
            @else
                &nbsp;
            @endif
        </div>
        <div class="grid-100">
            <div class="description">
                <p>
                    {!! Markdown::convertToHTML(strip_tags($blog->content)) !!}
                </p>
            </div>
        </div>
    </div>
</div>