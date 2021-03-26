<?php

namespace App\Controllers\Admin;


class Authenticated extends \Core\Controller
{
    // function runs before pages which need the login to be confirmed
    protected function before()
    {
        $this->requireLogin();
    }

}



?>