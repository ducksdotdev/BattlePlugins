<?php namespace App\Http\Controllers;

use TeamSpeak3;
use TeamSpeak3_Viewer_Html;

/**
 * Class VoiceController
 * @package App\Http\Controllers
 */
class VoiceController extends Controller {

    /**
     * @return \Illuminate\View\View
     */
    public function getIndex() {
        return view('voice.index');
    }

    /**
     * @return \TeamSpeak3_Adapter_Abstract
     */
    public function getFeed() {
        $ts3 = TeamSpeak3::factory("serverquery://" . env("TS_USER") . ":" . env("TS_PASS") . "@" . env('TS_URL', 'localhost') . ":10011/?server_port=9987");
        $ts3 = $ts3->getViewer(new TeamSpeak3_Viewer_Html("assets/img/ts/viewer/", "assets/img/ts/flags/", "data:image"));

        return $ts3;
    }

}