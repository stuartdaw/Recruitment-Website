<?php

namespace App\Controllers;

use App\Authenticate;
use \Core\View;
use App\Models\Profile;


class My_Profile extends \Core\Controller
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

        $profile = Profile::getAll();
        $user = Authenticate::getUser();
        //echo 'Current PHP version: ' . phpversion();
        View::renderTwigTemplate('Profile/profile.html',
            [ 'profile' => $profile,
                'user' => $user
            ]);

    }

    public function addNewAction() {
        echo "hello from the Signup class, addNew function";
    }

    public function editAction()
    {
        echo "Hello from edit function in Signup class";
        echo "<p>Route Params: <pre>" .
            htmlspecialchars(print_r($this->route_params, true)) . "</pre></p>";
    }

    public function __toStringAction(){
        return $this->a;
    }
}

?>

