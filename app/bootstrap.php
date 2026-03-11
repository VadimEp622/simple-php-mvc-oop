<?php

session_start();

use Core\App;
use Core\Container;
use Core\Database;
use Core\Flash;

$container = new Container();

$container->bind('Core\Database', function () {
    $config = require_once base_path('app/config/config.php');

    return new Database($config['database']);
});

$container->bind(Flash::class, fn() => new Flash());

App::setContainer($container);
