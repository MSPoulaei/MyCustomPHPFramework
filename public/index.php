<?php

require_once __DIR__. '/../vendor/autoload.php';

use app\controllers\HomeController;
use app\core\Application;


$app=new Application(dirname(__DIR__));

$app->router->get('/',[HomeController::class,"index"]);

$app->router->get('/contact',[HomeController::class,"contact"]);
$app->router->post('/contact',[HomeController::class,"handleContact"]);

$app->run();