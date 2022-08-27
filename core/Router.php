<?php

namespace app\core;

class Router
{
    protected array $routes=[];
    protected string $view_path;
    protected string $main_layout_filename="main";
    protected string $notfound_layout_filename="404";
    public function __construct(protected Request $request,protected  Response $response)
    {
        $this->view_path=Application::$APP_DIR."/views";
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
            $this->response->setHTTPCode(404);
            return $this->renderView($this->notfound_layout_filename);
        }
        elseif (is_string($callback)){
            return $this->renderView($callback);
        }
        elseif(is_callable($callback)){
            return call_user_func($callback);
        }

        $this->response->setHTTPCode(404);
        return $this->renderView($this->notfound_layout_filename);
    }

    protected function renderView(string $view):string
    {
        return str_replace("{{content}}",$this->renderViewOnly($view),$this->renderLayout());
    }

    protected function renderLayout()
    {
        ob_start();
        require_once $this->view_path."/layouts/$this->main_layout_filename.php";
        return ob_get_clean();
    }
    protected function renderViewOnly(string $view)
    {
        ob_start();
        require_once $this->view_path."/$view.php";
        return ob_get_clean();
    }

}