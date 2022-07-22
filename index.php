<?php

require 'vendor/autoload.php';
$router = new App\Router\Router($_GET['url']);

$router->get('/', function(){ require('templates/home.php'); });
$router->get('/dashboard', 'User#dash');
$router->get('/objectifs', 'Stats#showObjectif');
$router->post('/objectif', 'Stats#addObjectif');
$router->get('/imc', 'Stats#showImc');
$router->get('/img', 'Stats#showImg');
$router->post('/addWeight', 'Stats#addWeight');
$router->get('/login', function(){ require('templates/log.php'); });
$router->post('/login', 'User#log');
$router->get('/logout', 'User#logout');
$router->get('/sign', function(){ require('templates/sign.php'); });
$router->post('/sign', 'User#sign');

$router->run();