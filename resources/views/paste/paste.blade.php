@extends('paste.layouts.paste')
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
            <small>
                Created by {{ $author }} <span title="{{ $paste->created_at }}">{{ $paste->created_at->diffForHumans() }}</span>
                @if($paste->created_at != $paste->updated_at)
                    <span title="Last modified {{ $paste->updated_at->diffForHumans() }} ({{ $paste->updated_at }}).">*</span>
                @endif
            </small>
        </h1>
        @include('paste.partials.pastedata')
        <small>{{ strlen($content) }} characters. {{ $lines }} lines (+1 for EOF).</small>
        <pre class="prettyprint linenums grid-100">
            {{ PHP_EOL . $content }}
        </pre>
        @if(Auth::check() && Auth::user()->id == $paste->creator)
            <div class="grid-100 text-right">
                @if($paste->public)
                    <a href="/togglepub/{{ $paste->id }}" class="ui button black">Make Private</a>
                @else
                    <a href="/togglepub/{{ $paste->id }}" class="ui button green">Make Public</a>
                @endif
                <a href="/delete/{{ $paste->id }}" class="ui button red">Delete Paste</a>
            </div>
        @endif
    </div>
    <div class="grid-container">
        {!! Form::open(['id'=>'editPasteForm','url'=>URL::to('/edit', [], env('HTTPS_ENABLED', true)), 'class'=>'ui form']) !!}
        {!! Form::hidden('id', $paste->id) !!}
        <div class="grid-100">
            <label for="content"><small>Max length {{ env("PASTE_MAX_LEN", 500000) }} characters.</small></label>
            {!! Form::textarea('content', $content, ['maxlength'=>env("PASTE_MAX_LEN", 500000), 'class'=>'monospace']) !!}
        </div>
        @if(Auth::check() && Auth::user()->id == $paste->creator)
            <div class="grid-100 text-right">
                <button class="ui positive button">
                    Edit Paste
                </button>
            </div>
        @endif
        {!! Form::close() !!}
    </div>
    <div class="grid-container">
        @include('paste.partials.pastedata')
    </div>
@stop
@section('extraStyles')
    <link rel="stylesheet" href="/assets/css/paste/prettify.css"/>
@stop
@section('extraScripts')
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/autosize.js/1.18.18/jquery.autosize.min.js"></script>
    <script type="text/javascript" src="/assets/js/paste/prettify.js"></script>
@stop