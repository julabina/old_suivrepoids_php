<?php

require 'vendor/autoload.php';
$router = new App\Router\Router($_GET['url']);

$router->get('/', function(){ echo "homepage"; });
$router->get('/dashboard', 'User#dash');
$router->get('/objectifs', 'Stats#showObjectif');
$router->post('/objectif', 'Stats#addObjectif');
$router->get('/login', function(){ require('templates/log.php'); });
$router->post('/login', 'User#log');
$router->get('/sign', function(){ require('templates/sign.php'); });
$router->post('/sign', 'User#sign');

$router->run();