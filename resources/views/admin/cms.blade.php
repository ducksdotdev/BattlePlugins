@extends('admin.layouts.master')
@section('content')
    <div class="grid-25">
        <h3>All Sites</h3>
        {!! Form::open(['url'=>URL::to('/tools/cms/registration', [], env('HTTPS_ENABLED', true))]) !!}
        @if($registration)
            <button class="ui button red">Disable Registration</button>
        @else
            <button class="ui button primary">Enable Registration</button>
        @endif
        {!! Form::close() !!}
        <br/>
        {!! Form::open(['url'=>URL::to('/tools/cms/footer', [], env('HTTPS_ENABLED', true))]) !!}
        @if($footer)
            <button class="ui button red">Disable Footer</button>
        @else
            <button class="ui button primary">Enable Footer</button>
        @endif
        {!! Form::close() !!}
    </div>
    <div class="grid-25">
        <h3>Blog</h3>
        {!! Form::open(['url'=>URL::to('/tools/cms/jenkins', [], env('HTTPS_ENABLED', true))]) !!}
        @if($jenkins)
            <button class="ui button red">Disable Jenkins Feed</button>
        @else
            <button class="ui button primary">Enable Jenkins Feed</button>
        @endif
        {!! Form::close() !!}<br/>
        {!! Form::open(['url'=>URL::to('/tools/cms/comment_feed', [], env('HTTPS_ENABLED', true))]) !!}
        @if($comment_feed)
            <button class="ui button red">Disable Comment Feed</button>
        @else
            <button class="ui button primary">Enable Comment Feed</button>
        @endif
        {!! Form::close() !!}
    </div>
    <div class="grid-25">
        <h3>BattleAdmin</h3>
        {{--{!! Form::open(['url'=>URL::to('/tools/cms/dash_jenkins', [], env('HTTPS_ENABLED', true))]) !!}--}}
        {{--@if($dash_jenkins)--}}
        {{--<button class="ui button red">Disable Jenkins Feed</button>--}}
        {{--@else--}}
        {{--<button class="ui button primary">Enable Jenkins Feed</button>--}}
        {{--@endif--}}
        {{--{!! Form::close() !!}--}}
        {{--<br/>--}}
        {!! Form::open(['url'=>URL::to('/tools/cms/alert_bar', [], env('HTTPS_ENABLED', true))]) !!}
        @if($alert_bar)
            <button class="ui button red">Disable Alert Bar</button>
        @else
            <button class="ui button primary">Enable Alert Bar</button>
        @endif
        {!! Form::close() !!}
    </div>
@stop