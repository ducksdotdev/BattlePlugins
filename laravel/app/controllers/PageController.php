<?php

use BattleTools\UserManagement\UserGroups;
use BattleTools\UserManagement\UserSettings;
use BattleTools\Util\DateUtil;
use BattleTools\Util\Jenkins;

class PageController extends BaseController {

    public function getIndex()
    {
        $vars['plugins'] = DB::table("plugins")->get();

        $builds = array();

        foreach($vars['plugins'] as $plugin){
            $authors[$plugin->author] = UserSettings::getUsernameFromId($plugin->author);

            $ci = Jenkins::getLatestBuild("http://ci.battleplugins.com", $plugin->name);
            if($ci['exists']){
                $builds[] = array(
                    'ci' => $ci,
                    'name' => $plugin->name,
                    'author' => $plugin->author,
                    'bukkit' => $plugin->bukkit
                );
            }
        }

        $vars['authors'] = $authors;

        arsort($builds);
        $builds = array_slice($builds, 0, 4);

        $vars['builds'] = $builds;

        $vars['title'] = "Home";

        parent::setActive("Home");

        $blog = DB::table('blog')->orderBy('id', 'desc')->first();
        $vars['blog'] = $blog;

        if(count($blog) > 0){
            $vars['ago'] = DateUtil::getDateHtml($blog->created_at);
            $vars['author'] = UserSettings::getUsernameFromId($blog->author);
        }

        return View::make('index', $vars);
    }

    public function getWiki(){
        return Redirect::to("http://wiki.battleplugins.com/");
    }

    public function getCI(){
        return Redirect::to("http://ci.battleplugins.com/");
    }

    public function tos(){
        return View::make("legal.tos", array('title'=>'Terms of Service'));
    }

    public function privacy(){
        return View::make("legal.privacy", array('title'=>'Privacy Policy'));
    }

    public function getBlog(){
        parent::setActive('Home');

        $blog = DB::table('blog')->orderBy('id', 'desc')->get();

        if(count($blog) == 0){
            return Redirect::to('/');
        }

        $vars['blog'] = $blog;
        foreach($vars['blog'] as $post){
            $ago[$post->id] = DateUtil::getDateHtml($post->created_at);
            $authors[$post->id] = UserSettings::getUsernameFromId($post->author);
        }

        $vars['ago'] = $ago;
        $vars['authors'] = $authors;

        $vars['title'] = 'All Blog Posts';

        return View::make('blogList', $vars);
    }

    public function getBlogPost($id='recent'){
        parent::setActive('Home');

        if($id == 'recent'){
            $blog = DB::table('blog')->orderBy('id', 'desc')->first();
        }else{
            $blog = DB::table('blog')->where('id', $id)->first();
        }

        if(count($blog) == 0){
            return Redirect::to('/');
        }

        $vars['blog'] = $blog;
        $vars['ago'] = DateUtil::getDateHtml($blog->created_at);
        $vars['author'] = UserSettings::getUsernameFromId($blog->author);
        $vars['title'] = $blog->title;

        $admin = true;

        if(Auth::check()){
            $admin = UserGroups::hasGroup(Auth::user()->id, UserGroups::ADMINISTRATOR);
        }

        $vars['admin'] = $admin;

        return View::make('blog', $vars);
    }

    public function getDonateCancel(){
        parent::setActive('Resources');
        $vars['title'] = 'Thanks!';
        return View::make('donate.cancel', $vars);
    }

    public function getDonateThanks(){
        parent::setActive('Resources');
        $vars['title'] = 'Thank You!';
        return View::make('donate.thanks', $vars);
    }
}
