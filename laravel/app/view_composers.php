<?php
use BattleTools\UserManagement\UserGroups;
use BattleTools\Util\Subdomains;
use Illuminate\Support\Facades\Log;

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

View::composer(array('partials.head', 'partials.nav'), function($view){
    $view->with('dev', function(){
        $subdomain = Subdomains::extractSubdomain(Request::url());
        return $subdomain != 'dev';
    });
});
