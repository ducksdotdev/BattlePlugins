@extends('paste.layouts.master')
@section('content')
    <div class="grid-container">
        <div class="grid-65 grid-parent grid-center">
            <div id="task-header">
                <div class="grid-container">
                    <div class="grid-90 mobile-grid-90">
                        <h2>battlepaste</h2>
                    </div>
                    <div class="grid-10 tablet-grid-10 mobile-grid-10 text-right actions">
                        @if(Auth::check())
                            <button id="createPaste" class="circular small ui positive icon button">
                                <i class="icon plus"></i>
                            </button>
                        @endif
                        &nbsp;
                    </div>
                </div>
            </div>
            @if(count($pastes) > 0)
                @include('paste.partials.pastelist')
            @else
                <div class="ui divided list">
                    <div class="text-center ui message negative">
                        You don't have any pastes!
                    </div>
                </div>
            @endif

            @if(Auth::check())
                @include('paste.modals.createPaste')
            @endif
        </div>
    </div>
@stop