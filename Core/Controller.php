<?php

namespace Core;

abstract class Controller
{
    protected $route_params = [];

    // constructor function
    public function __construct($route_params){
        $this->route_params = $route_params;
    }

    // magic method to control when functions are run
    public function __call($name, $arguments)
    {
        $method = $name . 'Action';
        if(method_exists($this, $method)){
            if($this->before()!== false) {
                call_user_func_array([$this, $method], $arguments);
                $this->after();
            }
        } else {
            //echo "Method $method not found in controller " . get_class($this);
            throw new \Exception("Method $method not found in controller " . get_class($this));
        }
    }

    // runs before every method
    protected function before(){

    }

    // runs after every method
    protected function after(){

    }

    // Central redirect method to simplify other classes
    public function redirect($url)
    {
        header('Location: http://' . $_SERVER['HTTP_HOST'] . $url, true, 303);
        exit;
    }
}

?>

