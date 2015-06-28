<div class="grid-container hello">
    <div class="grid-50 tablet-grid-50 hide-on-mobile">
        @if(Auth::check())
            Hello, {{ Auth::user()->displayname }}. Welcome to BattleTasks!
        @endif
        &nbsp;
    </div>
    <div class="grid-50 tablet-grid-50 mobile-grid-100 text-right">
        <div class="field">
            <div class="ui toggle checkbox" ng-click="toggleCompleted()">
                <input type="checkbox">
                <label>Show completed tasks?</label>
            </div>
        </div>
    </div>
</div>