@extends('paste.layouts.paste')
@section('content')
    <div class="grid-container">
        <h1 class="grid-85">
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
        @include('paste.partials.data')
        @include('paste.partials.actions')
        <div class="grid-100">
            <small>{{ strlen($content) }}/{{ env("PASTE_MAX_LEN", 500000) }} characters. {{ $lines }} lines.</small>
            @if($lang != 'auto')
                <div class="paste">
                    <div class="ui top attached blue label">{{ $lang }}</div>
                    @endif
                    <pre class="prettyprint linenums lang-{{ $lang }}">{{ $content }}</pre>
                    @if($lang != 'auto')
                </div>
            @endif
            <small>{{ strlen($content) }}/{{ env("PASTE_MAX_LEN", 500000) }} characters. {{ $lines }} lines.</small>
        </div>
        @include('paste.partials.actions')
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
        @include('paste.partials.data')
    </div>
@stop
@section('extraStyles')
    @if($lang != 'txt')
        <link rel="stylesheet" href="/assets/css/paste/prettify.css"/>
    @endif
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/prettify/r298/lang-{{ $lang }}.min.js"/>
@stop
@section('extraScripts')
    <script type="text/javascript" src="/assets/js/paste/prettify.js"></script>
@stop