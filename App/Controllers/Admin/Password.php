<?php

namespace App\Controllers\Admin;

Use Core\View;
Use App\Models\User;

class Password  extends \Core\Controller
{
    //show login form
    public function resetFormAction()
    {
        View::renderTwigTemplate('Password/forgot.html');
    }

    // process the form details
    public function requestResetAction()
    {
        User::sendPasswordReset($_POST['email']);
        View::renderTwigTemplate('Password/reset_requested.html');
    }

    // confirm token and reset password reset form
    public function resetAction()
    {
        $token = $this->route_params['token'];

        $user = $this->getUserOrExit($token);

        View::renderTwigTemplate('Password/new_password.html', [
            'token' => $token
        ]);
    }

    // process new password
    public function resetPasswordAction()
    {
        $token = $_POST['token'];

        $user = $this->getUserOrExit($token);

        //echo "<br/>" . $_POST['password'] . "<br/>";

        if($user->resetPassword($_POST['password']))
        {
            //echo "<p>got here password/resetpassword</p>";
            View::renderTwigTemplate('Password/successful_password_update.html');


        } else {
            View::renderTwigTemplate('Password/new_password.html', [
                'token' => $token,
                'user' => $user
            ]);
            echo "invalid password";
        }
    }

    // get method to reset token or if token expired display expired view
    protected function getUserOrExit($token)
    {
        $user = User::findByPasswordResetToken($token);
        /*echo "<p>Dumping user:</p><br/>>";
        var_dump($user);*/


        if($user)
        {
            //echo "user returned <br/>";
            return $user;
        } else {
            View::renderTwigTemplate('Password/token_expired.html');
            exit;
        }
    }


}

?>

