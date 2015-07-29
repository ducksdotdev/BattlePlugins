@extends('admin.layouts.master')
@section('content')
    <div class="grid-100">
        <table class="ui table">
            <thead>
            <tr>
                <th>User</th>
                <th>Key</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->email }} - {{ $user->displayname }}</td>
                    <td>{{ $user->api_key }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@stop