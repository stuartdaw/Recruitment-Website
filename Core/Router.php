<?php

namespace Core;


// Routes the user action to the correct class and method for the correct controller

class Router {

    // Associative array for the routing table
    protected $routes = [];

    // Params from the matched route
    protected $params = [];



    public function add($route, $params = []){
        // convert the route to a  regular expression
        $route = preg_replace('/\//','\\/', $route);

        // convert variables to a action
        $route = preg_replace('/\{([a-z]+)\}/','(?P<\1>[A-Z-]+)',$route);

        // convert variables to a controller
        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/','(?P<\1>\2)',$route);

        // add start and end-delimiters and case insensitive flag
        $route = '/^' . $route . '$/i';
        
        $this->routes[$route] = $params;
        
    }



    // look for match in the routing table
   public function match($url){
        foreach ($this->routes as $route => $params){
            if (preg_match($route, $url,$matches)) {
               foreach ($matches as $key => $match) {
                   if (is_string($key)) {
                       $params[$key] = $match;
                   }
                }
                   $this->params = $params;
                   return true;
            }
        }
        return false;
    }


    // Accessor functions
    public function getParams(){
        return $this->params;
    }

    // get all routes
    public function getRoutes(){
        return $this->routes;
    }

    // Other functions
    public function dispatch($url){
        $url = $this->removeQueryStringVariables($url);

        if($this->match($url)){
            $controller = $this->params['controller'];
            $controller = $this->convertToTitleCase($controller);
            //$controller = "App\Controllers\\$controller";
            $controller = $this->getNamespace() . $controller;
           /* echo $controller;
            echo "<p>routes: <pre>";
                  print_r($this->routes);
            echo "</pre>";

            echo "<p>params: <pre>";
                print_r($this->params);
            echo "</pre></p>";*/


            if (class_exists($controller)){
                    $controller_object = new $controller($this->params);

                    $action = $this->params['action'];
                    $action = $this->convertToCamelCase($action);

                    //echo "<p>#$controller->$action#</p>";

                    //if(is_callable([$controller_object, $action])){
                    if(preg_match('/action$/i', $action) == 0 ){
                        $controller_object->$action();
                    } else {
                        echo "method $action (in controller $controller) not found";
                        throw new \Exception("Method $action (in controller $controller) be called directly:" .
                                    " remove action suffix for this method");
                    }
            } else {
               // echo "Controller class $controller not found";
                throw new \Exception("Controller class $controller not found in controller ");

            }
        } else {
          // echo "no match found";
        throw new \Exception('No route matched');
        }
    }


    public function convertToTitleCase($string){
        return str_replace(' ', '', ucwords(str_replace('-',' ',$string)));

    }

    public function convertToCamelCase($string){
        return lcfirst($this->convertToTitleCase($string));
    }

    protected function removeQueryStringVariables($url){
        if($url != ''){
            $parts = explode('&', $url, 2);

            /*foreach ($parts as $part) {
                echo "<p>$part</p>";
            }*/

            if(strpos($parts[0], '=') === false) {
                $url = $parts[0];
            } else {
                $url = '';
             }
        }
        return $url;
    }

    // Get the namespace to for the controller class
    protected function getNamespace()
    {
        $namespace = 'App\Controllers\\';
       /* echo "<p>In get namespace</p>";
        echo "<p>namespace: <pre>";
            print_r($this->params[$namespace]);
        echo "</pre></p>";*/

        if(array_key_exists('namespace', $this->params)){
            $namespace .= $this->params['namespace'] . '\\';
        }

        return $namespace;
    }

}

