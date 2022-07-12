<?php

require 'vendor/autoload.php';
$router = new App\Router\Router($_GET['url']);

$router->get('/', function(){ echo "homepage"; });
$router->get('/login', function(){ require('templates/log.php'); });
$router->get('/sign', function(){ require('templates/sign.php'); });
$router->post('/login', 'User#log');
$router->post('/sign', 'User#sign');

$router->run();