<div id="issueList">
    @if(!$tasks)
        <div class="have-tasks">
            There are no issues to show!
        </div>
    @else
        <div class="ui divided list">
            @foreach($gitIssues as $issue)
                @include('tasks.partials.issue')
            @endforeach
        </div>
    @endif
</div>