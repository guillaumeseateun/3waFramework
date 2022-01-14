<?php

require_once __DIR__ . '\vendor\autoload.php';

use Framework\App;
use Framework\Container;
use Framework\Dispatcher;
use Framework\Request;
use Framework\Router\Route;
use Framework\Router\Router;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\Yaml\Yaml;



// Permet de faire fonctionner .env

(new Dotenv())->load(__DIR__ . '\\.env');


// Définition des routes

define('ROUTES_PATH', __DIR__ . '\config');


// Définition du container

$container = new Container;


// Routes

$container['routes'] = Yaml::parseFile(ROUTES_PATH . '\routes.yaml');

$container['router'] = function ($c) {
    $router = new Router;
    foreach ($c['routes'] as $route) {
        $router->addRoute(new Route($route));
    }

    return $router;
};


// Twig

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '\templates');
$container['twig'] = new \Twig\Environment($loader, [
    'cache' => false,
]);



App::set($container);

$dispatcher = new Dispatcher(new Request);
