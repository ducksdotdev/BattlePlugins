@extends('api.layouts.master')
@section('content')
    @include('api.partials.header')
    <div class="grid-container" id="docs">
        <div class="grid-75 grid-parent">
            @foreach($docs as $docType)
                @include('api.partials.doc')
            @endforeach
        </div>
        @include('api.partials.menu')
    </div>
    @include('api.modals.webhooks')
@stop