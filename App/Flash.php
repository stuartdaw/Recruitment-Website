<?php

namespace App;

class Flash
{
    // create flash_notifications array if it doesn't exist
    public static function addMessage($message)
    {
        if (!isset($_SESSION['flash_notifications'])) {
            $_SESSION['flash_notifications'] = [];
        }


        // add message to flash_notifications array
        $_SESSION['flash_notifications'][] = $message;
    }

    //if there are messages that should be displayed this function returns
    public static function getMessages()
    {
        if(isset($_SESSION['flash_notifications']))
        {
            $messages = $_SESSION['flash_notifications'];
            unset($_SESSION['flash_notifications']);

            return $messages;
        }
    }
}


?>

