<?php

namespace App\Controllers;

use App\Flash;
use Core\View;
use App\Authenticate;
//use Core\Controller;
//use App\Authenticate;

class UserAccount extends Admin\Authenticated
{
    // Display user account page if user is logged in
    public function indexAction()
    {
        View::renderTwigTemplate('/UserDetail/user_account.html');
      /*  View::renderTwigTemplate('/UserDetail/user_account.html', [
            'user' => Authenticate::getUser()
        ]);*/
    }

    // Displays edit user details form
    public function editAction()
    {
        View::renderTwigTemplate('/UserDetail/edit.html', [
            'user' => Authenticate::getUser()
        ]);
    }

    // update the user account in the database
    public function updateAction()
    {
        $user = Authenticate::getUser();

        if($user->updateUserAccount($_POST))
        {
            //echo "<p>ok</p>";
            Flash::addMessage("Update Successful");
            $this->redirect('/fyp/public/?UserAccount/index');
        } else {
            Flash::addMessage("Update Failed");
            View::renderTwigTemplate('/UserDetail/edit.html', [
                'user' => $user
            ]);
        }
    }

    // upload a c.v. to file
    public function uploadCV()
    {

    }
}

?>