@extends('admin.layouts.master')
@section('content')
    <div class="grid-55 grid-parent">
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
    <div class="grid-45 grid-parent">
        @if(count($blogList))
            <div class="grid-100">
                @include('admin.partials.dashboard.blogposts')
            </div>
        @endif
        @if($jenkins && count($rssFeed > 0))
            @include('admin.partials.dashboard.jenkins')
        @endif
        @include('admin.partials.dashboard.github')
    </div>
@stop