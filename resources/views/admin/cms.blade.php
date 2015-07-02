@extends('admin.layouts.master')
@section('content')
    <div class="grid-100">
        <h2>{{ $title }}</h2>
    </div>
    <div class="grid-50">
        <h3>All Sites</h3>
        @if($registration)
            <a href="/tools/cms/registration" class="ui button red">Disable Registration</a>
        @else
            <a href="/tools/cms/registration" class="ui button primary">Enable Registration</a>
        @endif

        @if($footer)
            <a href="/tools/cms/footer" class="ui button red">Disable Footer</a>
        @else
            <a href="/tools/cms/footer" class="ui button primary">Enable Footer</a>
        @endif
    </div>
    <div class="grid-50">
        <h3>Blog</h3>
        @if($jenkins)
            <a href="/tools/cms/jenkins" class="ui button red">Disable Jenkins Feed</a>
        @else
            <a href="/tools/cms/jenkins" class="ui button primary">Enable Jenkins Feed</a>
        @endif
    </div>
    <div class="grid-50">
        <h3>BattleAdmin</h3>
        @if($dash_jenkins)
            <a href="/tools/cms/dash_jenkins" class="ui button red">Disable Jenkins Feed</a>
        @else
            <a href="/tools/cms/dash_jenkins" class="ui button primary">Enable Jenkins Feed</a>
        @endif

        @if($alert_bar)
            <a href="/tools/cms/alert_bar" class="ui button red">Disable Alert Bar</a>
        @else
            <a href="/tools/cms/alert_bar" class="ui button primary">Enable Alert Bar</a>
        @endif
    </div>
@stop