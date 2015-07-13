<!DOCTYPE html>
<html lang="en" ng-app="BattleTasks">
<head>
    @include('shorturls.partials.head')
    <link rel="stylesheet" href="/assets/css/styles.css" type="text/css"/>
</head>
<body>
<div class="grid-container">
    <div class="grid-65 grid-parent grid-center">
        <div class="task-header">
            <div class="grid-container">
                <div class="grid-100">
                    <h2>bplug.in</h2>
                </div>
            </div>
        </div>
        @include('shorturls.partials.createform')
        @include('footer')
    </div>
</div>
</body>
</html>