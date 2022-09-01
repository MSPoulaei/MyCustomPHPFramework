<?php
$APPLICATION_ROOT_PATH=dirname(__DIR__);

require_once $APPLICATION_ROOT_PATH. '/vendor/autoload.php';

use app\controllers\AuthController;
use app\controllers\HomeController;
use app\core\Application;

$dotenv = Dotenv\Dotenv::createImmutable($APPLICATION_ROOT_PATH);
$dotenv->load();

$config=[
    "userclass"=>\app\models\User::class,
    "database"=>[
        "dsn"=>$_ENV["DB_HOST"],
        "username"=>$_ENV["DB_USERNAME"],
        "password"=>$_ENV["DB_PASSWORD"]
    ]
];

$app=new Application($APPLICATION_ROOT_PATH,$config);

$app->router->get('/',[HomeController::class,"index"]);

$app->router->get('/contact',[HomeController::class,"contact"]);
$app->router->post('/contact',[HomeController::class,"handleContact"]);

$app->router->get('/login',[AuthController::class,"login"]);
$app->router->post('/login',[AuthController::class,"loginPost"]);

$app->router->get('/logout',[AuthController::class,"logout"]);

$app->router->get('/profile',[AuthController::class,"profile"]);

$app->router->get('/register',[AuthController::class,"register"]);
$app->router->post('/register',[AuthController::class,"registerPost"]);



$app->run();