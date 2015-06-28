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
            <small class="author">
                Created by {{ $author }} <span title="{{ $paste->created_at }}">{{ $paste->created_at->diffForHumans() }}</span>
                @if($paste->created_at != $paste->updated_at)
                    <span title="Last modified {{ $paste->updated_at->diffForHumans() }} ({{ $paste->updated_at }}).">*</span>
                @endif
            </small>
        </h1>
        @include('paste.partials.data')
        @include('paste.partials.pastepre')
    </div>
    @if(Auth::check() && Auth::user()->id == $paste->creator)
        <div class="grid-container">
            {!! Form::open(['id'=>'editPasteForm','url'=>URL::to('/edit', [], env('HTTPS_ENABLED', true)), 'class'=>'ui form']) !!}
            {!! Form::hidden('id', $paste->id) !!}
            <div class="grid-100">
                <label for="content"><small>Max length {{ env("PASTE_MAX_LEN", 500000) }} characters.</small></label>
                {!! Form::textarea('content', $content, ['maxlength'=>env("PASTE_MAX_LEN", 500000), 'class'=>'monospace']) !!}
            </div>
            <div class="grid-100 text-right">
                <button class="ui positive button">
                    Edit Paste
                </button>
            </div>
            {!! Form::close() !!}
        </div>
    @endif
@stop
@section('extraStyles')
    @if($lang != 'txt')
        <link rel="stylesheet" href="/assets/css/paste/prettify.css"/>
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/prettify/r298/lang-{{ $lang }}.min.js"/>
    @endif
@stop
@section('extraScripts')
    <script type="text/javascript" src="/assets/js/paste/prettify.js"></script>
@stop