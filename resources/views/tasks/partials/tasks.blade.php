<div class="grid-container">
    <div class="grid-65 grid-parent grid-center">
        <div ng-controller="TasksCtrl">
            @include('tasks.partials.settings')
            @include('tasks.partials.header')
            @include('tasks.partials.tasklist')
            @if(Auth::check())
                @include('tasks.modals.createTask')
            @endif
        </div>
        @include('footer')
    </div>
</div>