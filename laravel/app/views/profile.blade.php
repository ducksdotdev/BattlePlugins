@extends('layouts.master')
@section('content')
<div class="content-section-a">
    <div class="container">
        <div class="row">
            <div class="col-lg-2">
                <div class="row">
                    <div class="col-lg-12">
                        <img src="/api/minecraft/face/{{ $username }}/165" width="165" />
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="row">
                    <div class="col-lg-12">
                        <h2>{{ $username }}<br /><small><strong>{{ $ranks }}</strong></small></h2>
                    </div>
                    <div class="col-lg-12">
                        @if($own || $admin)
                        @if(!empty($email))
                        <strong>Email:</strong> <span id="email">{{ $email }}</span>
                        @endif
                        @endif
                    </div>
                </div>
            </div>
            @if(($own || $admin) && count($pastes) > 0)
            <div class="col-lg-5">
                <div class="row">
                    <div class="col-lg-12">
                        <h3>Pastes</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="list-group">
                            @foreach($pastes as $paste)
                            <a href="/paste/{{ $paste->id }}" class="list-group-item">
                                <span class="badge">{{ $paste->id }}</span>
                                {{{ substr($paste->title, 0, 15) }}} {{ $prettyTime[$paste->id] }}
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
<div class="content-section-b">
    <div class="container">
        <div class="row">
        </div>
    </div>
</div>
@stop
