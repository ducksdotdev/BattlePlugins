@extends('admin.layouts.master')
@section('content')
    <div class="grid-100">
        <h1>Notices</h1>

        @if(count($alerts) > 0)
            @foreach($alerts as $alert)
                <div class="ui message {{ $alert->color }}">
                    <a href="/tools/alert/delete/{{ $alert->id }}">
                        <i class="icon remove pull-right"></i>
                    </a>
                    <strong>Posted {{ $alert->created_at->diffForHumans() }}</strong>

                    <p>
                        {{ $alert->content }}
                    </p>
                </div>
            @endforeach
        @else
            <div class="ui message info"><strong>You have no alerts!</strong></div>
        @endif
    </div>
@stop