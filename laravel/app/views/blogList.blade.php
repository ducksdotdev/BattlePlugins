@extends('layouts.master')
@section('content')
<div class="content-section-a">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2>All Blog Posts <small>({{ count($blog) }})</small></h2>
            </div>
        </div>
    </div>
</div>
<div class="content-section-b">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="list-group">
                    @foreach($blog as $post)
                    <a href="/blog/{{ $post->id }}" class="list-group-item">
                        <h4 class="list-group-item-heading">{{ $post->title }} <small>Written by {{ $authors[$post->id] }} {{ $ago[$post->id] }}</small></h4>
                        <p class="list-group-item-text">{{ substr(strip_tags($post->content), 0, 250) }}... <small>click for more</small></p>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@stop
