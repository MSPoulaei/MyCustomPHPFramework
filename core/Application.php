<?php

namespace app\core;

use app\core\database\Database;

class Application
{
    public Router $router;
    public Request $request;
    public Response $response;
    public static Application $App;
    public static Database $db;
    public static string $APP_DIR;
    public static string $MAIN_LAYOUT;
    public function __construct(string $appDir, array $config)
    {
        static::$App=$this;
        static::$APP_DIR=$appDir;
        static::$MAIN_LAYOUT="main";
        static::$db=new Database($config["database"]);
        $this->request=new Request();
        $this->response=new Response();
        $this->router=new Router($this->request,$this->response);

    }
    public function run(){
        echo $this->router->resolve();
    }
}