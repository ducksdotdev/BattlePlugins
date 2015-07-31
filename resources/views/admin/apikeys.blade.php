@extends('admin.layouts.master')
@section('content')
    <div class="grid-100">
        <div class="ui message warning">
            Please remember that these API keys would allow someone to make actions as a user. Do not give these keys out to anyone.
        </div>
    </div>
    <div class="grid-100">
        @if(count($nodes))
            <table class="ui table">
                <thead>
                <tr>
                    <th>User</th>
                    <th>Key (Hover to view)</th>
                </tr>
                </thead>
                <tbody>
                @foreach($nodes as $node)
                    <tr>
                        <td>{{ $node->user->email }} - {{ $node->user->displayname }}</td>
                        <td>
                            @if(\App\Tools\Misc\UserSettings::hasNode($node->user_id, \App\Tools\Misc\UserSettings::HIDE_API_KEY))
                                Hidden
                            @else
                                <span class="spoiler">{{ $node->user->api_key }}</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <div class="ui message info">No users can use the API.</div>
        @endif
    </div>
@stop