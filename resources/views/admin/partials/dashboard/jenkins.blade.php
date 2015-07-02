<h3>Latest CI Builds</h3>
@foreach($rssFeed as $item)
    <div class="grid-100">
        <div class="ui small message {{ str_contains($item->get_title(), 'broken') ? 'red' : 'green' }}">
            <div class="header">
                <a href="{{ $item->get_permalink()}}">{{ $item->get_title() }}</a>
            </div>
        </div>
    </div>
@endforeach