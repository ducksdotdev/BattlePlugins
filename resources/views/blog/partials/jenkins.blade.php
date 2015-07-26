@if($download_server && $jenkins)
    <div class="grid-container">
        <div class="grid-100 grid-parent">
            <div class="ui items">
                @foreach($jenkins as $build)
                    <div class="grid-25">
                        <div class="ui segment">
                            <div class="item">
                                <div class="content">
                                    <strong>
                                        {{ $build->getJob()->getName() }}
                                        {{ $build->getVersion() }}
                                    </strong>

                                    <span class="pull-right">
                                        <a href="{{ $build->getDownloadUrl() }}"
                                           class="ui button green mini circular icon"><i class="icon download"></i></a>
                                    </span>

                                    <div class="description">
                                        Last updated
                                            <span title="{{ $build->createdAt() }}">
                                        {{ $build->createdAt()->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif