<?php

use BattleTools\UI\NavigationItem;
use BattleTools\UserManagement\UserGroups;
use BattleTools\UserManagement\UserSettings;
	use BattleTools\Util\Deploy;

	class BaseController extends Controller {
    private static $activeNavTitle = null;

    protected function setupLayout()
    {
        if ( ! is_null($this->layout))
        {
            $this->layout = View::make($this->layout);
        }
    }

    public static function getNavigation(){

        $navigation['primary'] = array(
            new NavigationItem("Home", "/"),
        );

        $navigation['secondary'] = array();

        array_push($navigation['primary'], new NavigationItem("Resources", '#', true));
        array_push($navigation['secondary'], new NavigationItem('Plugins', '/plugins', false, 'Resources'));
        array_push($navigation['secondary'], new NavigationItem('Statistics', '/statistics', false, 'Resources'));
        array_push($navigation['secondary'], new NavigationItem('BattleWiki', '/w', false, 'Resources'));
        array_push($navigation['secondary'], new NavigationItem('Jenkins CI', '/ci', false, 'Resources'));
        array_push($navigation['secondary'],new NavigationItem("Donate", "https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=H7AGURDPKJ7BW", false, 'Resources'));

        if(Auth::check()){
            $uid = Auth::user()->id;
            $groups = UserGroups::getGroups($uid);

            $username = UserSettings::getUsernameFromId($uid);

            array_push($navigation['primary'], new NavigationItem("Tools", '#', true));
            array_push($navigation['secondary'], new NavigationItem('BattlePaste', '/paste/create', false, 'Tools'));
            array_push($navigation['secondary'], new NavigationItem('API', '/api', false, 'Tools'));

            if(in_array(UserGroups::DEVELOPER, $groups)){
                array_push($navigation['primary'], new NavigationItem("Developer", '#', true));
		        array_push($navigation['secondary'], new NavigationItem("Manage Plugin", '/plugins/manage', false, "Developer"));
	        }

            if(in_array(UserGroups::ADMINISTRATOR, $groups)){
                array_push($navigation['primary'], new NavigationItem("Administration", '#', true));
                array_push($navigation['secondary'], new NavigationItem("Blog", '/admin/blog', false, "Administration"));
                array_push($navigation['secondary'], new NavigationItem("Manage Users", '/admin/manageUsers', false, "Administration"));
	            array_push($navigation['secondary'], new NavigationItem("Statistics", '/administrator/statistics', false, "Administration"));
	            array_push($navigation['secondary'], new NavigationItem("Logs", '/logviewer', false, "Administration"));
            }

            array_push($navigation['primary'], new NavigationItem($username, "#", true));
            array_push($navigation['secondary'], new NavigationItem("Settings", '/user/settings',  false, $username));
            array_push($navigation['secondary'], new NavigationItem("Profile", '/profile',  false, $username));
            array_push($navigation['secondary'], new NavigationItem("Logout", '/logout',  false, $username));
        }else{
            array_push($navigation['primary'], new NavigationItem("Login", '/login'));
        }

        foreach($navigation['primary'] as $navItem){
            if(starts_with($navItem->getTitle(), self::$activeNavTitle)){
                $navItem->setActive();
            }
        }

        return $navigation;
    }

    public static function setActive($title) {
        self::$activeNavTitle = $title;
    }
}
