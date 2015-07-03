<h3>Latest From the Blog <a href="{{ action('Blog\PageController@index') }}"><i class="icon external"></i></a></h3>

<div class="ui middle aligned divided list segment">
    @foreach($blogList as $post)
        <div class="item">
            <div class="header">
                <a href="{{ action('Blog\PageController@getBlog', ['id'=>$post->id]) }}">{{ $post->title }}</a>
                <small>
                    Written by {{ $displaynames[$post->author] }} <span
                            title="{{ $post->created_at }}">{{ $post->created_at->diffForHumans() }}</span>
                    @if($post->updated_at != $post->created_at)
                        <span title="Edited {{ $post->updated_at->diffForHumans()
                                         }} ({{ $post->updated_at }})">*</span>
                    @endif
                </small>
            </div>
            <div class="description">
                {{ str_limit($post->content, 75) }}
            </div>
        </div>
    @endforeach
</div>