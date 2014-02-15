@extends('layouts.master')
@section('content')
<div class="content-section-a">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h2>Our Plugins <small>({{ count($plugins) }})</small></h2>
                <p>BattlePlugins has been creating Bukkit modifications since February 2012. Below is a list of our most up to date plugins. Some of our plugins may not be listed below.</p>
            </div>
            <div class="col-lg-5 col-lg-offset-1">
                <h3>Want to create plugins with us?</h3>
                <p>We are always looking for like minded developers who would be interested in helping out. If you would like to help us with making extensions, improvements, or additions to our plugins, please <a href="http://wiki.battleplugins.com/w/index.php?title=BA_API_Tutorial">click here</a>.</p>
            </div>
        </div>
    </div>
</div>
<div class="content-section-b">
    <div class="container">
        <div class="row">
            @foreach($builds as $build)
            <div class="col-lg-4">
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
