<?php

$container = new \League\Container\Container();
$container->delegate(new \League\Container\ReflectionContainer(true));

# parameters
$dsn = "mysql:host=db;dbname={$_ENV['MYSQL_DATABASE']};charset=utf8mb4";
$container->add('dsn', new \League\Container\Argument\Literal\StringArgument($dsn));
$routes = include __DIR__ . '/routes.php';
$migrationsFolder = dirname(__DIR__) . '/migrations';
$container->add(
    'migrations_folder',
    new \League\Container\Argument\Literal\StringArgument($migrationsFolder)
);
$jwtSecretKey = $_ENV['JWT_SECRET_KEY'];
$container->add(
    'jwtSecretKey',
    new \League\Container\Argument\Literal\StringArgument($jwtSecretKey)
);

# services
$container->add(\App\Routing\RouteHandlerResolver::class)
    ->addArguments([$container]);
$container->add(\App\Routing\Router::class)
    ->addArguments([\App\Routing\RouteHandlerResolver::class]);
$container->extend(\App\Routing\Router::class)
    ->addMethodCall('setRoutes', [$routes]);

$container->add(
    \App\Http\Middleware\RequestHandlerInterface::class,
    \App\Http\Middleware\RequestHandler::class
)->addArgument($container);

$container->add(\App\Http\Kernel::class)
    ->addArguments([\App\Http\Middleware\RequestHandlerInterface::class]);

$container->addShared(\App\Database\Connection::class)
    ->addArguments(['dsn', $_ENV['MYSQL_USER'], $_ENV['MYSQL_PASSWORD']]);

$container->add(\App\Http\Middleware\JwtAuthenticate::class)
    ->addArgument('jwtSecretKey');

return $container;
