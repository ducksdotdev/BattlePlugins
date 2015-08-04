@extends('layouts.blog')
@section('content')
    @include('blog.partials.jenkins')
    @if(isset($blog))
        <div class="grid-container">
            <div class="grid-75 grid-parent" id="blog">
                <div class="grid-100 grid-parent">
                    <div class="grid-85">
                        <h1>
                            {{ $blog->title }}
                            <small class="author">
                                Written by {{ $blog->user->displayname }} <span title="{{ $blog->created_at }}">{{ $blog->created_at->diffForHumans() }}</span>
                                @if($blog->updated_at != $blog->created_at)
                                    <span title="Edited {{ $blog->updated_at->diffForHumans() }} ({{ $blog->updated_at }})">*</span>
                                @endif
                            </small>
                        </h1>
                    </div>
                    <div class="grid-15">
                        @if(auth()->check())
                            @if(\App\Tools\Misc\UserSettings::hasNode(auth()->user(), \App\Tools\Misc\UserSettings::MODIFY_BLOG))
                                <button id="editBlog" class="circular black ui icon button">
                                    <i class="icon pencil"></i>
                                </button>
                            @endif
                            @if(\App\Tools\Misc\UserSettings::hasNode(auth()->user(), \App\Tools\Misc\UserSettings::DELETE_BLOG))
                                {!! Form::open(['url'=>URL::to('/delete/'.$blog->id, [], env('HTTPS_ENABLED', true)),
                                'class'=>'inline']) !!}
                                <button id="delete" href="" class="circular red ui icon button"><i class="icon trash"></i></button>
                                {!! Form::close() !!}
                                &nbsp;
                            @endif
                        @endif
                    </div>
                </div>
                <div class="grid-100">{!! Markdown::convertToHTML(strip_tags($blog->content)) !!}</div>
                @if($comment_feed)
                    <div class="grid-100">
                        <div id="disqus_thread"></div>
                        <script type="text/javascript">
                            /* * * CONFIGURATION VARIABLES * * */
                            var disqus_shortname = 'battleplugins';
                            var disqus_title = '{{ $blog->title }}';
                            var disqus_url = '{{ action('BlogController@getIndex', ['id'=>$blog->id])  }}';

                            /* * * DON'T EDIT BELOW THIS LINE * * */
                            (function () {
                                var dsq = document.createElement('script');
                                dsq.type = 'text/javascript';
                                dsq.async = true;
                                dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
                                (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
                            })();
                        </script>
                        <noscript>
                            Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a>
                        </noscript>
                    </div>
                @endif
            </div>
            <div class="grid-25 ui sticky">
                <h4>Latest Blog Posts:</h4>

                <div id="latestBlogPosts" class="ui divided list">
                    @foreach($list as $bp)
                        <div class="item">
                            <div class="content">
                                <a href="/{{ $bp->id }}-{{ str_slug($bp->title) }}" class="header">{{ $bp->title }}</a>

                                <div class="description">
                                    <small>
                                        Written by {{ $bp->user->displayname }} <span title="{{ $bp->created_at }}">{{ $bp->created_at->diffForHumans() }}</span>
                                        @if($bp->updated_at != $bp->created_at)
                                            <span title="Edited {{ $bp->updated_at->diffForHumans() }} ({{ $bp->updated_at }})">*</span>
                                        @endif
                                    </small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @if(Auth::check())
            @include('blog.modals.editBlog')
        @endif
    @endif
@stop