<?php

namespace App\Router;

use App\Controllers\PostController;

/**
 * Router
 * 
 * Create routes
 */
class Router {

    private $url;
    private $routes = [];
    private $namedRoutes = [];

    public function __construct($url){
        $this->url = $url;
    }
    
    /**
     * add route whith GET method to all routes
     * @param string $path
     * @param function $callable
     * @param string $name
     * @param string $method
     * @return call addRoute()
     */
    public function get(string $path, $callable, $name = NULL) {
        
        return $this->addRoute($path, $callable, $name, 'GET');
        
    }
    
    /**
     * add route whith POST method to all routes
     * @param string $path
     * @param function $callable
     * @param string $name
     * @param string $method
     * @return call addRoute()
     */
    public function post(string $path, $callable, $name = NULL) {
        
        return $this->addRoute($path, $callable, $name, 'POST');
        
    }
    
    /**
     * create and add route to routes array
     * @param string $path
     * @param function $callable
     * @param string $name
     * @return $route
     */
    public function addRoute(string $path, $callable, $name, string $method) {
        
        $route = new Route($path, $callable);
        $this->routes[$method][] = $route;
        if(is_string($callable) && $name === null){
            $name = $callable;
        }
        if($name) {
            $this->namedRoutes[$name] = $route;
        }

        return $route;
        
    }
    
    /**
     * Check if road exist and if matche with $routes
     * @throws RouterException
     * @return call call()
     */
    public function run() {
        
        if(!isset($this->routes[$_SERVER['REQUEST_METHOD']])) {
            throw new RouterException('No routes exist');
        } 
        
        foreach($this->routes[$_SERVER['REQUEST_METHOD']] as $route) {
            
            if(!isset($this->url)) {
                $this->url = '/';
            }

            if($route->match($this->url)) {
                return $route->call();
            } 
            
        }
        
        http_response_code(404);
        header('Location: /suivi_poids/404');
        /* throw new RouterException('No routes matches'); */
        
    }

    /**
     * check url and call getUrl
     * @param string $name
     * @param array $params
     * @return call getUrl()
     */
    public function url($name, $params = []) {

        if(!isset($this->namedRoutes[$name])) {
            throw new RouterException('No route match this name');
        }

        return $this->namedRoutes[$name]->getUrl($params);
    }

}