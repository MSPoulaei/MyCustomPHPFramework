<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\models\Register;

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
        return $this->view("register",layout: $this->layout);
    }
    public function registerPost(Request $request)
    {
        $registerModel=new Register();
        $registerModel->loadData($request->getBody());
        if($registerModel->validate()){
            return "Success";
        }

        return $this->view("register",$this->layout,["errors"=>$registerModel->errors]);
    }

}