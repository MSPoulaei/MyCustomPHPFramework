<?php

namespace app\core;

use app\core\database\Database;
use app\core\database\DbModel;

class Application
{
    public Router $router;
    public Request $request;
    public Response $response;
    public Session $session;
    public static Application $App;
    public static Database $db;
    public static string $APP_DIR;
    public static string $MAIN_LAYOUT;
    public ?UserModel $user;
    protected string $userClass;

    public function __construct(string $appDir, array $config)
    {
        static::$App = $this;
        static::$APP_DIR = $appDir;
        static::$MAIN_LAYOUT = "main";
        static::$db = new Database($config["database"]);
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response);
        $this->userClass = $config["userclass"];


        $primaryValue = $this->session->get("user");
        if ($primaryValue) {
            $primaryKey = $this->userClass::primaryKey();
            $this->user = $this->userClass::findOne([$primaryKey => $primaryValue]);
        } else {
            $this->user = null;
        }

    }

    public function run()
    {
        echo $this->router->resolve();
    }

    public function login($user)
    {
        $this->user = $user;
        $primaryKey = $this->userClass::primaryKey();
        $this->session->set("user", $user->{$primaryKey});
        return true;
    }

    public function logout()
    {
        $this->user = null;
        $this->session->remove("user");
    }
}