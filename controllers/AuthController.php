<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\models\User;

class AuthController extends Controller
{
    private string $layout="auth";
    public function login()
    {
        return $this->view("login",layout: $this->layout);
    }
    public function loginPost(Request $request)
    {
        return print_r($request->getBody());
    }

    public function register()
    {
        return $this->view("register",["model"=>new User()],layout: $this->layout);
    }
    public function registerPost(Request $request)
    {
        $user=new User();
        $user->loadData($request->getBody());
        if($user->validate() && $user->save()){
            return "Success";
        }

        return $this->view("register",["errors"=>$user->errors,"model"=>$user],$this->layout);
    }

}