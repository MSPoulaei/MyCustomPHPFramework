<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\models\Contact;

class HomeController extends Controller
{
    public function index()
    {
        return $this->view("home",params: ["name"=>"MSPCO"]);
    }

    public function contact()
    {
        return $this->view("contact",["model"=>new Contact()]);
    }

    public function handleContact(Request $request)
    {
        $model=new Contact();
        if($model->validate()){
            return "success<br>" . "<pre>". print_r($request->getBody()) ."</pre>";
        }
        return $this->view("contact",["model"=>$model]);
    }

}