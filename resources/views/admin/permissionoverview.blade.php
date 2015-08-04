@extends('layouts.admin')
@section('content')
    @foreach($nodes as $node)
        <div class="grid-25 bottom-margin ten">
            <div class="ui segment">
                <h3 style="margin: 5px 0">{{ $node }}</h3>

                <div style="height:125px; overflow:auto;">
                    @if(count($permissions->whereNode($node)->get()) > 0)
                        <ul style="margin: 0;">
                            @foreach($permissions->whereNode($node)->get() as $perm)
                                <li>{{ $perm->user->displayname }}</li>
                            @endforeach
                        </ul>
                    @else
                        Empty Group
                    @endif
                </div>
            </div>
        </div>
    @endforeach
@stop