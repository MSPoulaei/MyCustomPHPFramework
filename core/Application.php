<?php

namespace app\core;

class Application
{
    public Router $router;
    public Request $request;
    public Response $response;
    public static Application $App;
    public static string $APP_DIR;
    public static string $MAIN_LAYOUT;
    public function __construct(string $appDir)
    {
        static::$App=$this;
        static::$APP_DIR=$appDir;
        static::$MAIN_LAYOUT="main";
        $this->request=new Request();
        $this->response=new Response();
        $this->router=new Router($this->request,$this->response);
    }
    public function run(){
        echo $this->router->resolve();
    }
}