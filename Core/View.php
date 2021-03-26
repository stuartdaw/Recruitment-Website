<?php

namespace Core;

use App\Models\Profile;

class View
{

    //render a new file
    public static function render($view, $args = [])
    {
        //convert array into variables for the view to use.
        extract($args, EXTR_SKIP);

        $file = "../App/Views/$view"; // relative to core directory

        if(is_readable($file)){
            require $file;
        } else {
            //echo "file not found";
            throw new \Exception("$file not found");

        }
    }

    //render a new file using twig template
    public static function renderTwigTemplate($template, $args = [])
    {
       echo static::getTemplate($template, $args);
    }

    // return html template
    public static function getTemplate($template, $args = [])
    {
        static $twig = null;

        if($twig === null)
        {
            $loader = new \Twig\Loader\FilesystemLoader('/opt/lampp/htdocs/fyp/App/Views');
            $twig = new \Twig\Environment($loader);
            //$twig->addGlobal('is_logged_in', \App\Authenticate::isLoggedIn());
            $twig->addGlobal('current_user', \App\Authenticate::getUser());
            $twig->addGlobal('flash_messages', \App\Flash::getMessages());
            //$twig->addGlobal( 'profile', Profile::getProfile());

            $template = $twig->load($template);

        }

        return $twig->render($template, $args);
    }
}


?>
