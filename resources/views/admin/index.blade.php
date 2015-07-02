@extends('admin.layouts.master')
@section('content')
    <div class="grid-100">
        <h1>{{ $title }}</h1>
    </div>
    <div class="grid-60 grid-parent">
        <div class="grid-100">
            @include('admin.partials.dashboard.serverstats')
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
            <div class="grid-100 grid-parent">
                @include('admin.partials.dashboard.jenkins')
            </div>
        @endif
    </div>
@stop