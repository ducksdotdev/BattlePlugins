var BattleAdmin = angular.module('BattleAdmin', [], function ($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});

BattleAdmin.controller("AlertsCtrl", function ($scope, $http) {
    $scope.alerts = [];
    $scope.alert = [];
    $scope.alertId = 0;

    $http.get('/tools/alert/json').success(function (data) {
        $scope.alerts = data;
        $scope.alert = data[0];
        $("#removeAlert").attr('action', '/tools/alert/delete/' + data[0]['id'])
    });

    $scope.nextAlert = function () {
        $scope.alertId++;
        if ($scope.alertId >= $scope.alerts.length)
            $scope.alertId = 0;

        $scope.alert = $scope.alerts[$scope.alertId];
    };

    $scope.prevAlert = function () {
        $scope.alertId--;
        if ($scope.alertId < 0)
            $scope.alertId = $scope.alerts.length - 1;

        $scope.alert = $scope.alerts[$scope.alertId];
    };

});

BattleAdmin.controller("ServerStatusCtrl", function ($scope, $http, $sce, $interval) {
    $scope.serverstats = '';

    var poll = function () {
        $http.get('/tools/serverstats').success(function (data) {
            $scope.serverstats = $sce.trustAsHtml(data);
        });
    };

    poll();
    $interval(poll, 1000);
});

$(function () {
    $('.ui.checkbox').checkbox();

    var menu = $('#mobileMenu').sidebar('setting', 'transition', 'overlay');

    $("#openMenu").click(function () {
        menu.sidebar('show');
    });
});