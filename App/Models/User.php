<?php

namespace App\Models;

use App\Token;
use Core\View;
use PDO;
use App\Mail;
//use App\View;


class User Extends \Core\Model
{
    public $errors = [];

    //class constructor
    public function __construct($data = [])
    {
        foreach ($data as $key => $value){
            $this->$key = $value;
;        };
    }

    //save the new user to database
    public function save()
    {
        $this->validate();

        if(empty($this->errors)) {
            $password_hash = password_hash($this->password, PASSWORD_DEFAULT);

            $sql = 'INSERT INTO USERACC (UA_FIRST_NAME, UA_LAST_NAME, UA_EMAIL, UA_TYPE, UA_STATE, UA_PASSWORD_HASH)
                    VALUES (:firstname, :lastname, :email, :acct_type, :state, :password_hash)';

            if($this->acct_type == "lecturer")
            {
                $this->state = 'active';
            } else {
                $this->state = 'requested';
            }

            $db = static::getDB();

            $stmt = $db->prepare($sql);

            $stmt->bindParam(':firstname', $this->first_name, PDO::PARAM_STR);
            $stmt->bindParam(':lastname', $this->last_name, PDO::PARAM_STR);
            $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
            $stmt->bindParam(':acct_type', $this->acct_type, PDO::PARAM_STR);
            $stmt->bindParam(':state', $this->state, PDO::PARAM_STR);
            $stmt->bindParam(':password_hash', $password_hash, PDO::PARAM_STR);

            return $stmt->execute();
       }
       return false;
    }

    public function validate()
    {
        // Validate Email - using php function
        /*if(filter_var($this->email, FILTER_VALIDATE_EMAIL) === false)
        {
            $this->errors[] = "Invalid email";
        }*/

        // Check if its unique
        if(static::emailExists($this->UA_EMAIL, $this->UA_USER_ID ?? null))
        {
            $this->errors[] = 'Email already exists';
        }

        // Validate Password
        //  Must match
        /*if($this->password != $this->password_confirmation)
        {
            $this->errors[] = "Passwords need to match";
        }*/

        // correct length
        if(strlen($this->password) < 8)
        {
            $this->errors[] = "Password needs to be at least 8 characters";
        }

        // correct format
        // needs 1 number
        if(!preg_match('/[0-9]/', $this->password)) {
            $this->errors[] = 'Password needs at least 1 number';
        }

        // needs 1 letter
        if(!preg_match('/[A-Za-z]/', $this->password)) {
            $this->errors[] = 'Password needs at least 1 letter';
        }

        // needs 1 special chars
        if(!preg_match('/[!@#$%]/', $this->password)) {
            $this->errors[] = 'Password needs at least 1 special character (!,@,#,$,%)';
        }
    }

    // confirm if an email exists in th database
    public static function emailExists($email, $ignoreID = null)
    {
        $user = static::confirmLogin($email);

        if($user)
        {
            if($user->UA_USER_ID != $ignoreID)
            {
                return true;
            }
        }
        return false;
    }

    // retrieve a users record by using there email
    public static function confirmLogin($email)
    {
        $sql = 'SELECT * FROM USERACC WHERE UA_EMAIL = :email';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();

        return $stmt->fetch();
    }

    public static function authenticate($email, $password)
    {
        $user = static::confirmLogin($email);
        //echo "<p>Hey</p>";

        //echo $user->UA_PASSWORD_HASH;

        if($user)
        {
            if(password_verify($password, $user->UA_PASSWORD_HASH))
            {
                return $user;
            }
        }
        return false;
    }

    // find a users details by using ID
    public static function findByID($id)
    {
        $sql = 'SELECT * FROM USERACC WHERE UA_USER_ID = :id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();

        return $stmt->fetch();
    }

    // remember the login by inserting a unique token into the remembered_login table
    public function rememberLogin()
    {
        $token = new Token();
        $hashed_token = $token->getHash();
        $expiry_timestamp = time() + 60 * 60 * 24 * 150; // 150 days
        $format = date('Y-m-d H:i:s', $expiry_timestamp);

        // set the values as properties so can use to setup a cookie
        $this->remember_token = $token->getToken();
        $this->expiry_timestamp = $expiry_timestamp;

        /*echo "<p>in User/ rememberLogin: " . $this->remember_token . "</p>";
        echo "<p>" . $this->expiry_timestamp . "</p><br/>";*/


        $sql = 'INSERT INTO REMEMBER_LOGINS (RL_TOKEN_HASH, RL_USER_ID, RL_EXPIRES_AT)
                VALUES (:RL_TOKEN_HASH, :RL_USER_ID, :RL_EXPIRES_AT)';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':RL_TOKEN_HASH', $hashed_token, PDO::PARAM_STR);
        $stmt->bindValue(':RL_USER_ID', $this->UA_USER_ID, PDO::PARAM_INT);
        $stmt->bindValue(':RL_EXPIRES_AT', $format, PDO::PARAM_STR);

        return $stmt->execute();
    }

    // create function to update user details
    // $data is from a form to edit user profile
    public function updateUserAccount($data)
    {
        /*echo $this->first_name = $data['first_name'];
        echo $this->last_name = $data['last_name'];
        echo $this->email = $data['email'];
        echo $this->password = $data['password'];
        echo $this->UA_USER_ID;*/

        $this->first_name = $data['first_name'];
        $this->last_name = $data['last_name'];
        $this->email = $data['email'];
        $this->password = $data['password'];


        $this->validate();

        if(empty($this->errors))
        {
            $sql = 'UPDATE USERACC
                    SET UA_FIRST_NAME = :firstname,
                        UA_LAST_NAME = :lastname,
                        UA_EMAIL= :email,
                        UA_PASSWORD_HASH = :password_hash
                    WHERE UA_USER_ID = :id';

            $db = static::getDB();

            $stmt = $db->prepare($sql);

            $stmt->bindParam(':firstname', $this->first_name, PDO::PARAM_STR);
            $stmt->bindParam(':lastname', $this->last_name, PDO::PARAM_STR);
            $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
            $stmt->bindParam(':id', $this->UA_USER_ID, PDO::PARAM_INT);

            $password_hash = password_hash($this->password, PASSWORD_DEFAULT);
            $stmt->bindParam(':password_hash', $password_hash, PDO::PARAM_STR);

            return $stmt->execute();
        }
        return false;
    }

    // update database with token for login
    public static function sendPasswordReset($email)
    {
        $user = static::confirmLogin($email);
        //var_dump($user);
        if($user){
            if($user->startPasswordReset())
            {
                $user->sendPasswordResetEmail();
            } else {
                echo "ooops";
            }
        }
    }

    protected function startPasswordReset()
    {
        //echo "<p>Got here user startpasswordreset</p>";
        $token = new Token();
        $hashed_token = $token->getHash();
        $this->password_reset_token = $token->getToken();

        $expiry_timestamp = time() + 60 * 60 * 24; // 1 day
        $format = date('Y-m-d H:i:s', $expiry_timestamp);


        $sql = 'UPDATE USERACC
                SET UA_PASSWORD_RESET_HASH = :token_hash,
                    UA_PASSWORD_RESET_EXPIRY = :expires_at
                WHERE UA_USER_ID = :id';

        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':token_hash', $hashed_token, PDO::PARAM_STR);
        $stmt->bindParam(':expires_at', $format, PDO::PARAM_STR );
        $stmt->bindParam(':id', $this->UA_USER_ID, PDO::PARAM_INT);

        return $stmt->execute();
    }

    //sends password reset email
    protected function sendPasswordResetEmail()
    {
        $url = 'http://' . $_SERVER['HTTP_HOST'] . '/fyp/public/?Admin/Password/reset/' .
                    $this->password_reset_token;
        $text = View::getTemplate('Password/reset_email.txt', ['url' => $url]);
        $html = View::getTemplate('Password/reset_email.html', ['url' => $url]);

        Mail::send($this->UA_EMAIL, 'Password reset', $text, $html);
    }

    // Find a user by using token and check token hasnt expired
    public static function findByPasswordResetToken($token)
    {
        $token = new Token($token);
        $hashed_token = $token->getHash();

        $sql = 'SELECT * FROM USERACC
                 WHERE UA_PASSWORD_RESET_HASH = :token_hash';

        $db = static::getDB();

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':token_hash',$hashed_token, PDO::PARAM_STR);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();

        $user = $stmt->fetch();

        // check expiration date
        if($user)
        {

            if(strtotime($user->UA_PASSWORD_RESET_EXPIRY) > time())
            {
                //echo strtotime($user->password_reset_expiry);
                return $user;
            }
        }
    }

    // validate and add new data to the
    public function resetPassword($password)
    {
        $this->password = $password;

        $this->validate();

        if(empty($this->errors))
        {
            $password_hash = password_hash($this->password, PASSWORD_DEFAULT);

            $sql = 'UPDATE USERACC
                    SET UA_PASSWORD_HASH = :password_hash,
                    UA_PASSWORD_RESET_HASH = NULL,
                    UA_PASSWORD_RESET_EXPIRY = NULL
                    WHERE UA_USER_ID = :id';

            $db = static::getDB();

            $stmt = $db->prepare($sql);

            $stmt->bindParam(':password_hash',$password_hash, PDO::PARAM_STR);
            $stmt->bindParam(':id', $this->UA_USER_ID, PDO::PARAM_INT);

            return $stmt->execute();
        }
        return false;
    }
}

?>

