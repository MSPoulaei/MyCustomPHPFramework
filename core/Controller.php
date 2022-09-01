<?php

namespace app\core;

use app\core\middlewares\Middleware;

class Controller
{
    /**
     * @var middlewares\Middleware[]
     */
    protected array $middlewares=[];

    /**
     * @return array
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }

    protected function registerMiddleware(Middleware $middleware)
    {
        $this->middlewares[]=$middleware;
    }
    public function view(string $view,array $params=[],string $layout="")
    {
        return Application::$App->view->renderView($view,$params,$layout);
    }
}