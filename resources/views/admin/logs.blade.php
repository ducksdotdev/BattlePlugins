@extends('layouts.admin')
@section('content')
    <div class="grid-100 bottom-margin ten">
        <strong>Show:</strong>
        @foreach($levels as $name => $color)
            <a href="{{ action('AdminController@getLogs', [base64_encode($current_file)]) }}?log_level={{ $name }}" class="ui button {{ $color }} mini">{{ $name }}</a>
        @endforeach
        <a href="{{ action('AdminController@getLogs', [base64_encode($current_file)]) }}" class="ui button mini">Clear</a>
    </div>
    <div class="grid-80">
        @if(count($logs))
            @foreach($logs as $key => $log)
                <div class="ui message {{$log['level_class']}} log">
                    <strong>{{ ucfirst($log['level']) }} - {{ (new Carbon($log['date']))->diffForHumans() }}
                        ({{ $log['date'] }})</strong>

                    <p>{{ $log['text'] }}
                        @if (isset($log['in_file']))
                            {{ $log['in_file'] }}
                        @endif
                    </p>
                    @if ($log['stack'])
                        <a class="pointer" onclick="$('#stack{{ $key }}').toggleClass('hidden')"><i
                                    class="icon archive"></i> Toggle Stack</a>
                        <pre id="stack{{ $key }}" class="hidden">{!! trim($log['stack']) !!}</pre>
                    @endif
                </div>
            @endforeach
        @else
            <div class="ui message warning">No logs match your criteria.</div>
        @endif
        <div class="text-center">
            @if ($logs->lastPage() > 1)
                <div class="ui menu pagination">
                    <a href="/feeds/logs/{{ base64_encode($current_file) }}/1/{{ $perPage }}"
                       class="ui item {{ ($logs->currentPage() == 1) ? ' disabled' : '' }}">
                        <i class="icon angle double left"></i>
                    </a>
                    <a href="/feeds/logs/{{ base64_encode($current_file) }}/{{ $logs->currentPage()-1 }}/{{ $perPage }}"
                       class="ui item {{ ($logs->currentPage() == 1) ? ' disabled' : '' }}">
                        <i class="icon angle left"></i>
                    </a>
                    <span class="ui item disabled">
                        {{ $logs->currentPage() }}
                    </span>
                    <a href="/feeds/logs/{{ base64_encode($current_file) }}/{{ $logs->currentPage()+1 }}/{{ $perPage }}"
                       class="ui item {{ ($logs->currentPage() == $logs->lastPage()) ? ' disabled' : '' }}">
                        <i class="icon angle right"></i>
                    </a>
                    <a href="/feeds/logs/{{ base64_encode($current_file) }}/{{ $logs->lastPage() }}/{{ $perPage }}"
                       class="ui item {{ ($logs->currentPage() == $logs->lastPage()) ? ' disabled' : '' }}">
                        <i class="icon angle double right"></i>
                    </a>
                </div>
            @endif
        </div>
    </div>
    <div class="grid-20 grid-parent">
        <div class="grid-100 text-center">
            <div class="ui segment">
                <strong>Amount Per Page:</strong>

                <div class="ui secondary menu">
                    @foreach([5,15,25] as $num)
                        <a href="{{ action('AdminController@getLogs', [base64_encode($current_file), 1, $num]) }}"
                           class="@if($perPage == $num) active @endif item">
                            {{ $num }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="grid-100">
            <h4>More Logs:</h4>

            <div class="ui vertical menu">
                @foreach($files as $file)
                    <a href="/feeds/logs/{{ base64_encode($file) }}"
                       class="item @if ($current_file == $file) active @endif">
                        {{ ($date = Carbon::createFromFormat('Y m d', trim(str_replace(['-', 'laravel', '.log'], ' ', $file)))->diffInDays()) > 0 ? ($date > 1 ? $date . ' days ago' : '1 day ago') : 'Today' }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@stop