<?php

namespace App\Router;


/**
 * Route
 * 
 * Manage route
 */
class Route {

    private $path;
    private $callable;
    private $matches = [];
    private $params = [];

    public function __construct($path, $callable) {

        $this->path = trim($path, '/');
        $this->callable = $callable;

    }

    /**
     * Regex method for manage param captur
     * @param string $param
     * @param string $regex
     */
    public function with(string $param,string $regex) {
        
        $this->params[$param] = str_replace('(', '(?:', $regex);
        return $this;
        
    }
    
    /**
     * check if url = route
     * and captur param
     * @param string $url
     * @return boolean
     */
    public function match(string $url): bool {
        
        // remove '/'
        $url = trim($url, '/');
        $path = preg_replace_callback('#:([\w]+)#', [$this, 'paramMatch'] , $this->path);
        $regex = "#^$path$#i";
        //watch if url = path
        if (!preg_match($regex, $url, $matches)) {
            return false;
        }
        
        // Delete the first element of matches array
        array_shift($matches);
        
        $this->matches = $matches;

        return true;
        
    }
    
    /**
     * Captur all param 
     * @param array $match
     * @return string
     */
    private function paramMatch($match): string {
        
        if(isset($this->params[$match[1]])) {
            return '(' . $this->params[$match[1]] . ')';
        }
        
        return '([^/]+)';
    }
    
    /**
     * Call the callable route 
     * @return call call_user_func_array()
     */
    public function call() {

        if(is_string($this->callable)) {
            $params = explode('#', $this->callable);
            
            $controller = "App\\Controllers\\" . $params[0] . "Controller";
            $ctrl = new $controller();
            
            return call_user_func_array([$ctrl, $params[1]], $this->matches);
        } else {
            return call_user_func_array($this->callable, $this->matches);
        }
        
    }
    
    /**
     * create url
     * @param array $params
     * @return string
     */
    public function getUrl($params): string {
        $path = $this->$path;

        foreach($params as $id => $value) {
            $path = str_replace(':$id', $value, $path);
        }

        return $path;

    }

}