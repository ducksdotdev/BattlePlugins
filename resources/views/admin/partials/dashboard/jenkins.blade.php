<div class="grid-100">
    <h3>Latest CI Builds <a href="http://ci.battleplugins.com"><i class="icon external"></i></a></h3>
</div>
@foreach($rssFeed as $item)
    <div class="grid-100">
        <div class="ui small message {{ str_contains($item->get_title(), 'broken') ? 'red' : 'green' }}">
            <div class="header">
                <a href="{{ $item->get_permalink()}}">{{ $item->get_title() }}</a>
            </div>
        </div>
    </div>
@endforeach