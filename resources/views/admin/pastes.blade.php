@extends('admin.layouts.master')
@section('content')
    <div class="grid-75">
        <h3>All Pastes</h3>
        @if(count($pastes) > 0)
            <table class="ui table">
                <thead>
                <tr>
                    <th>Author</th>
                    <th>Slug</th>
                    <th>Server ID</th>
                    <th>Public?</th>
                    @if(\App\Tools\Misc\UserSettings::hasNode(auth()->user(), \App\Tools\Misc\UserSettings::DELETE_PASTES_AS_ADMIN))
                        <th>Actions</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                @foreach($pastes as $paste)
                    <tr>
                        <td>{{ $paste->creator->displayname }}</td>
                        <td>@if($paste->public) <a
                                    href="{{ action('PasteController@getPaste', ['slug'=>$paste->slug]) }}">@endif {{ $paste->slug }} @if($paste->public)</a>@endif</td>
                        <td>{{ count($split = explode('#sid', $paste->title)) > 1 ? $split[1] : 'N/A' }}</td>
                        <td>{{ $paste->public ? 'Public' : 'Private' }}</td>
                        @if(\App\Tools\Misc\UserSettings::hasNode(auth()->user(), \App\Tools\Misc\UserSettings::DELETE_PASTES_AS_ADMIN))
                            <td>
                                {!! Form::open(['url'=>URL::to('/tools/pastes/delete/'.$paste->id, [], env('HTTPS_ENABLED', true))]) !!}
                                <button class="ui button red mini">Delete Paste?</button>
                                {!! Form::close() !!}
                            </td>
                        @endif
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
    <div class="grid-25 ui sticky">
        <h3>Filter</h3>

        <div class="ui segment ">
            {!! Form::open(['url'=>URL::to('/tools/pastes', [], env('HTTPS_ENABLED', true)),'class'=>'ui form', 'method'=>'get']) !!}
            <div class="field">
                <label>Server ID
                    <small>(Starts with #sid)</small>
                </label>

                <div class="ui icon input">
                    <input name="serverid" type="text" value="{{ $inputs->input('serverid') }}"/>
                    @if($inputs->has('serverid'))
                        <i class="icon remove" for="serverid"></i>
                    @endif
                </div>
            </div>
            <div class="field">
                <label>Paste ID
                    <small>(Paste's slug, case sensitive)</small>
                </label>

                <div class="ui icon input">
                    <input name="slug" type="text" value="{{ $inputs->input('slug') }}"/>
                    @if($inputs->has('slug'))
                        <i class="icon remove" for="slug"></i>
                    @endif
                </div>
            </div>
            <div class="field">
                <label>Author
                    <small>(Minecraft Name)</small>
                </label>

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
                    <label>Strict Filter?
                        <small>('AND' instead of 'OR')</small>
                    </label>
                </div>
            </div>
            <div class="field">
                @if($inputs->has('author') || $inputs->has('slug') || $inputs->has('serverid'))
                    <a href="{{ action('AdminController@getPastes') }}" class="ui button black">Clear</a>
                @endif
                <button class="ui button primary pull-right">Apply</button>
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

            $('.ui.sticky').sticky({context: '#content'});
        });
    </script>
@stop