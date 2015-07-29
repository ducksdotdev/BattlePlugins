@extends('admin.layouts.master')
@section('content')
    <div class="grid-100">
        <div class="ui message warning">
            Please remember that these API keys would allow someone to make actions as a user. Do not give these keys out to anyone.
        </div>
    </div>
    <div class="grid-100">
        <table class="ui table">
            <thead>
            <tr>
                <th>User</th>
                <th>Key (Hover to view)</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                @if(!\App\Tools\Misc\UserSettings::hasNode($user, \App\Tools\Misc\UserSettings::HIDE_API_KEY))
                    <tr>
                        <td>{{ $user->email }} - {{ $user->displayname }}</td>
                        <td><span class="spoiler">{{ $user->api_key }}</span></td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
    </div>
@stop