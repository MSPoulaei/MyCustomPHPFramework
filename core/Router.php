<?php

namespace app\core;

class Router
{
    protected array $routes=[];
    public function __construct(protected Request $request)
    {

    }

    public function get(string $path, \Closure $callback)
    {
        $this->routes['get'][$path]=$callback;
    }
    public function post(string $path, \Closure $callback)
    {
        $this->routes['post'][$path]=$callback;
    }

    public function resolve()
    {
        $path=$this->request->getPath();
        $method=$this->request->getMethod();

        $callback=$this->routes[$method][$path] ?? false;
        if ($callback===false){
            echo "404 Not Found";
        }
        else{
            echo call_user_func($callback);
        }
    }

}