<nav class="navbar navbar-default navbar-static-top navbar-inverse" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse navbar-right navbar-ex1-collapse">
            <ul class="nav navbar-nav">
                @foreach($nav['primary'] as $navItem)
                @if($navItem->isParent())
                <li class="dropdown @if($navItem->isActive()) active @endif">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ $navItem->getTitle() }} <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        @foreach($nav['secondary'] as $subItem)
                        @if($subItem->getParent() == $navItem->getTitle())
                        <li><a href="{{ $subItem->getUrl() }}">{{ $subItem->getTitle() }}</a></li>
                        @endif
                        @endforeach
                    </ul>
                </li>
                @else
                <li @if($navItem->isActive()) class="active" @endif><a href="{{ $navItem->getUrl() }}">{{ $navItem->getTitle() }}</a></li>
                @endif
                @endforeach
            </ul>
        </div>
    </div>
</nav>
<div class="banner">
    <div class="logo">
        <a href="/">battleplugins</a>
        <div class="quote visible-lg">Simplicity is Prerequisite for Reliability. - Edsger Dijkstra</div>
    </div>
</div>
