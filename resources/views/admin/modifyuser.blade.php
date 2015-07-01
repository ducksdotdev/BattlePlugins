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
                    <td class="text-center">
                        @if($user->id != 1)
                            @if($user->admin)
                                <a href="/user/modify/{{ $user->id }}/admin" class="ui button red mini">Remove Admin</a>
                            @else
                                <a href="/user/modify/{{ $user->id }}/admin" class="ui button black mini">Make Admin</a>
                            @endif
                            <a href="/user/modify/{{ $user->id }}/delete" class="ui button red mini">Delete User</a>
                        @else
                            This user cannot be modified.
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@stop