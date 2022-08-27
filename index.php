<?php

require_once './vendor/autoload.php';

use app\core\Application;


$app=new Application();
//echo '<pre>';
//var_dump($_SERVER);
$app->router->get('/',function (){
    return 'Hello World!';
});

$app->router->get('/contact',function (){
   return 'Contacts';
});

$app->router->resolve();