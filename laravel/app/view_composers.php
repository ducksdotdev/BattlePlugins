<?php
use BattleTools\UserManagement\UserGroups;
use BattleTools\Util\Deploy;
use BattleTools\Util\Subdomains;

View::composer('partials.nav', function($view){
    $view->with('nav', BaseController::getNavigation());
});

View::composer(array('partials.head', 'partials.scripts'), function($view){
    if(Auth::check()){
        $uid = Auth::user()->id;
        $admin = UserGroups::hasGroup($uid, UserGroups::ADMINISTRATOR);
    }else{
        $admin = false;
    }
    $view->with('admin', $admin);
});

View::composer(array('partials.head', 'partials.scripts', 'partials.nav'), function($view){
    $view->with('dev', Deploy::isDeveloperMode());
});
