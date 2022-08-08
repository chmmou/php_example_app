<?php
declare(strict_types=1);

session_start();

use FastRoute\RouteCollector;
use App\Application;
use App\Config\Config;

require __DIR__.'/../vendor/autoload.php';

$requestUri = $_SERVER['REQUEST_URI'];
$uri = urldecode(
    parse_url($requestUri, PHP_URL_PATH)
);

// This file allows us to emulate Apache's "mod_rewrite" functionality from the
// built-in PHP web server. This provides a convenient way to test the application
// without having installed a "real" web server software here.
if ($uri !== '/' && (file_exists(__DIR__ . $uri) || preg_match('/\.(?:png|jpg|jpeg|gif|ico)$/', $requestUri))) {
    return false;
}

$dispatcher = FastRoute\simpleDispatcher(function (RouteCollector $r) {
    // Auth routes
    $r->addRoute('GET', '/login', ['App\Controllers\AuthController', 'login']);
    $r->addRoute('POST', '/login', ['App\Controllers\AuthController', 'login']);
    $r->addRoute('GET', '/register', ['App\Controllers\AuthController', 'register']);
    $r->addRoute('POST', '/register', ['App\Controllers\AuthController', 'register']);
    $r->addRoute('GET', '/logout', ['App\Controllers\AuthController', 'logout']);

    // Public routes
    $r->addRoute('GET', '/', ['App\Controllers\IndexController', 'index']);
    $r->addRoute('GET', '/user', ['App\Controllers\IndexController', 'user']);
    $r->addRoute('GET', '/tweets/detail/{id:\d+}', ['App\Controllers\TweetController', 'detail']);

    // Auth + User routes
    $r->addRoute('POST', '/tweets/create', ['App\Controllers\TweetController', 'create']);
    $r->addRoute('POST', '/tweets/edit', ['App\Controllers\TweetController', 'edit']);
    $r->addRoute('POST', '/tweets/delete', ['App\Controllers\TweetController', 'delete']);
});

$route = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

switch ($route[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        echo '404 Not Found';
        break;

    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        echo '405 Method Not Allowed';
        break;

    case FastRoute\Dispatcher::FOUND:
        $app = new Application(new Config());
        $app->getContainer()->call($route[1], $route[2]);
        break;
}

