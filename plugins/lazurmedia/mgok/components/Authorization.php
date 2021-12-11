<?php namespace LazurMedia\Mgok\Components;

use Flash;
use Cookie;
use Redirect;
use Validator;
use ValidationException;
use Lazurmedia\Mgok\Models\Users;
use Lazurmedia\Mgok\Classes\Session;


class Authorization extends \Cms\Classes\ComponentBase
{

  public function componentDetails()
  {
      return [
          'name' => 'Авторизация',
          'description' => 'Авторизация'
      ];
  }

  public function onRun() 
  {
    return $this->route($this->page->url);
  }

  private function route($route) {
    switch ($route) {
      case '/avtorizaciya':
        if ($this->checkAuth())
          return Redirect::to('/');
        break;
      default:
        if (!$this->checkAuth())
          return Redirect::to('/avtorizaciya');
        break;
    }
  }

  public function onAuth() {
    $data = post();

    $rules = [
      'login' => 'required',
      'password' => 'required',
    ];

    $validator = Validator::make($data, $rules);

    if($validator->fails()) {
      throw new ValidationException($validator);
    } else {
      $user = Users::where('login', $data['login'])->where('password', $data['password'])->first(); 
      
      if ($user) {
        Cookie::queue('mgok_auth', $data['login'], 43800);
        if ($user->role === 'Директорат')
          return Redirect::to('/koefficient-effektivnosti-kafedr');
        else
          return Redirect::to('/');
      } else {
        Flash::error('Неверный логин или пароль');
        return Redirect::back()->withInput(post());
      }
    }
  }

  public function onLogout() {
    Cookie::queue('mgok_auth', '', -1);
    return Redirect::to('/avtorizaciya');
  }

  private function checkAuth() {
    $auth = Cookie::get('mgok_auth');
    
    if (is_null($auth)) {
      return false;
    }
    return true;
  }

  public static function getLogin() {
    $login = Cookie::get('mgok_auth');

    if (is_null($login)) {
      return false;
    }
    return $login;
  }

  public static function getRole() {
    $login = Cookie::get('mgok_auth');

    if (is_null($login)) {
      return false;
    }

    $user = Users::where('login', $login)->first();
    return $user->role;
  }

  public static function getClass() {
    $login = Cookie::get('mgok_auth');

    if (is_null($login)) {
      return false;
    }

    $class = Users::where('login', Authorization::getLogin())->first()->class;
    return $class;
  }

  public static function getUser() {
    $login = Cookie::get('mgok_auth');

    if (is_null($login)) {
      return false;
    }

    $user = Users::where('login', $login)->first();
    return $user;
  }

  public static function getFullName() {
    $user = Users::where('login', Authorization::getLogin())->first();

    $full_name = $user->full_name;
    $fio = explode(' ', $full_name);
    $name = mb_substr($fio[1] ?? '',0,1,'UTF-8').'.'; 
    $sec_name = mb_substr($fio[2] ?? '',0,1,'UTF-8').'.';
    $full_name = implode(' ', array($fio[0], $name, $sec_name));
    return $full_name;
  }
}
?>