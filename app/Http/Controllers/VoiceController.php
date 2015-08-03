<?php namespace App\Http\Controllers;

use TeamSpeak3;
use TeamSpeak3_Viewer_Html;

class VoiceController extends Controller {

    public function getIndex() {
        return view('voice.index');
    }

    public function getFeed() {
        $ts3 = TeamSpeak3::factory("serverquery://" . env("TS_USER") . ":" . env("TS_PASS") . "@" . env('TS_URL', 'localhost') . ":10011/?server_port=9987");
        $ts3 = $ts3->getViewer(new TeamSpeak3_Viewer_Html("assets/img/ts/viewer/", "assets/img/ts/flags/", "data:image"));

        return $ts3;
    }

}