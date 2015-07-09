@extends('admin.layouts.master')
@section('content')
    <div class="grid-85">
        <table id="table-log" class="ui table striped">
            <thead>
            <tr>
                <th>Level</th>
                <th>Date</th>
                <th>Content</th>
            </tr>
            </thead>
            <tbody>
            @foreach($logs as $key => $log)
                <tr>
                    <td width="10%" class="{{$log['level_class']}}">{{$log['level']}}</td>
                    <td>{!!$log['date']!!}</td>
                    <td class="error-text">
                        @if ($log['stack'])
                            <a class="pull-right expand btn btn-default btn-xs"
                               data-display="stack{!!$key!!}"><span
                                        class="glyphicon glyphicon-search"></span></a>
                        @endif
                        {!!$log['text']!!}
                        @if (isset($log['in_file']))
                            <br/>{!!$log['in_file']!!}
                        @endif
                        @if ($log['stack'])
                            <div class="stack" id="stack{!!$key!!}"
                                 style="display: none; white-space: pre-wrap;">{!! trim($log['stack']) !!}</div>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="grid-15">
        <div class="ui vertical menu">
            @foreach($files as $file)
                <a href="/feeds/logs/{{ base64_encode($file) }}"
                   class="item @if ($current_file == $file) active @endif">
                    {{ ($date = Carbon::createFromFormat('Y m d', trim(str_replace(['-', 'laravel', '.log'], ' ', $file)))->diffInDays()) > 0 ? ($date > 1 ? $date . ' days ago' : '1 day ago') : 'Today' }}
                </a>
            @endforeach
        </div>
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script>
        $(document).ready(function () {
            $('#table-log').DataTable({
                "order": [1, 'desc'],
                "stateSave": true,
                "stateSaveCallback": function (settings, data) {
                    window.localStorage.setItem("datatable", JSON.stringify(data));
                },
                "stateLoadCallback": function (settings) {
                    var data = JSON.parse(window.localStorage.getItem("datatable"));
                    if (data) data.start = 0;
                    return data;
                }
            });
            $('.table-container').on('click', '.expand', function () {
                $('#' + $(this).data('display')).toggle();
            });
        });
    </script>
@stop