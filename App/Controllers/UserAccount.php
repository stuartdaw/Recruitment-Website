<?php

namespace App\Controllers;

use App\Flash;
use Core\View;
use App\Authenticate;
//use Core\Controller;
//use App\Authenticate;

class Profile extends Admin\Authenticated
{
    // Display Profile page if user is logged in
    public function indexAction()
    {
        View::renderTwigTemplate('/Profile/profile.html', [
            'user' => Authenticate::getUser()
        ]);
    }

    // Displays edit user details form
    public function editAction()
    {
        View::renderTwigTemplate('/Profile/edit.html', [
            'user' => Authenticate::getUser()
        ]);

    }

    // update the profile in the database
    public function updateAction()
    {
        $user = Authenticate::getUser();

        if($user->updateProfile($_POST))
        {
            //echo "<p>ok</p>";
            Flash::addMessage("Update Successful");
            $this->redirect('/fyp/public/?profile/index');
        } else {
            Flash::addMessage("Update Failed");
            View::renderTwigTemplate('/Profile/edit.html', [
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