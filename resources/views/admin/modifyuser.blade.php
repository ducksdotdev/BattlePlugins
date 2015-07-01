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
                <th colspan="3">User Settings</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->displayname }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@stop