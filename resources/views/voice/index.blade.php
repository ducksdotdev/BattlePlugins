@extends('layouts.voice')
@section('content')
    <div class="ui divided list" ng-controller="BattleTeamSpeakCtrl">
        <div class="item" ng-bind-html="to_trusted(data)">
        </div>
    </div>
    <script type="text/javascript">
        var BattleTeamSpeak = angular.module('BattleTeamSpeak', []);
        BattleTeamSpeak.controller("BattleTeamSpeakCtrl", function ($scope, $http, $sce, $interval) {
            $scope.to_trusted = function (html_code) {
                return $sce.trustAsHtml(html_code);
            };

            var get = function () {
                $http.get("/feed").success(function (data) {
                    $scope.data = data;
                });
            };

            get();
            $interval(function () {
                get();
            }, 2000);
        });
    </script>
@stop