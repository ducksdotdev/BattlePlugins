@extends('layouts.master')
@section('content')
<div id="blog" data-id="{{ $blog->id }}">
    <div class="content-section-a">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>{{ $blog->title }}
                        <small>Written by <a href="/profile/{{ $author }}">{{ $author }}</a> {{ $ago }}</small></h2>
                </div>
            </div>
        </div>
    </div>
    <div class="content-section-b">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">{{ $blog->content }}</div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="fb-like" data-href="http://battleplugins.com/blog/{{ $blog->id }}" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div>
                </div>
            </div>
        </div>
    </div>
    @if($admin)
    <div class="content-section-a" id="edit">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Edit</h2>
                    <div id="alert"></div>
                    {{ Form::token() }}
                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Title" value="{{ $blog->title }}" />
                    </div>
                    <div class="form-group">
                        <div id="summernote">{{ $blog->content }}</div>
                    </div>
                    <button class="btn btn-primary" id="editArticle">Edit</button>
                    <button class="btn btn-danger pull-right" id="deleteArticle">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@stop
