<?php

use BattleTools\UserManagement\UserSettings;

class DeveloperController extends BaseController {

    public function __construct() {
        parent::setActive('Developer');
        $this->beforeFilter('auth.developer');
    }
}
