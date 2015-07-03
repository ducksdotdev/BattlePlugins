var BattleTasks = angular.module('BattleTasks', ['ngSanitize'], function ($interpolateProvider) {
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');
    }
).filter('nl2br', ['$sanitize', function ($sanitize) {
        var tag = (/xhtml/i).test(document.doctype) ? '<br />' : '<br>';
        return function (msg) {
            msg = (msg + '').replace(/(\r\n|\n\r|\r|\n|&#10;&#13;|&#13;&#10;|&#10;|&#13;)/g, tag + '$1');
            return $sanitize(msg);
        };
    }]
);

BattleTasks.controller("TasksCtrl", function ($scope, $http) {
    $scope.showCompleted = false;

    $scope.toggleCompleted = function () {
        $scope.showCompleted = !$scope.showCompleted;
    };

    $scope.haveTasks = false;

    $scope.setHighlighted = function (id) {
        $scope.highlighted = id;
    };

    $scope.getHighlighted = function () {
        var url = document.location.href;
        var index = url.indexOf('#task');

        if (index > -1) {
            $scope.setHighlighted(url.substr(index + 5));
        }
    };

    $scope.getHighlighted();
});