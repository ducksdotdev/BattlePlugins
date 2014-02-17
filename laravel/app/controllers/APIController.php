<?php

use BattleTools\BattleTracker\Actions;
use BattleTools\UserManagement\UserGroups;
use BattleTools\UserManagement\UserSettings;
use BattleTools\Util\Jenkins;
use BattleTools\Util\ListSentence;
use BattleTools\Util\MinecraftStatus;
use BattleTools\Util\DateUtil;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Process\Process;

class APIController extends BaseController {

    public function __construct() {
        $controller = $this;

        $this->beforeFilter(function ($route, $request) use ($controller) {
            $ip = $request->getClientIp();

            if(strpos($ip, '192.30.252.') === 0 || strpos($ip, '204.232.175.') === 0){
                $ip = 'GitHub';
            }

            $port =  $request->getPort();

            $banned_server = DB::table('banned_server')->where('server',$ip)->get();
            if(count($banned_server) > 0){
                return Response::json("Your IP ($ip) is blocked from making requests");
            }

            $key = $request->header('X-API-Key');
            if ($key == null && Input::has("_key")) {
                $key = Input::get("_key");
            }

            $result = DB::table('user_settings')->where('value', $key)->where("key", "api-key")->first();
            $uid = null;
            if ($result != null) {
                $uid = $result->user_id;
            } else {
                if ($key == null && Auth::check()) {
                    $uid = Auth::user()->id;
                }
            }

            if ($uid == null) {
                return Response::json(array("Invalid API key"));
            } else {
                if (UserGroups::hasGroup($uid, UserGroups::BANNED)) {
                    return Response::json(array("Banned key."));
                }
            }

            $request = UserSettings::get($uid, 'api-request');
            if($request != null){
                $when = DateUtil::getCarbonDate($request);

                $timeout = UserSettings::get($uid, 'api-timeout');
                if($timeout == null){
                    $timeout = 60;
                }

                $when = $when->addSeconds($timeout);

                if($when > Carbon::now()){
                    $timestamp = $when->timestamp;
                    $when = $when->diffForHumans();

                    return Response::json(array('result'=>'failure','reason'=>"You may not make any requests until $when",'timestamp'=>$timestamp));
                }
            }

            UserSettings::set($uid, 'api-request', Carbon::now());
            DB::table('api_requests')->insert(array(
                'user_id' => $uid,
                'ip' => $ip,
                'requested_on' => Carbon::now(),
                'route' => '/'.$route->getPath(),
            ));

            Session::put("userIp", $ip);
            Session::put("userId", $uid);
            Session::put("userPort", $port);

        }, array('except'=>array('getDocumentation','getMinecraftFace','generateKey')));

        $this->afterFilter(function() use ($controller){
            Session::flush();
        });

        parent::setActive('Tools');
    }

    public function getDocumentation(){
        $uid = Auth::user()->id;
        $vars['docs'] = Config::get('api');
        $vars['title'] = 'API Documentation';
        $apiKey = UserSettings::get($uid, 'api-key');
        $timeout = UserSettings::get($uid, 'api-timeout');
        if($apiKey == null){
            self::generateKey();
        }

        if($timeout == null){
            UserSettings::set($uid, 'api-timeout', 60);
            $timeout = 60;
        }

        $vars['apiKey'] = $apiKey;
        $vars['username'] = UserSettings::getUsernameFromId($uid);
        $vars['timeout'] = $timeout;
        $vars['userGroups'] = UserGroups::getGroups($uid);

        return View::make('api', $vars);
    }

    public function generateKey(){
        $apiKey = strtoupper(str_random(26));
        UserSettings::set(Auth::user()->id, 'api-key', $apiKey);
    }

    public function userGenerateKey(){
        self::generateKey();
        return Redirect::to('/api');
    }

    public function getMinecraftFace($user="char",$size=256){
        function get_skin($user='char') {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'http://s3.amazonaws.com/MinecraftSkins/' . $user . '.png');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            $output = curl_exec($ch);
            $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            if($status!='200') {
                // Default Skin: http://www.minecraft.net/skin/char.png
                $output = 'iVBORw0KGgoAAAANSUhEUgAAAEAAAAAgCAMAAACVQ462AAAABGdBTUEAALGPC/xhBQAAAwBQTFRFAAAAHxALIxcJJBgIJBgKJhgLJhoKJx';
                $output .= 'sLJhoMKBsKKBsLKBoNKBwLKRwMKh0NKx4NKx4OLR0OLB4OLx8PLB4RLyANLSAQLyIRMiMQMyQRNCUSOigUPyoVKCgoPz8/JiFbMChyAFt';
                $output .= 'bAGBgAGhoAH9/Qh0KQSEMRSIOQioSUigmUTElYkMvbUMqb0UsakAwdUcvdEgvek4za2trOjGJUj2JRjqlVknMAJmZAJ6eAKioAK+vAMzM';
                $output .= 'ikw9gFM0hFIxhlM0gVM5g1U7h1U7h1g6ilk7iFo5j14+kF5Dll9All9BmmNEnGNFnGNGmmRKnGdIn2hJnGlMnWpPlm9bnHJcompHrHZaq';
                $output .= 'n1ms3titXtnrYBttIRttolsvohst4Jyu4lyvYtyvY5yvY50xpaA////AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA';
                $output .= 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA';
                $output .= 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA';
                $output .= 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA';
                $output .= 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA';
                $output .= 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA';
                $output .= 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAPSUN6AAAAQB0Uk5T////////////////////////////////////////';
                $output .= '/////////////////////////////////////////////////////////////////////////////////////////////////////////';
                $output .= '/////////////////////////////////////////////////////////////////////////////////////////////////////////';
                $output .= '//////////////////////////////////////////////////////////////////////////////////////////AFP3ByUAAAAYdEV';
                $output .= 'YdFNvZnR3YXJlAFBhaW50Lk5FVCB2My4zNqnn4iUAAAKjSURBVEhLpZSLVtNAEIYLpSlLSUITLCBaGhNBQRM01M2mSCoXNUURIkZFxQvv';
                $output .= '/wz6724Wij2HCM7J6UyS/b+dmZ208rsww6jiqo4FhannZb5yDqjaNgDVwE/8JAmCMqF6fwGwbU0CKjD/+oAq9jcM27gxAFpNQxU3Bwi9A';
                $output .= 'jy8fgmGZuvaGAcIuwFA12CGce1jJESr6/Ot1i3Tnq5qptFqzet1jRA1F2XHWQFAs3RzwTTNhQd3rOkFU7c0DijmohRg1TR9ZmpCN7/8+P';
                $output .= 'X954fb+sTUjK7VLKOYi1IAaTQtUrfm8pP88/vTw8M5q06sZoOouSgHEDI5vrO/eHK28el04yxf3N8ZnyQooZiLfwA0arNb6d6bj998/+v';
                $output .= 'x8710a7bW4E2Uc1EKsEhz7WiQBK9eL29urrzsB8ngaK1JLDUXpYAkGSQH6e7640fL91dWXjxZ33138PZggA+Sz0WQlAL4gmewuzC1uCen';
                $output .= 'qXevMPWc9XrMX/VXh6Hicx4ByHEeAfRg/wtgSMAvz+CKEkYAnc5SpwuD4z70PM+hUf+4348ixF7EGItjxmQcCx/Dzv/SOkuXAF3PdT3GI';
                $output .= 'ujjGLELNYwxhF7M4oi//wsgdlYZdMXCmEUUSsSu0OOBACMoBTiu62BdRPEjYxozXFyIpK7IAE0IYa7jOBRqGlOK0BFq3Kdpup3DthFwP9';
                $output .= 'QDlBCGKEECoHEBEDLAXHAQMQnI8jwFYRQw3AMOQAJoOADoAVcDAh0HZAKQZUMZdC43kdeqAPwUBEsC+M4cIEq5KEEBCl90mR8CVR3nxwC';
                $output .= 'dBBS9OAe020UGnXb7KcxzPY9SXoEEIBZtgE7UDgBKyLMhgBS2YdzjMJb4XHRDAPiQhSGjNOxKQIZTgC8BiMECgarxprjjO0OXiV4MAf4A';
                $output .= '/x0nbcyiS5EAAAAASUVORK5CYII=';
                $output = base64_decode($output);
            }
            return $output;
        }

        $skin = get_skin($user);

        $im = imagecreatefromstring($skin);
        $av = imagecreatetruecolor($size,$size);
        imagecopyresized($av,$im,0,0,8,8,$size,$size,8,8);    // Face
        imagecolortransparent($im,imagecolorat($im,63,0));    // Black Hat Issue
        imagecopyresized($av,$im,0,0,40,8,$size,$size,8,8);   // Accessories
        $image = imagepng($av);
        return Response::make($image.'')->header('Content-Type', 'image/png');
    }

    public function getBlog($id='all'){
        if($id == 'all'){
            $blog = DB::table('blog')->orderBy('id', 'desc')->get();
        }else if($id == 'newest'){
            $blog = DB::table('blog')->orderBy('id', 'desc')->first();
        }else{
            $blog = DB::table('blog')->where('id', $id)->first();
        }

        if(count($blog) == 0){
            return Response::json(array('error'=>'Not Found'));
        }

        return Response::json($blog);
    }

    public function getPaste($id='all',$author=null){
        $author = UserSettings::getIdFromUsername($author);
        $pastes = DB::table('pastes')->where('private', false)->where('hidden_on', '0000-00-00 00:00:00')->orderBy('created_on', 'desc')->select(
            'id',
            'author',
            'title',
            'content',
            'lang',
            'created_on'
        );

        if($id == 'all'){
            if($author == null){
                $pastes = $pastes->get();
            }else{
                $pastes = $pastes->where('author', $author)->get();
            }
        }else{
            if($author == null){
                $pastes = $pastes->where('id', $id)->get();
            }else{
                $pastes = $pastes->where('id', $id)->where('author', $author)->get();
            }
        }

        return Response::json($pastes);
    }

    public function createPaste(){
        if(Input::has('title')){
            $title = Input::get('title');
        }else{
            $title = '';
        }

        $content = Input::get('content');

//        if(Input::has('compressed') && Input::get('compressed') == 'true'){
//            $content = gzuncompress($content);
//        }

        if(!Input::has('lang')){
            $lang = '';
        }else{
            $lang = Input::get('lang');
        }

        $input = array(
            'title' => $title,
            'content' => $content,
            'lang' => $lang
        );

        $rules = array(
            'title' => "max:132",
            'content' => "required",
            'lang' => "max:11"
        );

        $messages = array(
            "title.max" => "Your title exceeds 132 characters.",
            "content.required" => "You left the content param blank.",
            "lang.max" => "Your lang param is exceeds 11 characters"
        );

        $validator = Validator::make($input,$rules,$messages);

        if($validator->fails()){
            return Response::json(array('result'=>'failure','reason'=>$validator->messages()->all(),'input'=>Input::all()));
        }

        $deletionDate = Input::get('delete');

        if(Input::has('delete')){
            $deletionDate = date("Y-m-d H:i:s", strtotime($deletionDate));
        }else{
            $deletionDate = '0000-00-00 00:00:00';
        }

        $private = Input::has('private');
        $id = str_random(6);

        $paste = DB::table('pastes')->insertGetId(array(
            'id' => $id,
            'author' => Session::get('userId'),
            'title' => $title,
            'content' => $content,
            'private' => $private,
            'lang' => $lang,
            'created_on' => Carbon::now(),
            'hidden_on' => $deletionDate
        ));

        return Response::json(array('id'=>$id));
    }

    public function deletePaste($id){
        $paste = DB::table('pastes')->where('id', $id)->where((function($query)
        {
            $query->where('hidden_on', '0000-00-00 00:00:00')
                ->orWhere('hidden_on', '>', Carbon::now());

        }));

        if(count($paste->get()) == 0){
            return Response::json('Paste not found');
        }

        $uid = $paste->get()->author;
        $usergroups = UserGroups::getGroups(Session::get('userId'));
        if(!($uid == Session::get('userId') || in_array(UserGroups::ADMINISTRATOR, $usergroups))){
            return Response::json('Invalid permissions');
        }

        $paste->update(array(
            'hidden_on' => Carbon::now()
        ));

        return Response::json('success');
    }

    public function setBattleTracker(){
        $action = Input::get('action');
        $action_by = Input::get('action_by');
        $action_to = Input::get('action_to');

        $input = array(
            'action' => $action,
            'action_by' => $action_by,
            'action_to' => $action_to
        );

        $rules = array(
            'action' => "required|integer",
            'action_by' => "required|max:16",
            'action_to' => "required|max:16"
        );

        $messages = array(
            "action.required" => "action is required",
            "action.integer" => "action must be an integer",
            "action_by.required" => "action_by is required",
            "action_by.max" => "action_by exceeds 16 characters",
            "action_to.required" => "action_to is required",
            "action_to.max" => "action_to exceeds 16 characters",
        );

        $validator = Validator::make($input,$rules,$messages);

        if($validator->fails()){
            return Response::json($validator->messages()->all());
        }

        $ip = Session::get('userIp');
        if(!in_array($action, Actions::getAll())){
            return Response::json('Invalid action');
        }

        $server = new MinecraftStatus($ip, Session::get('userPort'));

        if(!$server->Online){
            return Response::json('Not a Minecraft Server');
        }

        DB::table('battletracker')->insert(array(
            'action' => $action,
            'action_by' => $action_by,
            'action_to' => $action_to,
            'server' => $ip.':'.Session::get('userPort'),
            'created_on' => Carbon::now()
        ));

        return Response::json(array("action"=>'completed','server'=>$ip.':'.Session::get('userPort')));
    }

    public function getBattleTracker($username, $action=null){
        if($action != null){
            $action = Input::get('action');

            if(!in_array($action, Actions::getAll())){
                return Response::json("Invalid action key");
            }

            $result = DB::table('battletracker')->where('action_by', $username)->orWhere('action_to', $username)->where('action', $action)->get();
        }else{
            $result = DB::table('battletracker')->where('action_by', $username)->orWhere('action_to', $username)->get();
        }

        return Response::json($result);
    }

    public function getJenkins($plugin){
        $plugin = DB::table('plugins')->where('name', $plugin)->first();
        if(count($plugin) == 0){
            return Response::json('That plugin doesn\'t exist');
        }

        $url = 'http://ci.battleplugins.com';
        $build = Jenkins::getLatestBuild($url, $plugin->name);

        return Response::json(array('job'=>$url.'job/'.$plugin->name,'build'=>$build['build'],'build_link'=>$build['url']));

    }

    public function deployWebsite(){
        $uid = Session::get('userId');
        $groups = UserGroups::getGroups($uid);

        if(!in_array(UserGroups::DEVELOPER, $groups)){
            return Response::json("You are not a developer");
        }

        Artisan::call("down");

        $process = new Process('./deploy.sh', '/home/battleplugins/git/BattlePlugins');
        $process->start();

        while($process->isRunning()){}

        Artisan::call("up");

        return Response::json(array('output'=>$process->getOutput(),'errors'=>$process->getErrorOutput()));
    }
}
