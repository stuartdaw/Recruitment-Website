<?php


namespace App\Models;

use PDO;
use App\Mail;

class Applications extends \Core\Model
{
    //create a new application in the database
    public static function newApplication($applicant)
    {
/*        var_dump($applicant);*/
        $sql = 'INSERT INTO APPLICATION (APC_USER_ID, APC_POSKEY, APC_DATEAPPLY, APC_STATUS)
                VALUES (:lecturerID, :posID, :appDate, :status)';

        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->bindValue(':lecturerID', $applicant['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':posID', $applicant['pos_id'], PDO::PARAM_INT);
        $stmt->bindValue(':appDate', $applicant['app_date'], PDO::PARAM_STR);
        $stmt->bindValue(':status', 'Applied', PDO::PARAM_STR);

        return $stmt->execute();
    }

    // pull back application details
    public static function getApplications()
    {
        $sql  = 'SELECT APC_DATEAPPLY, APC_STATUS, P_NUM, P_TITLE, P_REF, P_UNIVERSITY
                 FROM APPLICATION A, POSITIONS P
                 WHERE A.APC_POSKEY = P.P_NUM
                 AND APC_USER_ID = :user';

        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Withdraw application from database
    public static function withdrawApp($applicant)
    {
        $sql  = 'DELETE FROM APPLICATION
                 WHERE APC_USER_ID = :lecturerID
                 AND APC_POSKEY = :posID';

        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->bindValue(':lecturerID', $applicant['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':posID', $applicant['pos_id'], PDO::PARAM_INT);

        return $stmt->execute();
    }

    // get list of applications that the user has applied for
    public static function getUserApps()
    {
        $sql  = 'SELECT P_NUM
                 FROM APPLICATION A, POSITIONS P
                 WHERE A.APC_POSKEY = P.P_NUM
                 AND APC_USER_ID = :user';

        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }


}