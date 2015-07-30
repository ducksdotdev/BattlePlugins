@extends('admin.layouts.master')
@section('content')
    <div class="grid-75">
        <h3>All Pastes</h3>
        @if($pastes)
            <table class="ui table">
                <thead>
                <tr>
                    <th>Author</th>
                    <th>Link</th>
                    <th>Server ID</th>
                </tr>
                </thead>
                <tbody>
                @foreach($pastes->all() as $paste)
                    <tr>
                        <td>{{ $paste->creator->displayname }}</td>
                        <td><a href="http://bplug.in/{{ $paste->slug }}">http://bplug.in/{{ $paste->slug }}</a></td>
                        <td>{{ count($split = explode('#sid', $paste->title)) > 1 ? $split[1] : 'N/A' }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <div class="ui message info">
                There are no pastes that meet your search criteria.
            </div>
        @endif
    </div>
    <div class="grid-25">
        <h3>Filter</h3>

        <div class="ui segment">
            {!! Form::open(['url'=>URL::to('/tools/pastes/filter', [], env('HTTPS_ENABLED', true)),'class'=>'ui form']) !!}
            <div class="field">
                <label>Server ID</label>

                <div class="ui icon input">
                    <input name="serverid" type="text" value="{{ $inputs->input('serverid') }}"/>
                    @if($inputs->has('serverid'))
                        <i class="icon remove" for="serverid"></i>
                    @endif
                </div>
            </div>
            <div class="field">
                <label>Paste ID</label>

                <div class="ui icon input">
                    <input name="slug" type="text" value="{{ $inputs->input('slug') }}"/>
                    @if($inputs->has('slug'))
                        <i class="icon remove" for="slug"></i>
                    @endif
                </div>
            </div>
            <div class="field">
                <label>Author</label>

                <div class="ui icon input">
                    <input name="author" type="text" value="{{ $inputs->input('author') }}"/>
                    @if($inputs->has('author'))
                        <i class="icon remove" for="author"></i>
                    @endif
                </div>
            </div>
            <div class="field">
                <div class="ui checkbox">
                    <input type="checkbox" name="strict" tabindex="0" class="hidden" @if($inputs->has('strict')) checked @endif>
                    <label>Strict Filter?</label>
                </div>
            </div>
            <div class="field text-right">
                <button class="ui button primary">Apply</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@stop
@section('extraScripts')
    <script>
        $(function () {
            $("i.icon.remove").click(function () {
                $('input[name="' + $(this).attr('for') + '"]').attr('value', null);
                $(this).hide();
            });
        });
    </script>
@stop