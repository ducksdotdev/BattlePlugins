@extends('layouts.admin')
@section('content')
    {!! Form::open(['url'=>URL::to('/user/modify/'.$user->id.'/permissions', [], env('HTTPS_ENABLED', true))]) !!}
    <div class="grid-container">
        <div class="grid-100">
            <h3>Permission Nodes</h3>
        </div>
        <div class="grid-100">
            <div id="selectAll" class="ui checkbox">
                <input type="checkbox" tabindex="0" class="hidden">
                <label>Select All</label>
            </div>
        </div>
    </div>
    <div id="nodes" class="grid-container">
        @foreach($nodes as $node)
            <div class="grid-20 bottom-margin ten">
                <div class="ui checkbox">
                    <input type="checkbox" name="{{ $node }}" tabindex="0" class="hidden" @if(\App\Tools\Misc\UserSettings::hasNode($user, $node)) checked @endif>
                    <label>{{ $node }}</label>
                </div>
            </div>
        @endforeach
    </div>
    <div class="grid-container">
        <div class="grid-50 mobile-grid-50">
            <a href="{{ action('AdminController@getModifyUser') }}" class="ui button">Back</a>
        </div>
        <div class="grid-50 mobile-grid-50 text-right">
            <a onclick="window.location.reload()" class="ui button black">Reset to Previous</a>
            <button class="ui button green">Save</button>
        </div>
    </div>
    {!! Form::close() !!}
@stop
@section('extraScripts')
    <script>
        $(function () {
            $("#selectAll").checkbox({
                onChange: function () {
                    if (!$("#selectAll").hasClass('checked'))
                        $("#nodes .ui.checkbox").checkbox('uncheck');
                    else
                        $("#nodes .ui.checkbox").checkbox('check');
                }
            });
        });
    </script>
@stop