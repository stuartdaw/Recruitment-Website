<?php

namespace App\Controllers\Admin;

use App\Flash;
use Core\View;
use \App\Models\User;
use \App\Authenticate;

// Controller to drive the login process

class Login extends \Core\Controller
{
    // renders the login page
    public function newAction()
    {
        View::renderTwigTemplate('Login/login.html');
    }

    // authenticates the users email and password
    public function createAction()
    {
        $user = User::authenticate($_POST['email'], $_POST['password']);
       // var_dump($_POST);
        $remember_me = isset($_POST['remember_me']);

        if($user)
        {
            Authenticate::login($user, $remember_me);

            Flash::addMessage('Login Successful');

            $this->redirect(Authenticate::getRememberedPage());

        } else {

            Flash::addMessage('Login unsuccessful, please try again');

            View::renderTwigTemplate('Login/login.html',
            [   'email' => $_POST['email'],
                'remember_me' => $remember_me
            ]);
        }
    }

    // log user out and destroy session
    // Using code from php.net to completely remove session information
    public function destroyAction()
    {
        Authenticate::logout();
        $this->redirect('/fyp/public/?Admin/Login/show-logout-message');

    }

    // Session is destroyed by Authenticate::logout() method
    // So message added to the new session
    public function showLogoutMessage()
    {
        Flash::addMessage('You have successfully Logged out');

        $this->redirect('/fyp/public/?');
    }


}

?>

