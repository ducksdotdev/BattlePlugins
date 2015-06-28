<div id="task-header">
    <div class="grid-container">
        <div class="grid-85 tablet-grid-85 mobile-grid-85">
            <h2>battletasks</h2>
        </div>
        <div class="grid-15 tablet-grid-15 mobile-grid-15 text-right text-middle actions">
            @if(Auth::check())
                <button id="createTask" class="circular small ui positive icon button">
                    <i class="icon plus"></i>
                </button>
            @endif
            <a href="/" id="refresh" class="circular small ui primary icon button"><i
                        class="icon refresh"></i></a>
        </div>
    </div>
</div>