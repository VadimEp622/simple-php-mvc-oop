<?php

$router->get('/', 'controllers/home.php');
$router->post('/', 'controllers/home.php');
$router->get('/about', 'controllers/about.php');

$router->get('/thread', 'controllers/thread/index.php');
$router->delete('/thread', 'controllers/thread/destroy.php');

$router->get('/forum', 'controllers/forum/index.php');
$router->post('/forum', 'controllers/forum/create.php');
$router->delete('/forum', 'controllers/forum/destroy.php');

$router->delete('/post', 'controllers/post/destroy.php');

$router->delete('/user', 'controllers/user/destroy.php');