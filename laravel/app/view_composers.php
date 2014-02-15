<?php
use BattleTools\UserManagement\UserGroups;
use Carbon\Carbon;

View::composer('partials.nav', function($view){
    $view->with('nav', BaseController::getNavigation());
});

View::composer(array('partials.head', 'partials.scripts'), function($view){
    $view->with('admin', function(){
        if(Auth::check()){
            $uid = Auth::user()->id;
            return UserGroups::hasGroup($uid, UserGroups::ADMINISTRATOR);
        }else{
            return false;
        }
    });
});
