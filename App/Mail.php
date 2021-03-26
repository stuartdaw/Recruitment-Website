<?php

namespace App;

use Mailgun\Mailgun;

class Mail
{
    //sends an email
    public static function send($to, $subject, $text, $html)
    {
        //$mgClient = new Mailgun(Config::MAILGUN_API_KEY);
        $mgClient = Mailgun::create(Config::MAILGUN_API_KEY);


        $domain = Config::MAILGUN_DOMAIN;

        $parameters = [
            'from'	=> "stuartdaw@gmail.com",
            'to'      => $to,
            'subject' => $subject,
            'text'    => $text,
            'html'  => $html
        ];

        $mgClient->messages()->send($domain, $parameters);
    }
}

?>

