<?php

namespace App\Controllers;

use \Core\View;
//use App\Models\Post;
use App\Models\User;


class Signup extends \Core\Controller
{

    public function indexAction() {
        View::renderTwigTemplate('Signup/newuser.html');
    }

    public function editAction()
    {
        echo "<p>Route Params: <pre>" .
                htmlspecialchars(print_r($this->route_params, true)) . "</pre></p>";
    }

    // Pass the user information from the form to the User model class
    public function createAction()
    {
        $user = new User($_POST);

        if($user->save())
        {
            $this->redirect('/fyp/public/?signup/success');
        } else {
            View::renderTwigTemplate('Signup/newuser.html',
                [ 'user' => $user
                ]);
        }
    }

    // Show the signup success page.
    // Post, redirect, get method to stop multiple form entries
   public function successAction()
    {
        View::renderTwigTemplate('Signup/successfulSignup.html');
    }
}

?>

