@extends('layouts.admin')
@section('content')
    <div class="grid-100">
        @if(count($posts) > 0)
            <table class="ui table">
                <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Time Posted</th>
                    @if(UserSettings::hasNode(auth()->user(), UserSettings::DELETE_BLOG))
                        <th width="20%">Actions</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                @foreach($posts as $post)
                    <tr>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->user->displayname }}</td>
                        <td>{{ $post->created_at->diffForHumans() }}</td>
                        <td>
                            <a href="{{ action('AdminController@getEditBlogPost', ['id'=>$post->id]) }}" class="ui button black mini">Edit Post</a>
                            @if(UserSettings::hasNode(auth()->user(), UserSettings::DELETE_BLOG))
                                {!! Form::open(['url'=>URL::to(action('AdminController@postDeleteBlogPost'), [], env('HTTPS_ENABLED', true)), 'class'=>'inline']) !!}
                                <button class="ui button red mini">Delete Post</button>
                                {!! Form::close() !!}
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <div class="ui message info">
                There are no blog posts.
            </div>
        @endif
    </div>
@stop