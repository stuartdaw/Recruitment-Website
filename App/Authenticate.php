<?php

namespace App;

use App\Models\RememberedLogin;
Use App\Models\User;

// Handles login and user authentication
class Authenticate
{
    //Creates the session ID with user login ID
    public static function login($user, $remember_me)
    {
        // Update session ID to prevent fixation attacks
        session_regenerate_id(true);

        if (isset($user->RL_USER_ID)) {
            $_SESSION['user_id'] = $user->RL_USER_ID;
        } else {
            $_SESSION['user_id'] = $user->UA_USER_ID;
        }

        if($remember_me)
        {
          //  echo "<p>setting cookie...</p>";
            $user->rememberLogin();

            //echo "<p>in Authenticate/ login: " . $user->remember_token . "</p>";
          //  echo "<p>" . $user->expiry_timestamp . "</p><br/>";
            setcookie('remember_me', $user->remember_token, $user->expiry_timestamp, "/");
           // echo "<p>cookie: " . $_COOKIE['remember_me'] . "</p>";
        }
    }

    public static function logout()
    {
        // Unset all of the session variables.
        $_SESSION = array();

        // If it's desired to kill the session, also delete the session cookie.
        // Note: This will destroy the session, and not just the session data!
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        // Finally, destroy the session.
        session_destroy();

        static::forgetLogin();
    }

    // remember the requested page. If they log in can successfully can be redirected
    public static function rememberRequestedPage()
    {
        //echo "got Authenticate rememberRequestedPage() <br/>";

        $_SESSION['return_to'] = $_SERVER['REQUEST_URI'];
        //echo "return to: " . $_SESSION['return_to'] . "<br/>";

    }

    // Gets the page the user was trying to access
    public static function getRememberedPage()
    {
        return $_SESSION['return_to'] ?? '/fyp/public';
    }

    //get the details of the current logged in user
    public static function getUser()
    {
        if(isset($_SESSION['user_id']))
        {
            return User::findByID($_SESSION['user_id']);
        } else {
            return static::loginFromCookie();
        }
    }

    // Uses 'remember_me' token from cookie to automatically log user in
    protected static function loginFromCookie()
    {
        $cookie = $_COOKIE['remember_me'] ?? false;

        if($cookie)
        {
            $remembered_login = RememberedLogin::findByToken($cookie);

            /*   echo "<p>vardump:";
               var_dump($remembered_login);
               echo "end</p><br/>";*/

            /*echo "<p>RL_TOKEN_HASH: ". $remembered_login->RL_TOKEN_HASH . "</p><br/>";
            echo "<p>RL_USER_ID: ". $remembered_login->RL_USER_ID . "</p><br/>";
            echo "<p>RL_EXPIRES_AT: ". $remembered_login->RL_EXPIRES_AT . "</p><br/>";*/

            //$remembered_login->hasExpired();


            if($remembered_login && ! $remembered_login->hasExpired())
            {
                $user = $remembered_login->getUser();

                /*echo "<p>RL_TOKEN_HASH: ". $remembered_login->RL_TOKEN_HASH . "</p><br/>";
                echo "<p>RL_USER_ID: ". $remembered_login->RL_USER_ID . "</p><br/>";
                echo "<p>RL_EXPIRES_AT: ". $remembered_login->RL_EXPIRES_AT . "</p><br/>";*/

                static::login($user, false);

                return $user;
            }
        }
    }

    //forget remembered login
    protected static function forgetLogin()
    {
        $cookie = $_COOKIE['remember_me'] ?? false;
        if($cookie)
        {
            $remembered_login = RememberedLogin::findByToken($cookie);

            if($remembered_login)
            {
               $remembered_login->deleteRememberMeToken();
            }
            setcookie('remember_me', '', time() - 3600);

        }

    }
}

?>