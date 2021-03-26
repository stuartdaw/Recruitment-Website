<?php

namespace App\Controllers;

use \Core\View;

class Home extends \Core\Controller
{


    public function indexAction(){
        //echo "hello from the index action in home controller";
        /*View::render('Home/index.php', [
            'name' => 'Stuart',
            'colours' => ['red','green','blue']
        ]);*/

        View::renderTwigTemplate('Home/index.html', [
            'name' => 'Stuart',
            'colours' => ['red','green','blue']
        ]);
    }

    // runs before every method
    protected function before(){
       // echo "Before: ";
        // check login()
        // useful for checking to see if log in success or correct permissions
    }

    // runs after every method
    protected function after(){
      //  echo " :After";
    }

}

?>