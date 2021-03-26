<?php

namespace App\Controllers;

use \App\Mail;
use \Core\View;

class Home extends \Core\Controller
{

    //echo "hello from the index action in home controller";
    /*View::render('Home/index.php', [
        'name' => 'Stuart',
        'colours' => ['red','green','blue']
    ]);*/

    public function indexAction()
    {
      // Mail::send('stuartdaw@gmail.com','test', 'This is a test', '<h1>This is a test</h1>');
        View::renderTwigTemplate('Home/index.html');
    }

    // runs before every method
    protected function before()
    {
        // useful for checking to see if log in success or correct permissions
    }

    // runs after every method
    protected function after()
    {

    }

}

?>