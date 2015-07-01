@extends('admin.layouts.master')
@section('content')
    <div class="grid-100">
        <h2>Modify Users</h2>
    </div>
    <div class="grid-100">
        <table class="ui celled striped table">
            <thead>
            <tr>
                <th>Email</th>
                <th>Display Name</th>
                <th>User Settings</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->displayname }}</td>
                    @if($user->id != 1)
                        <td>
                            @if($user->admin)
                                <a href="/modify/user/{{ $user->id }}/admin" class="ui button red">Remove Admin</a>
                            @else
                                <a href="/modify/user/{{ $user->id }}/admin" class="ui button black">Make Admin</a>
                            @endif
                            <a href="/modify/user/{{ $user->id }}/delete" class="ui button red">Delete User</a>
                        </td>
                    @else
                        <td>User can't be modified.</td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@stop