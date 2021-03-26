<?php

namespace App\Controllers\Admin;

Use \App\Token;

class Users extends \Core\Controller
{
    // runs before every method
    protected function before(){

    }

    // runs after every method
    protected function after(){

    }

    public function indexAction(){
        echo "User: admin index ";
    }

}

?>