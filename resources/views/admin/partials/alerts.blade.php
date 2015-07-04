@if(count($alerts) > 0)
    <div class="grid-100 grid-parent alerts">
        <div class="grid-85 pull-right" ng-controller="AlertsCtrl" ng-class="alert['color']">
            <table class="updates">
                <tbody>
                <tr>
                    <td width="10%" class="text-center"><h3>Alerts: </h3></td>
                    <td width="80%" ng-bind="alert['content']"></td>
                    <td width="10%" class="text-center">
                        <i ng-click="prevAlert()" ng-hide="alerts.length == 1" class="icon caret left pointer"></i>
                        {!! Form::open(['id'=>'removeAlert', 'class' => 'inline']) !!}
                        <button class="ui button circular icon mini primary">
                            <i class="icon remove"></i>
                        </button>
                        {!! Form::close() !!}
                        <i ng-click="nextAlert()" ng-hide="alerts.length == 1" class="icon caret right pointer"></i>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@elseif($alert_bar)
    <div class="grid-100 grid-parent alerts">
        <div class="updates"></div>
    </div>
@endif