<!DOCTYPE html>
<html lang="en" ng-app="BattleTeamSpeak">
<head>
    <meta charset="utf-8">
    @include('mobilecolor')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TeamSpeak :: BattlePlugins Voice Chat</title>
    <link rel="icon" href="/assets/img/bp.png"/>
    <!--        Styles -->
    <link rel="stylesheet" href="/assets/css/semantic.css">
    <link rel="stylesheet" href="/assets/css/styles.css" type="text/css"/>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.12.0/components/icon.min.css"/>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/unsemantic/0/unsemantic-grid-responsive.css">
    <!--        End Styles -->
    <!--        Scripts -->
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/angular.js/1.3.11/angular.min.js"></script>
    <!--        End Scripts -->
    <style>
        .query {
            display: none;
        }
    </style>
</head>
<body>
<div class="grid-container">
    <div class="grid-65 grid-parent grid-center">
        <div class="task-header">
            <div class="grid-container">
                <div class="grid-85 tablet-grid-85 mobile-grid-85">
                    <h2>teamspeak</h2>
                </div>
                <div class="grid-15 tablet-grid-15 mobile-grid-15 text-right text-middle actions">
                    <a href="ts3://voice.battleplugins.com" class="circular small ui primary icon button"><i
                                class="icon forward mail"></i></a>
                </div>
            </div>
        </div>
        <div class="ui divided list" ng-controller="BattleTeamSpeakCtrl">
            <div class="item" ng-bind-html="to_trusted(data)">
            </div>
        </div>
        @include('footer')
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
        }

        get();
        $interval(function () {
            get();
        }, 2000);
    });
</script>
</body>
</html>