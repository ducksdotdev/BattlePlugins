@extends('layouts.master')
@section('content')
<div class="content-section-a">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2>Welcome to BattlePlugins!</h2>
                BattlePlugins is dedicated to providing the best experience to it's users. Since February 2012, BattlePlugins ran by lDucks and alkarin_v. We pride ourselves on the dedication of our staff and community members. We have {{ count($plugins) }} Bukkit plugins that have hundreds of thousands of combined downloads. Our website alone has over 170,000 hits per month. BattlePlugins has grown exponentially since founded. We're currently working hard on expanding our features both on the plugins we create and our website.
            </div>
        </div>
    </div>
</div>
<div class="content-section-b">
    <div class="container">
        @if(count($blog) == 0)
        <div class="row">
            <div class="col-lg-12">
                <h3>There are no blog posts! :(</h3>
            </div>
        </div>
        @else
        <div class="row">
            <div class="col-lg-12">
                <h3><a href="/blog/{{ $blog->id }}">{{ $blog->title }}</a> <small>Written by <a href="/profile/{{ $author }}">{{ $author }}</a> {{ $ago }}</small></h3>
                <hr />
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">{{ $blog->content }}</div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="fb-like" data-href="http://battleplugins.com/blog/{{ $blog->id }}" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div>
            </div>
        </div>
        @endif
    </div>
</div>
<div class="content-section-a">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3>Latest Plugin Updates <small><a href="/plugins">Click here to view them all</a></small></h3>
            </div>
        </div>
        <div class="row">
            @foreach($builds as $build)
            <div class="col-lg-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <a href="{{ $build['bukkit'] }}"><span class="panel-title">{{ $build['name'] }}</span> <i class="fa fa-external-link"></i></a>
                    </div>
                    <div class="panel-body">
                        Created by: {{ $authors[$build['author']] }}<br />
                        Last Successful Build: <a href="{{ $build['ci']['url'] }}">{{ $build['ci']['build'] }}</a><br />
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@stop
