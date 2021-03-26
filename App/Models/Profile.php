<?php

namespace App\Models;
use PDO;

class Post extends \Core\Model
{
    //get the posts into an associative array
    public static function getAll()
    {
        try {
            //$db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

            $db = static::getDB();
            $stmt = $db->query("SELECT id, title, content FROM posts");

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch ( PDOException $e) {
            echo $e->getMessage();
        }
        return $results;

    }
}

?>