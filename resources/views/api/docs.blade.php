@extends('api.layouts.master')
@section('content')
    @include('api.partials.header')
    <div class="grid-container" id="docs">
        <div class="grid-75 grid-parent">
            @foreach($docs as $docType)
                @include('api.partials.doc')
            @endforeach
        </div>
        <div class="grid-25 hide-on-mobile hide-on-tablet ui sticky">
            <div class="ui styled fluid accordion">
                <div class="title">
                    <i class="dropdown icon"></i> API Documentation
                </div>
                <div class="content">
                    <p>
                        <a href="#header"> Top</a>
                    </p>

                    <p>
                        <a href="#authentication"> Authentication</a>
                    </p>
                </div>
                @foreach($docs as $docType)
                    <div class="title">
                        <i class="dropdown icon"></i> {{ ucfirst($docType['name']) }}
                    </div>
                    <div class="content">
                        @foreach($docType['methods'] as $doc)
                            @if(!array_has($doc, 'node') || \App\Tools\Misc\UserSettings::hasNode(auth()->user(), $doc['node']))
                                <p>
                                    <a href="#{{ $docType['name'] }}-{{ $doc['title'] }}">{{ $doc['title'] }}</a>
                                </p>
                            @endif
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @if(\App\Tools\Misc\UserSettings::hasNode(auth()->user(), \App\Tools\Misc\UserSettings::USE_WEBHOOKS))
        @include('api.modals.webhooks')
    @endif
@stop