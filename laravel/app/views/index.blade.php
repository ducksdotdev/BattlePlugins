@extends('layouts.master')
@section('content')
<div class="content-section-index hidden-xs">
    <div class="row text-center">
        <div class="col-md-2 col-md-offset-2">
            <i class="fa fa-cogs service-icon"></i>
            <h3>Development</h3>
            <p>Looking for a plugin? Need player statistics? What about administration tools? BattlePlugins has created and released <a href="/plugins">{{ count($plugins) }} plugins</a> for multiple purposes since February 2012.</p>
        </div>
        <div class="col-md-2">
            <i class="fa fa-question service-icon"></i>
            <h3>Support</h3>
            <p>BattlePlugins was built on the idea that support for our users is extremely important. We try and answer any questions you may have about our services or Bukkit in general. We provide support through our Bukkit plugin pages, GitHub, or IRC. Why not <a href="http://webchat.esper.net/?nick=&channels=battleplugins">chat with us</a>?</p>
        </div>
        <div class="col-md-2">
            <i class="fa fa-pencil service-icon"></i>
            <h3>Tools</h3>
            <p>We have created many different tools for the public to use. We have our own API that allows for anyone to hook into our website and use our services from anywhere. To access these amazing features, all you need to do is <a href="/register">sign up</a>!</p>
        </div>
        <div class="col-md-2">
            <i class="fa fa-users service-icon"></i>
            <h3>Dedication</h3>
            <p>BattlePlugins has and forever will be dedicated to providing the best experience for our users. We are always improving our plugins, website, and tools for our users. If you have any improvements or ideas for our plugins, don't hesitate to tell us about them.</p>
        </div>
    </div>
</div>
<div class="content-section-b">
    <div class="container">
        @if(count($blog) == 0)
        <div class="row well">
            <div class="col-lg-12">
                <h3>There are no blog posts! :(</h3>
            </div>
        </div>
        @else
        <div class="row">
            <div class="col-lg-9">
                <h2><a href="/blog/{{ $blog->id }}">{{ $blog->title }}</a><br />
                    <small>Written by <a href="/profile/{{ $author }}">{{ $author }}</a> {{ $ago }}.</small></h2>
            </div>
            <div class="col-lg-3 text-right">
                <ul class="pager">
                    <li class="next"><a href="/blog/all">View all blog posts</a></li>
                </ul>
            </div>
        </div>
        <div class="well">
            <div class="row">
                <div class="col-lg-12">{{ $blog->content }}</div>
            </div>
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
            <div class="col-md-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
	                    <span class="panel-title"><a href="/plugins/profile/{{ $build['name'] }}">{{ $build['name'] }}</a></span> <a href="http://dev.bukkit.org/bukkit-plugins/{{ $build['bukkit'] }}"><i class="fa fa-external-link pull-right"></i></a>
                    </div>
                    <div class="panel-body">
                        Created by: <a href="/profile/{{ $authors[$build['author']] }}">{{ $authors[$build['author']] }}</a><br />
                        Last Successful Build: <a href="{{ $build['ci']['url'] }}">{{ $build['ci']['build'] }}</a><br />
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@stop
