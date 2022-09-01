<?php

namespace app\core;

class Router
{
    protected array $routes=[];
    protected string $view_path;
    protected string $notfound_view_filename="404";
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
            return $this->renderView($this->notfound_view_filename);
        }
        elseif (is_string($callback)){
            return $this->renderView($callback);
        }
        elseif (is_array($callback)){
            $callback[0]=new $callback[0]();
            return call_user_func($callback,$this->request,$this->response);
        }
        elseif(is_callable($callback)){
            return call_user_func($callback);
        }

        $this->response->setHTTPCode(404);
        return $this->renderView($this->notfound_view_filename);
    }

    public function renderView(string $view,array $params=[],string $layout=""):string
    {
        if ($layout===""){
            $layout=Application::$MAIN_LAYOUT;
        }
        return str_replace("{{content}}",$this->renderViewOnly($view,$params),$this->renderLayout($layout));
    }

    protected function renderLayout($layout)
    {
        ob_start();
        require_once $this->view_path."/layouts/$layout.php";
        return ob_get_clean();
    }
    protected function renderViewOnly(string $view,array $params=[])
    {
        foreach ($params as $key=>$value){
            $$key=$value;
        }

        ob_start();
        require_once $this->view_path."/$view.php";
        return ob_get_clean();
    }

}