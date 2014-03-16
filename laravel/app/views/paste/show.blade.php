@extends('layouts.master')
@section('content')
<div id="paste" data-id="{{ $paste->id }}">
    <div class="content-section-a">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>{{ $title }}
                        @if($paste->private)<span class="label label-danger">private</span>@endif
                        @if($paste->lang != null)<span class="label label-info">{{ $paste->lang }}</span>@endif
                        @if($hidden != null)<span class="label label-warning">Deletes in {{ $hidden }}</span>@endif<br />
                        <small>Created by <a href="/profile/{{ $author }}">{{ $author }}</a> {{ $ago }}</small></h2>
                </div>
            </div>
        </div>
    </div>
    <div class="content-section-b">
        <div class="container">
            <div id="box">
                <div class="row">
                    <div class="col-lg-12 text-right">
                        <a href="/paste/{{ $paste->id }}/raw" class="btn btn-link">View Raw</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <pre @if($paste->lang != 'plain') class="prettyprint linenums @if($paste->lang != null) lang-{{ $paste->lang }} @endif" @endif>{{{ $paste->content }}}</pre>
                    </div>
                </div>
            </div>
            @if($own || $admin)
            {{ Form::token() }}
            <div class="row">
                <div class="col-lg-6">
                    <button class="btn btn-primary" id="editPaste">Edit</button>
                </div>
                <div class="col-lg-6 text-right">
                    <button class="btn btn-danger" id="deletePaste">Delete</button>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@stop
@if($paste->lang != null && $paste->lang != 'plain')
@section('extraStyles')
<script src="/assets/js/prettify/lang-{{ $paste->lang }}.js"></script>
@stop
@endif
