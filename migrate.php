<?php


$APPLICATION_ROOT_PATH = __DIR__;

require_once $APPLICATION_ROOT_PATH . '/vendor/autoload.php';

use app\controllers\AuthController;
use app\controllers\HomeController;
use app\core\Application;

$dotenv = Dotenv\Dotenv::createImmutable($APPLICATION_ROOT_PATH);
$dotenv->load();

$config = [
    "database" => [
        "dsn" => $_ENV["DB_HOST"],
        "username" => $_ENV["DB_USERNAME"],
        "password" => $_ENV["DB_PASSWORD"]
    ]
];

$app = new Application($APPLICATION_ROOT_PATH, $config);

Application::$db->ApplyMigrations();