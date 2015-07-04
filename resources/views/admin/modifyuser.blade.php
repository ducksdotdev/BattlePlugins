@extends('admin.layouts.master')
@section('content')
    <div class="grid-100">
        <table class="ui celled striped table">
            <thead>
            <tr>
                <th width="50%">Email</th>
                <th width="20%">Display Name</th>
                <th widt="30%">User Settings</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->displayname }}</td>
                    <td class="text-center">
                        @if($user->id != 1)
                            {!! Form::open(['url'=>URL::to('/user/modify/'.$user->id.'/admin', [], env('HTTPS_ENABLED', true)), 'class' => 'inline']) !!}
                                @if($user->admin)
                                    <button class="ui button red mini">Remove Admin</button>
                                @else
                                    <button class="ui button black mini">Make Admin</button>
                                @endif
                            {!! Form::close() !!}
                            {!! Form::open(['url'=>URL::to('/user/modify/'. $user->id .'/delete', [], env('HTTPS_ENABLED', true)), "class"=>'inline']) !!}
                                <button href="" class="ui button red mini">Delete User</button>
                            {!! Form::close() !!}
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