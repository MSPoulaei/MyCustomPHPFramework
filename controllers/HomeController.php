<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;

class HomeController extends Controller
{
    public function index()
    {
        return $this->view("home",params: ["name"=>"MSPCO"]);
    }

    public function contact()
    {
        return $this->view("contact");
    }

    public function handleContact(Request $request)
    {
        return "<pre>". print_r($request->getBody()) ."</pre>";
    }

}