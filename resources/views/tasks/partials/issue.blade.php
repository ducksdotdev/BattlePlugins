<div class="item @if($issue->state != 'open')
						completed
					@endif" id="g{{ $issue->id }}" ng-class="{highlighted: 'g{{ $issue->id }}' == highlighted}"
     ng-hide="{{ $issue->state != 'open' }} && !showCompleted">
    <div class="content grid-100">
        <div class="header">
            <a href="#g{{ $issue->id }}" ng-click="setHighlighted('g{{ $issue->id }}')"><i class="icon linkify"></i></a>
            <a href="{{ $issue->html_url }}"><i class="icon external"></i></a>
            [{{ $issue-> }}] {{$issue->title}}
            <small>Assigned
                @if($issue->assignee)
                    to <span class="name">{{ $issue->assignee->login }}</span>
                @endif
                by <span
                        class="name">{{ $issue->user->login }}</span> {{ (new \Carbon\Carbon($issue->created_at))->diffForHumans() }}
            </small>
        </div>
        <div class="description editable">
            @if(count($issue->labels) > 0)
                <p>
                    @foreach($issue->labels as $label)
                        <span class="ui label" style="background-color: #{{ $label->color }}">{{ $label->name }}</span>
                    @endforeach
                </p>
            @endif
            {!! Markdown::convertToHTML(strip_tags($issue->body)) !!}
        </div>
    </div>
</div>