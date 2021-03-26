<?php

namespace App;

// class to create unique random token to be used in features
// such as remember me
class Token
{
    protected $token;

    // get token if provided else generate cryptography secure random byte combo
    // then convert this to hexadecimal so it can be stored in a database
    public function __construct($token_value = null)
    {
        if($token_value)
        {
            $this->token = $token_value;
        } else {
            $this->token = bin2hex(random_bytes(16));
        }
    }

    // return token as its protected
    public function getToken()
    {
        return $this->token;
    }

    // hash the token using hash based authentication code
    // combines token with secret key but better than a salt
    public function getHash()
    {
        return hash_hmac('sha256', $this->getToken(),Config::SECRET_KEY);
    }
}

?>