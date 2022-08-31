<?php

namespace app\core;

class Controller
{
    public function view(string $view,array $params=[],string $layout="")
    {
        return Application::$App->router->renderView($view,$params,$layout);
    }
}