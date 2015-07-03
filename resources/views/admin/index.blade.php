@extends('admin.layouts.master')
@section('content')
    <div class="grid-100">
        <h1>{{ $title }}</h1>
    </div>
    <div class="grid-60 grid-parent">
        <div class="grid-100" ng-controller="ServerStatusCtrl">
            <h3>Server Status</h3>
            <div ng-bind-html="serverstats"></div>
        </div>
        <div class="grid-100">
            @include('admin.partials.dashboard.tasks')
        </div>
        <div class="grid-100">
            @include('admin.partials.dashboard.blog')
        </div>
    </div>
    <div class="grid-40 grid-parent">
        <div class="grid-100">
            @include('admin.partials.dashboard.blogposts')
        </div>
        @if($jenkins && count($rssFeed > 0))
            @include('admin.partials.dashboard.jenkins')
        @endif
    </div>
@stop