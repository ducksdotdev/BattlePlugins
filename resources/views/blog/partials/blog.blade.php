<div class="grid-container">
    <div class="grid-75 grid-parent" id="blog">
        <div class="grid-85">
            <h1>
                {{ $blog->title }}
                <small class="author">
                    Written by {{ $users[$blog->author] }} <span
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
                {!! Form::open(['url'=>URL::to('/delete/'.$blog->id, [], env('HTTPS_ENABLED', true)),
                'class'=>'inline']) !!}
                <button id="delete" href="" class="circular red ui icon button"><i class="icon trash"></i></button>
                {!! Form::close() !!}
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
        @if($comment_feed)
            <div class="grid-100">
                <div id="disqus_thread"></div>
                <script type="text/javascript">
                    /* * * CONFIGURATION VARIABLES * * */
                    var disqus_shortname = 'battleplugins';
                    var disqus_identifier = 'blog{{ $blog->id }}';

                    /* * * DON'T EDIT BELOW THIS LINE * * */
                    (function () {
                        var dsq = document.createElement('script');
                        dsq.type = 'text/javascript';
                        dsq.async = true;
                        dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
                        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
                    })();
                </script>
                <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript"
                                                                  rel="nofollow">comments powered by Disqus.</a>
                </noscript>
            </div>
        @endif
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