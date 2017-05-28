<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\AlertRepository;
use App\Tools\Settings;
use App\Tools\UserSettings;
use Auth;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use PragmaRX\Google2FA\Google2FA;

/**
 * Class UserController
 * @package App\Http\Controllers\Auth
 */
class UserController extends Controller {

  use ThrottlesLogins;

  /**
   * @var Request
   */
  private $request;


  /**
   * @param Request $request
   */
  function __construct(Request $request) {
    $this->request = $request;
  }

  /**
   * @return \Illuminate\View\View
   */
  public function getLogin() {
    return view('auth.login');
  }

  /**
   * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
   */
  public function getSettings() {
    if (auth()->check())
      return view('auth.settings');

    return redirect()->guest('/auth/login');
  }

  /**
   * @return $this|\Illuminate\Http\RedirectResponse
   */
  public function postChangeSettings() {
    $user = Auth::user();
    $confirmation = $this->request->input('confirmation');

    if (Auth::validate(['id' => $user->id, 'password' => $confirmation])) {
      $validator = $this->validate($this->request,
          [
              'email' => 'email|unique:users,email',
              'displayname' => 'max:16|unique:users,displayname',
              'password' => 'confirmed'
          ]
      );

      if ($validator && $validator->fails())
        return $this->redirectBackWithErrors($validator->errors());

      $email = $this->request->input('email');
      if ($email)
        UserSettings::modify($user, 'email', $email);

      $password = $this->request->input('password');
      if ($password)
        UserSettings::modify($user, 'password', $password);

      $displayname = $this->request->input('displayname');
      if ($displayname)
        UserSettings::modify($user, 'displayname', $displayname);

      auth()->logout();
      return redirect()->back();
    } else
      return $this->redirectBackWithErrors(['Invalid confirmation password.']);
  }

  /**
   * @return $this|\Illuminate\Http\RedirectResponse
   */
  public function postCreateUser() {
    if (UserSettings::hasNode(auth()->user(), UserSettings::CREATE_USER)) {
      $validator = $this->validate($this->request, [
          'displayname' => 'required|max:16|unique:users,displayname',
          'email' => 'required|email|unique:users,email',
          'password' => 'required'
      ]);

      if ($validator && $validator->fails())
        return redirect()->back()->withInput(['displayname', 'email']);

      $displayname = $this->request->input('displayname');
      $email = $this->request->input('email');
      $password = $this->request->input('password');
      $id = UserSettings::create($email, $password, $displayname);

      $message = "Welcome, $displayname This is the BattlePlugins admin panel. This is a portal for checking server information and website management. This panel is also a hub for all of the BattlePlugins websites. If you have any questions please talk to lDucks.";

      AlertRepository::create($message, [User::find($id)]);

      Mail::send('emails.welcome', array(
          'password' => $password,
          'displayname' => $this->request->input('displayname')
      ), function ($message) use ($email, $displayname) {
        $message->to($email, $displayname)->subject('BattleAdmin Registration Confirmation');
      });

      if (UserSettings::hasNode(auth()->user(), UserSettings::MODIFY_USER))
        return redirect()->action('AdminController@getModifyUserPermissions', ['id' => $id]);
      else
        return $this->redirectBackWithSuccess('User has been created and notified');
    } else
      abort(403);
  }

  /**
   * @param $user
   * @return \Illuminate\Http\RedirectResponse
   */
  public function postDeleteUser($user) {
    if (UserSettings::hasNode(auth()->user(), UserSettings::MODIFY_USER))
      UserSettings::delete($user);

    return redirect()->back();
  }

  /**
   * @param $user
   * @return \Illuminate\Http\RedirectResponse
   */
  public function postModifyUserPermissions($user) {
    if (UserSettings::hasNode(auth()->user(), UserSettings::MODIFY_USER)) {
      User::find($user)->permission()->delete();

      $nodes = $this->request->all();
      unset($nodes['_token']);


      foreach ($nodes as $node => $value)
        UserSettings::togglePermissionNode($user, str_replace('_', '.', $node));

      return redirect()->back();
    } else
      abort(403);
  }

  /**
   * @return $this
   */
  public function postRegister() {
    if (Settings::get('registration')) {
      $validator = $this->validate($this->request, [
          'name' => 'required|max:16|unique:users,displayname',
          'email' => 'required|email|unique:users,email',
          'password' => 'required|confirmed'
      ]);

      $email = $this->request->input('email');
      $name = $this->request->input('name');
      if ($validator && $validator->fails())
        return redirect()->back()->withInput(['name' => $name, 'email' => $email]);

      UserSettings::create($email, $this->request->get('password'), $name);

      Mail::send('emails.registration', array(
          'name' => $this->request->input('name')
      ), function ($message) use ($email, $name) {
        $message->to($email, $name)->subject('BattlePlugins Registration Confirmation');
      });

      return redirect('/auth/login')->withInput(['email' => $email]);
    } else abort(403);
  }
}