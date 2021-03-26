<?php

namespace Core;

use PDO;
use App\Config;


abstract class Model
{

    protected static function getDB()
    {
        static $db = null;

        if ($db === null) {
            try {
                $dsn = 'mysql:host=' . Config::DB_HOST . ';dbname=' . Config::DB_NAME;

                $db = new PDO($dsn, Config::DB_USER, Config::DB_PASSWORD);

                // throw an exception if connection error
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            } catch (\PDOException $e) {
                echo $e->getMessage();
            }
        }
        return $db;
    }
}

?>