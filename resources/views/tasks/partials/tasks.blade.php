<div class="grid-container">
    <div ng-controller="TasksCtrl">
        <div class="grid-100">
            <div class="field">
                <div class="ui toggle checkbox" ng-click="toggleCompleted()">
                    <input type="checkbox">
                    <label>Show completed tasks?</label>
                </div>
            </div>
        </div>
        <div class="grid-100">
            @include('tasks.partials.header')
            @include('tasks.partials.tasklist')
        </div>
    </div>
    <div class="grid-100">
        @include('tasks.partials.githeader')
        @include('tasks.partials.issuelist')
    </div>
    <div class="grid-100">
        @include('footer')
    </div>
</div>
@if(Auth::check())
    @include('tasks.modals.createTask')
@endif