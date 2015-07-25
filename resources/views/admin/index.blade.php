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
            @include('admin.partials.dashboard.overview')
        </div>
    </div>
    <div class="grid-45 grid-parent">
        @include('admin.partials.dashboard.github')
        @include('admin.partials.dashboard.jenkins')
    </div>
    <div class="grid-100">
        @include('admin.partials.dashboard.log')
    </div>
@stop