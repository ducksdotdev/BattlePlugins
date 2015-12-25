@extends('layouts.admin')
@section('content')
    {!! Form::open(['id'=>'createBlogForm','url'=>URL::to(action('AdminController@postCreateBlogPost'), [], env('HTTPS_ENABLED', true)),
                   'class'=>'ui form']) !!}
    <div class="grid-100">
        @if(count($errors) > 0)
            <div class="ui message negative">
                There was an error posting to the blog!
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
    <div class="grid-100">
        <label>Title</label>
        {!! Form::text('title', '', ['maxlength'=>64]) !!}
    </div>
    <div class="grid-100">
        <label>Blog Content
            <small>Works with <a href="https://help.github.com/articles/markdown-basics/" target="_blank">GitHub Flavored Markdown</a>.</small>
        </label>
        {!! Form::textarea('content') !!}
    </div>
    <div class="grid-100 text-right">
        <button id="saveBlog" class="ui positive button">Post</button>
    </div>
    {!! Form::close() !!}
@stop