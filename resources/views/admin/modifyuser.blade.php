@extends('admin.layouts.master')
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
                <tr>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->displayname }}</td>
                    <td>
                        <a href="/user/modify/{{ $user->id }}"><i class="icon table"></i> Edit Permissions</a>
                    </td>
                    <td>
                        @if(\App\Tools\Misc\UserSettings::hasNode(auth()->user(), \App\Tools\Misc\UserSettings::DELETE_USER))
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