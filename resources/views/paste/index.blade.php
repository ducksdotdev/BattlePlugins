@extends('paste.layouts.master')
@section('content')
    <div class="grid-container">
        <div class="grid-65 grid-parent grid-center">
            <div id="task-header">
                <div class="grid-container">
                    <div class="grid-100">
                        <h2>battlepaste</h2>
                    </div>
                </div>
            </div>
            <div class="ui divided list">
                <div class="ui item">
                    <div class="content">
                        <div class="description">
                            {!! Form::open(['id'=>'createPasteForm','url'=>URL::to('/create', [], env('HTTPS_ENABLED', true)),
                            'class'=>'ui form']) !!}
                            <div class="twelve wide field">
                                <label>Title</label>
                                {!! Form::text('title', '', ['maxlength'=>64]) !!}
                            </div>
                            <div class="wide field">
                                <label>Paste Content <small>Max length {{ env("PASTE_MAX_LEN", 500000) }} characters.</small></label>
                                {!! Form::textarea('content', '', ['maxlength'=>env("PASTE_MAX_LEN", 500000), 'class'=>'monospace']) !!}
                            </div>
                            <div class="field">
                                <div class="ui toggle checkbox">
                                    {!! Form::checkbox('public') !!}
                                    <label>Allow <b>anyone</b> to see this paste?</label>
                                </div>
                            </div>
                            <div class="ui buttons pull-right">
                                <button class="ui button">
                                    Cancel
                                </button>
                                <div class="or"></div>
                                <button class="ui positive button">
                                    Save Paste
                                </button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
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