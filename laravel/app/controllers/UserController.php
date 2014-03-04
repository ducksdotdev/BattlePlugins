<?php

use BattleTools\UserManagement\UserGroups;
use BattleTools\UserManagement\UserSettings;
use BattleTools\Util\DateUtil;
use BattleTools\Util\EmailUtil;
use BattleTools\Util\ListSentence;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class UserController extends BaseController {
    public function getLoginPage(){
        parent::setActive('Login');
        $vars['title'] = "Login";
        return View::make('login', $vars);
    }

    public function loginUser(){
        $user = array(
            'username' => Input::get('username'),
            'password' => Input::get('password'),
        );

        if(Input::has('rememberme')){
            $rememberme = true;
        }else{
            $rememberme = false;
        }

        if (Auth::attempt($user, $rememberme)) {
            UserSettings::delete(Auth::user()->id, 'reset');

            return Response::json(array('result'=>'success'));
        }

        return Response::json(array('result'=>'failure','reason'=>'Your username/password combination was incorrect.'));
    }

    public function logoutUser(){
        UserSettings::delete(Auth::user()->id, 'reset');
        Auth::logout();
        return Redirect::to('/login');
    }

    public function getRegistrationPage(){
        $vars['title'] = 'Registration';
        return View::make("register", $vars);
    }

    public function register(){
        $username = Input::get("username");
        $email = Input::get("email");
        $password = Input::get("password");
        $passconf = Input::get("password2");
        $recaptcha = Input::get("recaptcha_response_field");

        if(!Input::has("tos")){
            return Response::json(array("result"=>"failure","reason"=>"You must agree to the Terms of Service and Privacy Policy in order to register."));
        }

        $input = array(
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'passconf' => $passconf,
            'recaptcha_response_field' => $recaptcha
        );

        $rules = array(
            'username' => "required|max:16",
            'email' => "required|email",
            'password' => "required|min:6",
            'passconf' => "required|min:6",
            'recaptcha_response_field' => 'required|recaptcha',
        );

        $messages = array(
            "username.required" => "You left the username field blank.",
            "username.max" => "Your username is longer than 16 characters.",
            "email.required" => "You left the email field blank.",
            "email.email" => "You didn't enter a proper email.",
            "password.required" => "You left the password field blank.",
            "passconf.required" => "You left the password confirmation field blank.",
            "password.min" => "Your password is shorter than 6 characters.",
            "passconf.min" => "Your password confirmation is shorter than 6 characters.",
            "recaptcha_response_field.required" => "Human verification (reCAPTCHA) is blank.",
            "recaptcha_response_field.recaptcha" => "Human verification (reCAPTCHA) is incorrect."
        );

        $validator = Validator::make($input,$rules,$messages);
        if($validator->fails()){
            $reason = "<p>We couldn't register your account! This is because:</p><p><ul>";

            foreach($validator->messages()->all() as $message){
                $reason .= "<li>$message</li>";
            }

            $reason .= "</ul></p>";

            return Response::json(array("result"=>"failure","reason"=>$reason));
        }

        $users = DB::table("users")->where('username', $username)->get();
        if(count($users) > 0){
            return Response::json(array("result"=>"failure","reason"=>"A user with that name already exists."));
        }

        if($password != $passconf){
            return Response::json(array("result"=>"failure","reason"=>"Your passwords do not match."));
        }

        $minecraft = file_get_contents("https://minecraft.net/haspaid.jsp?user=$username");
        if(!$minecraft){
            return Response::json(array("result"=>"failure","reason"=>"You did not enter a proper Minecraft name. Minecraft names are case sensitive."));
        }

        $user = array(
            'username' => $username,
            'password' => $password
        );

        $uid = DB::table("users")->insertGetId(
            array(
                "username" => $username,
                "password" => Hash::make($password),
            )
        );

        UserSettings::set($uid, "email", $email);

        if(Input::has('newsletter')){
            UserSettings::set($uid, 'newsletter', 'true');
        }else{
            UserSettings::set($uid, 'newsletter', 'false');
        }

        UserGroups::addGroup($uid, UserGroups::USER);

        return Response::json(array("result"=>"success"));
    }

    public function getProfile($name=null){
        $own = false;

        if(empty($name)){
            if(!Auth::check()){
                return Redirect::to("/");
            }

            $name = UserSettings::getUsernameFromId(Auth::user()->id);
        }

        $own = Auth::check() && Auth::user()->id == UserSettings::getIdFromUsername($name);

        if(Auth::check()){
            parent::setActive(UserSettings::getUsernameFromId(Auth::user()->id));
        }

        $admin = Auth::check() && UserGroups::hasGroup(Auth::user()->id, UserGroups::ADMINISTRATOR);

        $uid = UserSettings::getIdFromUsername($name);

        $vars['title'] = $name."'s Profile";
        $vars['username'] = $name;
        $vars['own'] = $own;
        $vars['email'] = UserSettings::get($uid, 'email');
        $vars['admin'] = $admin;

        $vars['pastes'] = DB::table('pastes')->where('author', $uid)->where((function($query)
        {
            $query->where('hidden_on', '0000-00-00 00:00:00')
                ->orWhere('hidden_on', '>', Carbon::now());

        }))->orderBy('created_on', 'desc')->take(6)->get();

        $prettyTime = array();
        foreach($vars['pastes'] as $paste){
            $prettyTime[$paste->id] = DateUtil::getDateHtml($paste->created_on);
        }

        $vars['prettyTime'] = $prettyTime;

        $groups = array();
        foreach(UserGroups::getGroups($uid) as $group){
            $groups[$group] = UserGroups::getGroupName($group);
        }

        $vars['ranks'] = ListSentence::toSentence($groups);

        return View::make("profile", $vars);
    }

    public function getSettingsPage(){
        $vars['title'] = 'Settings';

        $uid = Auth::user()->id;

        parent::setActive(UserSettings::getUsernameFromId($uid));

        $vars['email'] = UserSettings::get($uid, 'email');
        $vars['newsletter'] = UserSettings::get($uid, 'newsletter');

        return View::make("settings", $vars);
    }

    public function changeSettings(){
        $uid = Auth::user()->id;
        $passwordchanged = false;

        $email = Input::get("email");
        $password = Input::get("password");

        $input = array(
            'email' => $email,
            'password' => $password,
        );

        $rules = array(
            'email' => "required|email",
            'password' => "required|min:6",
        );

        $messages = array(
            "email.required" => "You left the email field blank.",
            "email.email" => "You didn't enter a proper email.",
            "password.required" => "You left the password field blank.",
        );

        $validator = Validator::make($input,$rules,$messages);
        if($validator->fails()){
            $reason = "<p>We couldn't modify your account! This is because:</p><p><ul>";

            foreach($validator->messages()->all() as $message){
                $reason .= "<li>$message</li>";
            }

            $reason .= "</ul></p>";

            return Response::json(array("result"=>"failure","reason"=>$reason));
        }

        $username = UserSettings::getUsernameFromId($uid);
        $pass = DB::table('users')->where('id', $uid)->pluck('password');
        if(!Hash::check($password, $pass)){
            return Response::json(array("result"=>"failure","reason"=>'Your password is incorrect.'));
        }

        if(Input::has('npassword') && Input::has('npassword2')){
            $npassword = Input::get('npassword');
            $npassword2 = Input::get('npassword2');

            if($npassword != $npassword2){
                return Response::json(array("result"=>"failure","reason"=>'Your passwords don\'t match.'));
            }

            $input = array(
                'npassword' => $npassword,
                'npassword2' => $npassword2,
            );

            $rules = array(
                'npassword' => "required|min:6",
                'npassword2' => "required|min:6",
            );

            $messages = array(
                "npassword.required" => "You left the password field blank.",
                "npassword2.required" => "You left the password confirmation field blank.",
                "npassword.min" => "Your password is shorter than 6 characters.",
                "npassword2.min" => "Your password confirmation is shorter than 6 characters.",
            );

            $validator = Validator::make($input,$rules,$messages);
            if($validator->fails()){
                $reason = "<p>We couldn't modify your account! This is because:</p><p><ul>";

                foreach($validator->messages()->all() as $message){
                    $reason .= "<li>$message</li>";
                }

                $reason .= "</ul></p>";

                return Response::json(array("result"=>"failure","reason"=>$reason));
            }

            DB::table("users")->where("id", $uid)->update(array('password'=>Hash::make($npassword)));
            $passwordchanged = true;
        }

        UserSettings::set($uid, 'email', $email);

        if(Input::has('newsletter')){
            UserSettings::set($uid, 'newsletter', 'true');
        }else{
            UserSettings::set($uid, 'newsletter', 'false');
        }

        if($passwordchanged){
            self::logoutUser();
        }

        return Response::json(array("result"=>"success"));
    }

    public function retrieveWithUsername(){
        $username = Input::get("username");
        $uid = UserSettings::getIdFromUsername($username);

        if($uid == null){
            return Response::json(array('result'=>'failure','reason'=>'A user with that name does not exist.'));
        }

        $key = str_random(32);
        UserSettings::set($uid, 'reset', $key);
        $email = UserSettings::get($uid, 'email');
        $username = UserSettings::getUsernameFromId($uid);

        Mail::queue("emails.password", array('username'=>$username,'key'=>$key), function($message) use ($username,$email) {
            $message->from('noreply@battleplugins.com', 'BattlePlugins Support');
            $message->to($email, $username)->subject("Password Reset Instructions");
        });

        $hidemail = EmailUtil::hide_mail($email);

        return Response::json(array('result'=>'success','reason'=>'You have been sent an email to '.$hidemail.'. Please check your junk mail if you don\'t see the email in your inbox'));
    }

    public function retrieveWithEmail(){
        $email = Input::get("email");
        $result = DB::table('user_settings')->where('value', $email)->where("key", "email")->first();

        if(count($result) == 0){
            return Response::json(array('result'=>'failure','reason'=>'A user with that email does not exist.'));
        }

        $email = $result->value;

        $uid = $result->user_id;
        $username = UserSettings::getUsernameFromId($uid);

        Mail::queue("emails.email", array('username'=>$username), function($message) use ($username,$email) {
            $message->from('noreply@battleplugins.com', 'BattlePlugins Support');
            $message->to($email, $username)->subject("Retrieve Your Username");
        });

        return Response::json(array('result'=>'success','reason'=>'You have been sent an email to '.$email.'. Please check your junk mail if you don\'t see the email in your inbox'));
    }

    public function forgotPage(){
        parent::setActive('Login');
        $vars['title'] = 'Login Help';
        return View::make('forgot', $vars);
    }

    public function resetPasswordPage(){
        $key = Input::get('key');
        $result = DB::table('user_settings')->where('value', $key)->where("key", "reset")->first();

        if(count($result) == 0){
            return Redirect::to("/login");
        }

        $vars['title'] = 'Reset Password';
        $vars['key'] = $key;

        return View::make('reset', $vars);
    }

    public function resetPassword(){
        $key = Input::get('key');
        $result = DB::table('user_settings')->where('value', $key)->where("key", "reset")->first();

        if(count($result) == 0){
            return Redirect::to("/login");
        }

        $npassword = Input::get('npassword');
        $npassword2 = Input::get('npassword2');

        if($npassword != $npassword2){
            return Response::json(array("result"=>"failure","reason"=>'Your passwords don\'t match.'));
        }

        $input = array(
            'npassword' => $npassword,
            'npassword2' => $npassword2,
        );

        $rules = array(
            'npassword' => "required|min:6",
            'npassword2' => "required|min:6",
        );

        $messages = array(
            "npassword.required" => "You left the password field blank.",
            "npassword2.required" => "You left the password confirmation field blank.",
            "npassword.min" => "Your password is shorter than 6 characters.",
            "npassword2.min" => "Your password confirmation is shorter than 6 characters.",
        );

        $validator = Validator::make($input,$rules,$messages);
        if($validator->fails()){
            $reason = "<p>We couldn't modify your account! This is because:</p><p><ul>";

            foreach($validator->messages()->all() as $message){
                $reason .= "<li>$message</li>";
            }

            $reason .= "</ul></p>";

            return Response::json(array("result"=>"failure","reason"=>$reason));
        }

        $uid = $result->user_id;

        DB::table("users")->where("id", $uid)->update(array('password'=>Hash::make($npassword)));
        UserSettings::delete($uid, 'reset');

        return Redirect::to('/login');
    }
}
