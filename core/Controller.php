<?php

namespace app\core;

class Controller
{
    public function view(string $view,string $layout="",array $params=[])
    {
        return Application::$App->router->renderView($view,$layout,$params);
    }
}