var BattleTasks = angular.module('BattleTasks', []);

BattleTasks.controller("TasksCtrl", function ($scope) {
    $scope.showCompleted = false;
    $scope.haveTasks = false;

    $scope.toggleCompleted = function () {
        $scope.showCompleted = !$scope.showCompleted;
    };

    $scope.setHighlighted = function (id) {
        $scope.highlighted = id;
    };

    $scope.getHighlighted = function () {
        var url = document.location.href;
        var index = url.indexOf('#');

        if (index > -1) {
            $scope.setHighlighted(url.substr(index + 1));
        }
    };

    $scope.getHighlighted();
});