<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\App;
use App\Container;
use App\Dispatcher;
use App\Request;
use App\Router\Route;
use App\Router\Router;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\Yaml\Yaml;


// Permet de faire fonctionner .env
(new Dotenv())->load(__DIR__ . '\\.env');

define('VIEW_PATH', __DIR__ . '/resources/views');
define('ROUTES_PATH', __DIR__ . '/config');
define('WEBSITE', 'localhost/public');

function dd($v)
{
    var_dump($v);
    die;
}

$container = new Container;

$container['routes'] = Yaml::parse(ROUTES_PATH . '/routes.yaml');

$container['router'] = function ($c) {
    $router = new Router;
    foreach ($c['routes'] as $route) {
        $router->addRoute(new Route($route));
    }

    return $router;
};

$container['viewPath'] = VIEW_PATH;

$container['twig'] = $container->asShared(function ($c) {
    $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '\templates');
    return new \Twig\Environment($loader, [
        'index' => 'Hello {{ name }}!',
    ]);
});

// $container['view'] = $container->asShared(function ($c) {
//     return new View($c['viewPath'], $c['cachePath'], $c['engine']);
// });


App::set($container);


$dispatcher = new Dispatcher(new Request);
