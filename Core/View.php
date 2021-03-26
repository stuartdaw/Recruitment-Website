<?php

class View
{

    //render a new file
    public static function render($view){
        $file = "../App/Views/$view"; // relative to core directory

        if(is_readable($file)){
            require $file;
        } else {
            echo "file not found";
        }
    }


}


?>