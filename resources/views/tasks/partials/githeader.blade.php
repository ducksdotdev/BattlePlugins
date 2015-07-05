<div class="task-header">
    <div class="grid-container">
        <div class="grid-85 tablet-grid-85 mobile-grid-85">
            <h2><i class="icon github"></i> issues</h2>
        </div>
        <div class="grid-15 tablet-grid-15 mobile-grid-15 text-right text-middle actions">
            @if(Auth::check())
                <a href="/refreshIssues" class="circular small ui green icon button"><i class="icon refresh"></i></a>
            @endif
            <button id="minimizeIssues" class="circular small ui primary icon button"><i class="icon compress"></i></button>
        </div>
    </div>
</div>