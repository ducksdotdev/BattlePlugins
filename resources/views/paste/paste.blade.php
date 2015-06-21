@extends('paste.layouts.login')
@section('content')
    <div class="grid-container">
        <h1 class="grid-100">
            @if($paste->title)
                {{ $paste->title }}
            @else
                Paste {{ $paste->slug }}
            @endif

            @if($paste->public)
                (Public)
            @endif
                <small>Created by {{ $author }}</small>
        </h1>
        <div class="grid-100">
            Short URL: <a href="http://bplug.in/{{ $paste->slug }}">bplug.in/{{ $paste->slug }}</a>
        </div>
        <pre class="prettyprint linenums grid-100">
            {{ $content }}
        </pre>
        <div class="grid-100 text-right">
            @if($paste->public)
                <a href="/togglepub/{{ $paste->id }}" class="ui button black">Make Private</a>
            @else
                <a href="/togglepub/{{ $paste->id }}" class="ui button green">Make Public</a>
            @endif

            <a href="/delete/{{ $paste->id }}" class="ui button red">Delete Paste</a>
        </div>
    </div>
    <div class="grid-container">
        {!! Form::open(['id'=>'editPasteForm','url'=>URL::to('/edit', [], env('HTTPS_ENABLED', true)), 'class'=>'ui form']) !!}
        {!! Form::hidden('id', $paste->id) !!}
        <div class="grid-100">
            {!! Form::textarea('content', $content) !!}
        </div>
        <div class="grid-100 text-right">
            <button id="savePaste" class="ui positive button">
                Save Paste
            </button>
        </div>
        {!! Form::close() !!}
    </div>
@stop
@section('extraStyles')
    <link rel="stylesheet" href="/assets/css/paste/prettify.css"/>
@stop
@section('extraScripts')
    <script src="/assets/js/paste/prettify.js"></script>
@stop
@section('onLoad')
    onload="prettyPrint()"
@stop