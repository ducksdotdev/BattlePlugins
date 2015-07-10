<div class="grid-container">
    <div class="ui items">
        @foreach($rssFeed as $item)
            <div class="grid-25">
                <div class="ui segment">
                    <div class="item">
                        <div class="content">
                            <span class="header">{{ $item->get_title() }}</span>

                            <div class="description">
                                <p>
                                    Last updated <span title="{{ $item->get_date() }}">{{ (new \Carbon\Carbon($item->get_date()))->diffForHumans() }}</span>.
                                    Download the latest version from <a href="{{ $item->get_permalink() }}">Jenkins</a>.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>