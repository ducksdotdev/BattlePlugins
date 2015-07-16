@extends('admin.layouts.master')
@section('content')
    <div class="grid-80 grid-parent">
        <div class="grid-100">
            <table class="ui table">
                <thead>
                <tr>
                    <th>Short URL</th>
                    <th>Redirect</th>
                    <th>Last Used</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($urls as $url)
                    <tr @if(!Domain::remoteFileExists($url->url)) class="negative" @endif>
                        <td>http://bplug.in/{{ $url->path }}</td>
                        <td class="break-all"><a href="{{ $url->url }}">{{ $url->url }}</a></td>
                        <td title="{{ $url->last_used }}">{{ (new Carbon($url->last_used))->diffForhumans() }}</td>
                        <td>
                            {!! Form::open(['url'=>URL::to('/statistics/shorturls/delete/'.$url->path, [], env('HTTPS_ENABLED', true))]) !!}
                            <button class="ui button icon circular red"><i class="icon remove"></i></button>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="text-center">
                @if ($urls->lastPage() > 1)
                    <div class="ui menu pagination">
                        <a href="/statistics/shorturls/1"
                           class="ui item {{ ($urls->currentPage() == 1) ? ' disabled' : '' }}">
                            <i class="icon angle double left"></i>
                        </a>
                        <a href="/statistics/shorturls/{{ $urls->currentPage()-1 }}"
                           class="ui item {{ ($urls->currentPage() == 1) ? ' disabled' : '' }}">
                            <i class="icon angle left"></i>
                        </a>
                    <span class="ui item disabled">
                        {{ $urls->currentPage() }}
                    </span>
                        <a href="/statistics/shorturls/{{ $urls->currentPage()+1 }}"
                           class="ui item {{ ($urls->currentPage() == $urls->lastPage()) ? ' disabled' : '' }}">
                            <i class="icon angle right"></i>
                        </a>
                        <a href="/statistics/shorturls/{{ $urls->lastPage() }}"
                           class="ui item {{ ($urls->currentPage() == $urls->lastPage()) ? ' disabled' : '' }}">
                            <i class="icon angle double right"></i>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="grid-20">
        <div class="ui segment text-center">
            <strong>Amount Per Page:</strong>

            <div class="ui secondary menu">
                @foreach([20,35,50] as $num)
                    <a href="{{ action('Admin\PageController@shortUrls', [1, $num]) }}"
                       class="@if($perPage == $num) active @endif item">
                        {{ $num }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@stop