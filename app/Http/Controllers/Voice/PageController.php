<?php namespace App\Http\Controllers\Voice;

use App\Http\Controllers\Controller;
use TeamSpeak3;
use TeamSpeak3_Viewer_Html;

class PageController extends Controller {

    public function index() {
        return view('voice.index');
    }
    
    public function feed() {

        $ts3 = TeamSpeak3::factory("serverquery://voice:5Z0dXOXf@23.226.234.128:10011/?server_port=9987");
        $ts3 = $ts3->getViewer(new TeamSpeak3_Viewer_Html("assets/img/ts/viewer/", "assets/img/ts/flags/", "data:image"));

        return $ts3;
    }

}