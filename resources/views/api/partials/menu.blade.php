<div class="grid-25 hide-on-mobile hide-on-tablet ui sticky">
    <div class="ui styled fluid accordion">
        <div class="title">
            <i class="dropdown icon"></i> API Documentation
        </div>
        <div class="content">
            <p>
                <a href="#header"> Top</a>
            </p>
            <p>
                <a href="#authentication"> Authentication</a>
            </p>
        </div>
        @foreach($docs as $docType)
            <div class="title">
                <i class="dropdown icon"></i> {{ ucfirst($docType['name']) }}
            </div>
            <div class="content">
                @foreach($docType['methods'] as $doc)
                    <p>
                        <a href="#{{ $docType['name'] }}-{{ $doc['title'] }}">{{ $doc['title'] }}</a>
                    </p>
                @endforeach
            </div>
        @endforeach
    </div>
</div>