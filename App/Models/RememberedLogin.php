<?php

namespace App\Models;

Use App\Token;
use PDO;


class RememberedLogin extends \Core\Model
{
    // returns remembered Login user
    public static function findByToken($token)
    {
        $token = new Token($token);
        $token_hash = $token->getHash();

        $sql = 'SELECT * FROM REMEMBER_LOGINS
                WHERE RL_TOKEN_HASH = :token_hash';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':token_hash', $token_hash, PDO::PARAM_STR);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        return $stmt->fetch();
    }

    // return object of user class
    public function getUser()
    {
        return User::findByID($this->RL_USER_ID);
    }

    // check if remember me has expired
    public function hasExpired()
    {
        //echo "<p>" . strtotime($this->RL_EXPIRES_AT) . "</p><br/>";

        return strtotime($this->RL_EXPIRES_AT) < time();
    }

    // deletes remember me login token when user wants to be logged out
    public function deleteRememberMeToken()
    {
        $sql = 'DELETE FROM REMEMBER_LOGINS
                WHERE RL_TOKEN_HASH = :token_hash';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':token_hash', $this->RL_TOKEN_HASH, PDO::PARAM_STR);

        $stmt->execute();
    }
}
?>