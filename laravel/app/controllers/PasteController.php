<?php

use BattleTools\UserManagement\UserGroups;
use BattleTools\UserManagement\UserSettings;
use BattleTools\Util\DateUtil;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class PasteController extends BaseController {

	public function  __construct(){
		parent::setActive('Tools');
	}

	public function getCreatePage(){
		$vars['title'] = 'Create Paste';

		$vars['pastes'] = DB::table('pastes')->where('author', Auth::user()->id)->where((function($query)
		{
			$query->where('hidden_on', '0000-00-00 00:00:00')
				->orWhere('hidden_on', '>', Carbon::now());

		}))->orderBy('created_on', 'desc')->take(6)->get();

		$prettyTime = array();
		foreach($vars['pastes'] as $paste){
			$prettyTime[$paste->id] = DateUtil::getDateHtml($paste->created_on);
		}

		$vars['prettyTime'] = $prettyTime;

		return View::make('paste.create', $vars);
	}

	public function createPaste(){
		$title = Input::get('title');
		$content = Input::get('content');

		$input = array(
			'title' => $title,
			'content' => $content,
		);

		$rules = array(
			'title' => "max:132",
			'content' => "required|max:200000",
		);

		$messages = array(
			"title.max" => "Your title exceeds 32 characters.",
			"content.required" => "You left the content field blank.",
			"content.max" => "Your content is too long"
		);

		$validator = Validator::make($input,$rules,$messages);
		if($validator->fails()){
			$reason = "<p>We couldn't create your paste! This is because:</p><p><ul>";

			foreach($validator->messages()->all() as $message){
				$reason .= "<li>$message</li>";
			}

			$reason .= "</ul></p>";

			return Response::json(array("result"=>"failure","reason"=>$reason));
		}

		$deletionDate = Input::get('delete');

		if(Input::has('delete')){
			$deletionDate = date("Y-m-d H:i:s", strtotime($deletionDate));
		}

		$private = Input::has('private');

		$id = str_random(6);
		$path = Config::get('pastes.location');

		while(file_exists($path.'/'.$id)){
			$id = str_random(6);
		}

		file_put_contents($path.'/'.$id, $content);
		Cache::forever('paste-'.$id, $content);

		$lang = Input::get('lang');

		DB::table('pastes')->insertGetId(array(
			'id' => $id,
			'author' => Auth::user()->id,
			'title' => $title,
			'private' => $private,
			'lang' => $lang,
			'created_on' => Carbon::now(),
			'hidden_on' => $deletionDate
		));

		return Response::json(array('result'=>'success','reason'=>'/paste/'.$id));
	}

	public function getPaste($id){
		$paste = DB::table('pastes')->where('id', $id)->first();

		if(count($paste) == 0){
			return Redirect::to('/paste/create');
		}

		$path = Config::get('pastes.location');
		$path = $path.'/'.$paste->id;

		if(!file_exists($path)){
			DB::table('pastes')->where('id', $id)->delete();

			return Redirect::to('/paste/create');
		}

		if(count($paste) == 0){
			return Redirect::to('/paste/create');
		}
		$own = Auth::check() && Auth::user()->id == $paste->author;

		if(($paste->private && !$own) || (Carbon::now() > $paste->hidden_on && $paste->hidden_on != '0000-00-00 00:00:00')){
			return Redirect::to('/paste/create');
		}

		if($paste->title == null){
			$title = 'BattlePaste ID: '.$paste->id;
		}else{
			$title = $paste->title;
		}

		$vars['content'] = Cache::get('paste-'.$paste->id, file_get_contents($path));
		$vars['author'] = UserSettings::getUsernameFromId($paste->author);
		$vars['ago'] = DateUtil::getDateHtml($paste->created_on);
		$vars['title'] = $title;
		$vars['paste'] = $paste;

		$hidden = null;
		if($paste->hidden_on != '0000-00-00 00:00:00'){
			$hidden = DateUtil::getDateHtml($paste->hidden_on);
		}

		$vars['hidden'] = $hidden;
		$vars['own'] = $own;
		$vars['admin'] = Auth::check() && UserGroups::hasGroup(Auth::user()->id, UserGroups::ADMINISTRATOR);

		return View::make('paste.show', $vars);
	}

	public function getRawPaste($id){
		$paste = DB::table('pastes')->where('id', $id)->first();

		$path = Config::get('pastes.location');
		$path = $path.'/'.$paste->id;

		if(!file_exists($path)){
			return Redirect::to('/paste/create');
		}

		if(count($paste) == 0){
			return Redirect::to('/paste/create');
		}
		$own = Auth::check() && Auth::user()->id == $paste->author;

		if(($paste->private && !$own) || (Carbon::now() > $paste->hidden_on && $paste->hidden_on != '0000-00-00 00:00:00')){
			return Redirect::to('/paste/create');
		}

		if($paste->title == null){
			$title = 'BattlePaste ID: '.$paste->id;
		}else{
			$title = $paste->title;
		}

		$vars['title'] = $title;
		$vars['paste'] = $paste;
		$vars['content'] = Cache::get('paste-'.$paste->id, file_get_contents($path));

		return View::make('paste.raw', $vars);
	}

	public function deletePaste(){
		$id = Input::get('id');
		$paste = DB::table('pastes')->where('id', $id)->first();
		if(!($paste->author == Auth::user()->id || UserGroups::hasGroup(Auth::user()->id, UserGroups::ADMINISTRATOR))){
			return Response::json(array('result'=>'failure'));
		}

		DB::table('pastes')->where('id', $id)->delete();
		return Response::json(array('result'=>'success'));
	}

	public function getEditForm() {
		$id = Input::get('id');
		$paste = DB::table('pastes')->where('id', $id)->first();

		$path = Config::get('pastes.location');
		$path = $path . '/' . $paste->id;

		if (file_exists($path)) {
			if ($paste->author == Auth::user()->id || UserGroups::hasGroup(Auth::user()->id, UserGroups::ADMINISTRATOR)) {
				$vars['paste'] = $paste;
				$vars['content'] = Cache::get('paste-' . $paste->id, file_get_contents($path));

				return View::make('ajax.pasteEditForm', $vars);
			}
		}
	}

	public function editPaste(){
		$title = Input::get('title');
		$content = Input::get('content');

		$input = array(
			'title' => $title,
			'content' => $content,
		);

		$rules = array(
			'title' => "max:32",
			'content' => "required",
		);

		$messages = array(
			"title.max" => "Your title exceeds 32 characters.",
			"content.required" => "You left the content field blank.",
		);

		$validator = Validator::make($input,$rules,$messages);
		if($validator->fails()){
			$reason = "<p>We couldn't edit your paste! This is because:</p><p><ul>";

			foreach($validator->messages()->all() as $message){
				$reason .= "<li>$message</li>";
			}

			$reason .= "</ul></p>";

			return Response::json(array("result"=>"failure","reason"=>$reason));
		}

		$private = Input::has('private');

		$id = Input::get('id');

		$paste = DB::table('pastes')->where('id', $id)->first();

		$path = Config::get('pastes.location');
		$path = $path.'/'.$paste->id;

		if(!file_exists($path)){
			return Redirect::to('/paste/'.$paste->id);
		}

		if(!Auth::check() || ($paste->author != Auth::user()->id && !UserGroups::hasGroup(Auth::user()->id, UserGroups::ADMINISTRATOR))){
			return Response::json(array('result'=>'failure','reason'=>'This isn\'t your paste!'));
		}

		DB::table('pastes')->where('id', $id)->update(array(
			'title' => $title,
			'private' => $private,
		));

		file_put_contents($path, $content);

		Cache::forever('paste-'.$paste->id, $content);

		return Response::json(array('result'=>'success'));
	}

}
