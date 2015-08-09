@extends('layouts.admin')
@section('content')
    <div class="grid-55 grid-parent">
        <div class="grid-100" ng-controller="ServerStatusCtrl">
            <h3>Server Status</h3>

            <div ng-bind-html="serverstats"></div>
        </div>
        <div class="grid-100">
            @include('admin.dashboard.tasks')
        </div>
        <div class="grid-100">
            @include('admin.dashboard.overview')
        </div>
        <div class="grid-100">
            @include('admin.dashboard.analytics')
        </div>
    </div>
    <div class="grid-45 grid-parent">
        @include('admin.dashboard.github')
        @include('admin.dashboard.jenkins')
    </div>
    <div class="grid-100">
        @include('admin.dashboard.log')
    </div>
@stop