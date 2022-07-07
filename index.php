<?php

require 'vendor/autoload.php';

$router = new App\Router\Router($_GET['url']);

$router->get('/', function(){ echo "homepage"; });

$router->run();