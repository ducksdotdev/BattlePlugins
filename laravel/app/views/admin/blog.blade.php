@extends('layouts.master')
@section('content')
<div class="content-section-a">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2>Create Blog Post</h2>
                <p>You are able to edit a blog post by viewing the blog post's page. You will not be able to edit the blog post from here. <a href="/blog#edit">Want to edit the most recent blog post? Click here.</a></p>
            </div>
        </div>
    </div>
</div>
<div class="content-section-b">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div id="alert"></div>
                {{ Form::token() }}
                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Title" />
                </div>
                <div class="form-group">
                    <div id="summernote"></div>
                </div>
                <button class="btn btn-primary" id="submitArticle">Submit</button>
            </div>
        </div>
    </div>
</div>
@stop
