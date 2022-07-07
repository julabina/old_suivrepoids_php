<?php

require 'vendor/autoload.php';
$router = new App\Router\Router($_GET['url']);

$router->get('/', function(){ echo "homepage"; });
$router->get('/login', 'User#log');
$router->get('/sign', function(){ require('templates/sign.php'); });
$router->post('/sign', 'User#sign');

$router->run();