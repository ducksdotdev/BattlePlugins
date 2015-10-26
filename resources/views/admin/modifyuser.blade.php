@extends('layouts.admin')
@section('content')
    <div class="grid-100">
        <table class="ui striped table">
            <thead>
            <tr>
                <th width="50%">Email</th>
                <th width="20%">Display Name</th>
                <th width="30%" colspan="2">User Settings</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr @if($user->google2fa_secret) class="positive"
                    @elseif(UserSettings::hasNode($user, UserSettings::FORCE_2FA) && !$user->google2fa_secret) class="negative" @endif>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->displayname }}</td>
                    <td>
                        <a href="/user/modify/{{ $user->id }}"><i class="icon table"></i> Edit Permissions</a>
                    </td>
                    <td>
                        @if($user->google2fa_secret)
                            {!! Form::open(['url'=>URL::to('/user/modify/'. $user->id .'/reset2fa', [], env('HTTPS_ENABLED', true)), "class"=>'inline']) !!}
                            <button href="" class="ui button red mini">Reset 2FA</button>
                            {!! Form::close() !!}
                        @endif
                        @if(UserSettings::hasNode(auth()->user(), UserSettings::DELETE_USER))
                            {!! Form::open(['url'=>URL::to('/user/modify/'. $user->id .'/delete', [], env('HTTPS_ENABLED', true)), "class"=>'inline']) !!}
                            <button href="" class="ui button red mini">Delete User</button>
                            {!! Form::close() !!}
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@stop