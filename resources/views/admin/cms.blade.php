@extends('admin.layouts.master')
@section('content')
    <div class="grid-100">
        <h2>{{ $title }}</h2>
        @if($jenkins)
            <a href="/tools/cms/jenkins" class="ui button red">Disable Jenkins Feed</a>
        @else
            <a href="/tools/cms/jenkins" class="ui button primary">Enable Jenkins Feed</a>
        @endif

        @if($registration)
            <a href="/tools/cms/registration" class="ui button red">Disable Registration</a>
        @else
            <a href="/tools/cms/registration" class="ui button primary">Enable Registration</a>
        @endif
    </div>
@stop