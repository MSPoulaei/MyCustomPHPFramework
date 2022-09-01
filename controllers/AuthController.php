<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\core\Session;
use app\models\Login;
use app\models\User;

class AuthController extends Controller
{
    private string $layout="auth";
    public function login()
    {
        return $this->view("login",["model"=>new Login()],layout: $this->layout);
    }
    public function loginPost(Request $request,Response $response)
    {
        $login=new Login();
        $login->loadData($request->getBody());
        if($login->validate() && $login->login()){
            $response->redirect("/");
        }
        return $this->view("login",["model"=>$login],$this->layout);
    }

    public function logout(Request $request,Response $response)
    {
        Application::$App->logout();
        $response->redirect("/");
    }
    public function register()
    {
        return $this->view("register",["model"=>new User()],$this->layout);
    }
    public function registerPost(Request $request,Response $response)
    {
        $user=new User();
        $user->loadData($request->getBody());
        if($user->validate() && $user->save()){
            Application::$App->session->setFlash("success","You have successfully registered!");
            $response->redirect("/");
        }

        return $this->view("register",["model"=>$user],$this->layout);
    }

}