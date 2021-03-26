<?php

namespace App\Controllers;

use \App\Models\User;

class Account extends \Core\Controller
{
    //Validate using AJAX whether email is unique
    public function validateEmailAction()
    {
        //var_dump($_GET);
        $is_valid = ! User::emailExists($_GET['email']);

        header('Content-Type: application/json');
        echo json_encode($is_valid);
        echo "<p>HELLO</p>";

    }
}

?>