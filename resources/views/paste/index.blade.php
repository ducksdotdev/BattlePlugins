<!DOCTYPE html>
<html lang="en" ng-app="BattleTasks">
<head>
    @include('shorturls.partials.head')
    <link rel="stylesheet" href="/assets/css/styles.css" type="text/css"/>
</head>
<body>
<div class="grid-100 text-right">
    <a id="logoutButton" href="/logout" class="ui button">Logout</a>
</div>
<div class="grid-container">
    <div class="grid-65 grid-parent grid-center">
        <div id="task-header">
            <div class="grid-container">
                <div class="grid-85">
                    <h2>battlepaste</h2>
                </div>
                <div class="grid-15 tablet-grid-15 mobile-grid-15 text-right text-middle actions">
                    @if(Auth::check())
                        <button id="createPaste" class="circular small ui positive icon button">
                            <i class="icon plus"></i>
                        </button>
                    @endif
                    &nbsp;
                </div>
            </div>
        </div>
        <div class="ui divided list">
            <div class="item">
                <div class="content @if(Auth::check()) grid-90 @else grid-100 @endif">
                    <div class="header">
                        <a href="#">Paste Title</a>
                    </div>
                    <div class="description">Created 3 days ago. Last modified 5 minutes ago.</div>
                </div>
                @if(Auth::check())
                    <div class="actions grid-10 text-right">
                        <a href="#"
                           class="delete-paste pull-left circular red small ui icon button">
                            <i class="icon trash"></i>
                        </a>
                    </div>
                @endif
            </div>
        </div>
        @if(Auth::check())
            @include('paste.modals.createPaste')
        @endif
        @include('footer')
    </div>
</div>
</body>
</html>