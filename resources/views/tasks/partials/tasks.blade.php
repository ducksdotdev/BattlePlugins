<div class="grid-container" ng-controller="TasksCtrl">
    @include('tasks.partials.settings')
    <div class="grid-100">
        @include('tasks.partials.header')
        @include('tasks.partials.tasklist')
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