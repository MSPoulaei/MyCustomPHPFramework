<?php

namespace app\core;

use app\core\Exceptions\NotFoundException;

class Router
{
    protected array $routes=[];
//    protected string $view_path;
//    protected string $notfound_view_filename="404";
    public function __construct(protected Request $request,protected  Response $response)
    {

    }

    public function get(string $path,$callback)
    {
        $this->routes['get'][$path]=$callback;
    }
    public function post(string $path,$callback)
    {
        $this->routes['post'][$path]=$callback;
    }

    public function resolve():string
    {
        $path=$this->request->getPath();
        $method=$this->request->getMethod();

        $callback=$this->routes[$method][$path] ?? false;
        if ($callback===false){
            throw new NotFoundException();
//            return $this->renderView($this->notfound_view_filename);
        }
        elseif (is_string($callback)){
            return Application::$App->view->renderView($callback);
        }
        elseif (is_array($callback)){
            Application::$App->currentAction=$callback[1];
            $callback[0]=new $callback[0]();
            Application::$App->currentController=$callback[0];
            foreach (Application::$App->currentController->getMiddlewares() as $middleware){
                $middleware->execute();
            }
            return call_user_func($callback,$this->request,$this->response);
        }
        elseif(is_callable($callback)){
            return call_user_func($callback);
        }
        throw new NotFoundException();
//        $this->response->setHTTPCode(404);
//        return $this->renderView($this->notfound_view_filename);
    }




}