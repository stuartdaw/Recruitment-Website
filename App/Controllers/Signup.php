<?php

namespace App\Controllers;

use \Core\View;
use App\Models\Post;


class Register extends \Core\Controller
{

    public $a = 'hey im a router';

    // runs before every method
    protected function before(){
     //   echo "Before: ";
    }

    // runs after every method
    protected function after(){
    // echo " :After";
    }



    public function indexAction() {
        /*echo "hello from the Register class. index function";
        echo "<p>Query string parameters: <pre>" .
                   htmlspecialchars(print_r($_GET, true)) . "</pre></p>";*/

        $posts = Post::getAll();

        View::renderTwigTemplate('Signup/newuser.html',
                [ 'posts' => $posts
            ]);

    }

    public function addNewAction() {
        echo "hello from the Register class, addNew function";
    }

    public function editAction()
    {
        echo "Hello from edit function in Register class";
        echo "<p>Route Params: <pre>" .
                htmlspecialchars(print_r($this->route_params, true)) . "</pre></p>";
    }

    public function __toStringAction(){
        return $this->a;
    }
}

?>

