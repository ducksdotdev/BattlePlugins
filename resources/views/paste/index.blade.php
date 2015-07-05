@extends('paste.layouts.master')
@section('content')
    <div class="grid-container">
        <div class="grid-65 grid-parent grid-center">
            <div class="task-header">
                <div class="grid-container">
                    <div class="grid-100">
                        <h2>battlepaste</h2>
                    </div>
                </div>
            </div>
            <div class="paste ui segment grid-100">
                @if(session()->has('error'))
                    <div class="ui message negative">
                        {{ session()->get('error') }}
                    </div>
                @endif
                @include('paste.partials.createform')
            </div>
            @if(count($pastes) > 0)
                <div class="ui segment paste-list grid-100 grid-parent">
                    @foreach($pastes as $paste)
                        @include('paste.partials.paste')
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@stop