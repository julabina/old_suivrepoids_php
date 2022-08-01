<?php

require 'vendor/autoload.php';
$router = new App\Router\Router($_GET['url']);

$dotenv = Dotenv\Dotenv::createImmutable('./');
$dotenv->load();

$router->get('/', function(){ require('templates/home.php'); });
$router->get('/dashboard', 'User#showDash');
$router->get('/objectifs', 'Stats#showGoals');
$router->post('/objectif', 'Stats#addGoal');
$router->get('/imc', 'Stats#showImc');
$router->get('/img', 'Stats#showImg');
$router->post('/addWeight', 'Stats#addWeight');
$router->get('/profil', 'User#showProfil');
$router->get('/login', function(){ require('templates/log.php'); });
$router->post('/login', 'User#log');
$router->get('/logout', 'User#logout');
$router->get('/sign', function(){ require('templates/sign.php'); });
$router->post('/sign', 'User#sign');
$router->post('/modifyProfil', 'User#modifyProfil');
$router->post('/modifyPassword', 'User#modifyPassword');
$router->post('/delete', 'User#deleteUser');
$router->get('/about', function(){ require('templates/about.php'); });
$router->get('/legal', function(){ require('templates/legal.php'); });
$router->get('cgu', function(){ require('templates/cgu.php'); });
$router->get('contact', function(){ require('templates/contact.php'); });
$router->get('/404', function(){ require('templates/404.php'); });

$router->run();