<?php

namespace App\Models;
use PDO;

class Profile extends \Core\Model
{

    //class constructor
    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        };
    }

    //get the posts into an object
    public static function getProfile()
    {
        try {
            $db = static::getDB();
            /*$sql = 'SELECT * FROM PROFILE
                    WHERE PF_USER_ID = :id';*/

            $sql = 'SELECT *
                    FROM PROFILE 
                    WHERE PF_USER_ID = :id';

            $stmt = $db->prepare($sql);
            $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);


            $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
            $stmt->execute();

            return $stmt->fetch();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    //get the qualifications
    public static function getQuals($q_num = 0)
    {
        //echo "QQQQ: " . $q_num . "  QQQQ";
        try {
            $db = static::getDB();

            if($q_num == 0) {
                $sql = 'SELECT * FROM QUALIFICATION
                        WHERE Q_USER_ID = :id';
            } else {
                $sql = "SELECT * FROM QUALIFICATION
                        WHERE Q_USER_ID = :id
                        AND Q_NUM = " . $q_num;
            }

            $stmt = $db->prepare($sql);
            $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);

            $stmt->execute();
            return $stmt->fetchAll();

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    //get the Experience
    public static function getExperience($e_num = 0)
    {
        try {
            $db = static::getDB();

            if($e_num == 0) {
                $sql = 'SELECT * FROM EXPERIENCE
                        WHERE E_USER_ID = :id';
            } else {
                $sql = "SELECT * FROM EXPERIENCE
                        WHERE E_USER_ID = :id
                        AND E_NUM = " . $e_num;
            }

            $stmt = $db->prepare($sql);
            $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);

            $stmt->execute();
            return $stmt->fetchAll();

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    //get the Skills
    public static function getSkills($s_num = 0)
    {
        try {
            $db = static::getDB();

            if($s_num == 0) {
                $sql = 'SELECT * FROM SKILLS
                        WHERE S_USER_ID = :id';
            } else {
                $sql = 'SELECT * FROM SKILLS
                        WHERE S_USER_ID = :id
                        AND S_NUM = ' . $s_num;
            }

            $stmt = $db->prepare($sql);
            $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);

            $stmt->execute();
            return $stmt->fetchAll();

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    // Update Personal preferences
    public static function updatePersonal($form)
    {
        $sql = 'UPDATE PROFILE
                    SET PF_DOB = :dob,
                        PF_ROAD = :road,
                        PF_UNIT= :unit,
                        PF_COUNTRY = :country,
                        PF_CODE = :code,
                        PF_PHONE= :phone,
                        PF_SEX = :sex
                    WHERE PF_USER_ID = :id';

        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $format = date('Y-m-d', strtotime($form['dob']));
        $stmt->bindValue(':dob', $format, PDO::PARAM_STR);

        $stmt->bindValue(':road', $form['address_line1'], PDO::PARAM_STR);
        $stmt->bindValue(':unit', $form['address_line2'], PDO::PARAM_STR);
        $stmt->bindValue(':country', $form['address_line3'], PDO::PARAM_STR);
        $stmt->bindValue(':code', $form['address_line4'], PDO::PARAM_STR);
        $stmt->bindValue(':sex', $form['gender'], PDO::PARAM_STR);
        $stmt->bindValue(':phone', $form['phone'], PDO::PARAM_STR);
        $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);


        return $stmt->execute();
    }

    // Update Availability
    public static function updateAvailability($form)
    {
        $sql = 'UPDATE PROFILE
                    SET PF_SESSION_DAY = :day_time,
                        PF_SESSION_EVENING = :evening
                    WHERE PF_USER_ID = :id';

        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->bindValue(':day_time', $form['day_time'], PDO::PARAM_STR);
        $stmt->bindValue(':evening', $form['evening'], PDO::PARAM_STR);

        $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);

        return $stmt->execute();
    }


    // Interacts with Qualification tables

    // Adds new qualification to database
    public static function addQualification($form)
    {
        $sql = 'INSERT INTO 
                    QUALIFICATION (Q_SCHOOL, Q_MAJOR, Q_NAME, Q_LEVEL, Q_DESC, Q_GRADYEAR, Q_CLASSIFICATION, Q_USER_ID)
                VALUES(:uni, :major, :name, :level, :desc, :grad_year, :classification, :id)';

        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':uni',$form['university'] , PDO::PARAM_STR);
        $stmt->bindParam(':major', $form['major'], PDO::PARAM_STR);
        $stmt->bindParam(':name', $form['qual_name'], PDO::PARAM_STR);
        $stmt->bindParam(':level', $form['level'], PDO::PARAM_STR);
        $stmt->bindParam(':desc', $form['qual_desc'], PDO::PARAM_STR);
        $stmt->bindParam(':grad_year', $form['grad_yr'], PDO::PARAM_INT);
        $stmt->bindParam(':classification', $form['classification'], PDO::PARAM_STR);
        $stmt->bindParam(':id', $_SESSION['user_id'], PDO::PARAM_INT);

        return  $stmt->execute();
    }

    // updates existing qualification to database
    public static function editQualification($form)
    {
        //echo "Aaaaa: " . $form['q_id'] . "bbbbbbb";

        $sql = 'UPDATE QUALIFICATION
                    SET Q_SCHOOL = :uni,
                        Q_MAJOR = :major,
                        Q_NAME = :name,
                        Q_LEVEL = :level,
                        Q_DESC = :desc,
                        Q_GRADYEAR = :grad_year,
                        Q_CLASSIFICATION = :classification
                    WHERE Q_NUM = :qnum';

        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':uni',$form['university'] , PDO::PARAM_STR);
        $stmt->bindParam(':major', $form['major'], PDO::PARAM_STR);
        $stmt->bindParam(':name', $form['qual_name'], PDO::PARAM_STR);
        $stmt->bindParam(':level', $form['level'], PDO::PARAM_STR);
        $stmt->bindParam(':desc', $form['qual_desc'], PDO::PARAM_STR);
        $stmt->bindParam(':grad_year', $form['grad_yr'], PDO::PARAM_INT);
        $stmt->bindParam(':classification', $form['classification'], PDO::PARAM_STR);
        $stmt->bindParam(':qnum', $form['q_id'], PDO::PARAM_INT);

        return  $stmt->execute();
    }



    // Interacts with Experience table

    // Adds new experience to database
    public static function addExperience($form)
    {
        $sql = 'INSERT INTO 
                    EXPERIENCE (E_ORG, E_POSITION, E_START, E_YEARS, E_DESC, E_USER_ID)
                VALUES(:org, :position, :start, :years, :desc, :id)';

        $db = static::getDB();

        $stmt = $db->prepare($sql);


        $format = date('Y:m:d', strtotime($form['start']));
        $stmt->bindValue(':start', $format, PDO::PARAM_STR);

        $stmt->bindParam(':org',$form['organisation'] , PDO::PARAM_STR);
        $stmt->bindParam(':position', $form['position'], PDO::PARAM_STR);
        $stmt->bindParam(':years', $form['years'], PDO::PARAM_INT);
        $stmt->bindParam(':desc', $form['desc'], PDO::PARAM_STR);
        $stmt->bindParam(':id', $_SESSION['user_id'], PDO::PARAM_INT);

        return  $stmt->execute();
    }

    // updates existing experience to database
    public static function editExperience($form)
    {
        //echo "Aaaaa: " . $form['q_id'] . "bbbbbbb";

        $sql = 'UPDATE EXPERIENCE
                    SET E_ORG = :org,
                        E_POSITION = :position,
                        E_START = :start,
                        E_YEARS = :years,
                        E_DESC = :desc
                    WHERE E_NUM = :e_num';

        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':org',$form['organisation'] , PDO::PARAM_STR);
        $stmt->bindParam(':position', $form['position'], PDO::PARAM_STR);
        $stmt->bindParam(':start', $form['start'], PDO::PARAM_STR);
        $stmt->bindParam(':years', $form['years'], PDO::PARAM_INT);
        $stmt->bindParam(':desc', $form['desc'], PDO::PARAM_STR);
        $stmt->bindParam(':e_num', $form['e_id'], PDO::PARAM_INT);

        return  $stmt->execute();
    }



    // Interacts with Skills tables

    // Adds new skill to database
    public static function addSkills($form)
    {
        $sql = 'INSERT INTO 
                    SKILLS (S_NAME, S_PROFICIENCY, S_DESC, S_USER_ID)
                VALUES(:name, :proficiency, :desc, :id)';

        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':name',$form['name'] , PDO::PARAM_STR);
        $stmt->bindParam(':proficiency', $form['proficiency'], PDO::PARAM_STR);
        $stmt->bindParam(':desc', $form['desc'], PDO::PARAM_STR);
        $stmt->bindParam(':id', $_SESSION['user_id'], PDO::PARAM_INT);

        return  $stmt->execute();
    }

    // updates existing skill to database
    public static function editSkills($form)
    {
        //echo "Aaaaa: " . $form['q_id'] . "bbbbbbb";

        $sql = 'UPDATE SKILLS
                    SET S_NAME = :name,
                        S_PROFICIENCY = :proficiency,
                        S_DESC = :desc
                WHERE S_NUM = :snum';

        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':name',$form['name'] , PDO::PARAM_STR);
        $stmt->bindParam(':proficiency', $form['proficiency'], PDO::PARAM_STR);
        $stmt->bindParam(':desc', $form['desc'], PDO::PARAM_STR);
        $stmt->bindParam(':snum', $form['sid'], PDO::PARAM_INT);

        return  $stmt->execute();
    }

}

?>