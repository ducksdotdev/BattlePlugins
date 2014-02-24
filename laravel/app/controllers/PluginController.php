<?php

class PluginController extends BaseController {

    public function __construct(){
        $this->beforeFilter('auth.administrator');
    }

}