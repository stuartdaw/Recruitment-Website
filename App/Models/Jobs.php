<?php


namespace App\Models;

use PDO;

class Jobs extends \Core\Model
{
    // pulls back the jobs for the lecturer to view
    public static function showActiveJobs($status = 'Open')
    {
        $sql = 'SELECT * 
                FROM POSITIONS
                WHERE P_STATUS = :status';

        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->bindValue(':status', $status, PDO::PARAM_STR   );
        $stmt->execute();

        return $stmt->fetchAll();
    }

    // pulls back the jobs for the lecturer to view
    public static function showJob($num)
    {
        $sql = 'SELECT * 
                FROM POSITIONS
                WHERE P_NUM = :pnum';

        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->bindValue(':pnum', $num, PDO::PARAM_STR   );
        $stmt->execute();

        return $stmt->fetchAll();
    }

    // add job to database
    public static function addJob()
    {
        //var_dump($_POST);
        $sql = 'INSERT INTO POSITIONS (P_REF, P_TITLE, P_UNIVERSITY, P_PROG, P_DESC, P_REQ, P_PHD, 
                P_MSC, P_DEGREE, P_TEACH_EXPERIENCE, P_IND_EXPERIENCE, P_STATUS, P_SESSION, P_ADDED_BY)
                VALUES(:ref, :title, :university, :prog, :desc, :req, :phd, :msc, :degree, :teach_exp,
                        :ind_exp, :status, :session, :added_by)';

        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $status = 'Open';
       /* $format = date('Y:m:d', strtotime($form['start']));
        $stmt->bindValue(':start', $format, PDO::PARAM_STR);*/

        $stmt->bindParam(':ref',$_POST['reference'], PDO::PARAM_STR);
        $stmt->bindParam(':title', $_POST['title'], PDO::PARAM_STR);
        $stmt->bindParam(':university', $_POST['university'], PDO::PARAM_STR);
        $stmt->bindParam(':prog', $_POST['programme'], PDO::PARAM_STR);
        $stmt->bindParam(':desc', $_POST['desc'], PDO::PARAM_STR);
        $stmt->bindParam(':req',$_POST['requirements'] , PDO::PARAM_STR);
        $stmt->bindParam(':phd', $_POST['phd'], PDO::PARAM_STR);
        $stmt->bindParam(':msc', $_POST['msc'], PDO::PARAM_STR);
        $stmt->bindParam(':degree', $_POST['degree'], PDO::PARAM_STR);
        $stmt->bindParam(':teach_exp', $_POST['teaching_exp'], PDO::PARAM_INT);
        $stmt->bindParam(':ind_exp',$_POST['industry_exp'] , PDO::PARAM_INT);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':session', $_POST['session'], PDO::PARAM_STR);
        $stmt->bindParam(':added_by', $_SESSION['user_id'], PDO::PARAM_STR);

        return  $stmt->execute();
    }

}

?>