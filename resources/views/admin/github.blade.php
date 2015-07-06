@extends('admin.layouts.master')
@section('content')
    <div class="grid-65 grid-parent">
        <div class="grid-100">
            <h3>Events Feed (Last 100 events)</h3>
        </div>
        <div class="grid-100">
            @include('admin.partials.github')
        </div>
    </div>
    <div class="grid-35 grid-parent">
        <div class="grid-100">
            <h3>Organization Members</h3>
        </div>
        <div class="grid-100 grid-parent">
            @foreach($members as $member)
                <div class="grid-50 mobile-grid-50 tablet-grid-50 bottom-margin ten">
                    <div class="ui segment text-center">
                        <div class="ui avatar big image">
                            <a href="{{ $member->html_url }}"><img src="{{ $member->avatar_url }}"></a>
                        </div>
                        <div class="content">
                            <a class="header" href="{{ $member->html_url }}">{{ $member->login }}</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="grid-100">
            <h3>Repositories</h3>
        </div>
        <div class="grid-100">
            <div class="ui segment">
                @foreach($repos as $repo)
                    <div class="grid-50 mobile-grid-50 tablet-grid-50">
                        <div class="content">
                            <a class="header" href="{{ $repo->html_url }}">{{ $repo->name }}</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@stop