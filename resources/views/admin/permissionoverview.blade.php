@extends('admin.layouts.master')
@section('content')
    @foreach($nodes as $node)
        <div class="grid-25">
            <h3>{{ $node }}</h3>
            @if(count($permissions->whereNode($node)->get()) > 0)
                <ul>
                    @foreach($permissions->whereNode($node)->get() as $perm)
                        <li>{{ $perm->user->displayname }}</li>
                    @endforeach
                </ul>
            @else
                Empty Group
            @endif
        </div>
    @endforeach
@stop