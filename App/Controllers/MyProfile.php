<?php

namespace App\Controllers;

//use App\Authenticate;
use \App\Flash;
use \Core\View;
use App\Models\Profile;


class Myprofile extends Admin\Authenticated
{
    public function indexAction()
    {
        //$user = Authenticate::getUser();
        $profile = Profile::getProfile();
        $qualification = Profile::getQuals();
        $exp = Profile::getExperience();
        $skills = Profile::getSkills();
        /*echo "@@@@@@@@@";
        var_dump($skills);
        echo "@@@@@@@@@";*/
        //$skills = Skill::getSkills();
        View::renderTwigTemplate('Profile/profile.html', [
            'profile' => $profile,
            'qualification' => $qualification,
            'experience' => $exp,
            'skills' => $skills
        ]);
    }

    // Edit the user Profile
    public function editPersonalAction()
    {
        $profile = Profile::getProfile();
        View::renderTwigTemplate('/Profile/editpersonalinfo.html', [
            'profile' => $profile
        ]);

    }

    // Edit the user availability
    public function editAvailabilityAction()
    {
        $profile = Profile::getProfile();
        View::renderTwigTemplate('/Profile/editAvailability.html', [
            'profile' => $profile
        ]);

    }

    // Check and process personal data
    public function processPersonalDataAction()
    {
       /* echo "@@@@@@@@@";
        var_dump($_POST);
        echo "@@@@@@@@@";*/

        if(Profile::updatePersonal($_POST))
        {
            Flash::addMessage("Update Successful");
            $this->redirect('/fyp/public/?Myprofile/index');
        } else {
            Flash::addMessage("Update Failed");
            View::renderTwigTemplate('/Profile/editpersonalinfo.html', [
           ]);
        }
    }

    // Check and process personal data
    public function processAvailabilityAction()
    {
        /*echo "@@@@@@@@@";
        var_dump($_POST);
        echo "@@@@@@@@@";*/

        if(Profile::updateAvailability($_POST))
        {
            Flash::addMessage("Update Successful");
            $this->redirect('/fyp/public/?Myprofile/index');
        } else {
            Flash::addMessage("Update Failed");
            View::renderTwigTemplate('/Profile/editpersonalinfo.html', [
            ]);
        }
    }

    // Functions for controller to process adding, displaying and editing qualifications

    // add a new qualification
    public function addQualificationAction()
    {
        View::renderTwigTemplate('/Profile/addQualification.html', [
        ]);
    }

    // Add qualification to database
    public function processNewQualificationAction()
    {
        /*echo "@@@@@@@@@";
        var_dump($_POST);
        echo "@@@@@@@@@";*/

        if(Profile::addQualification($_POST))
        {
            Flash::addMessage("Update Successful");
            $this->redirect('/fyp/public/?Myprofile/index');
        } else {
            Flash::addMessage("Update Failed");
            View::renderTwigTemplate('/Profile/AddQualification.html', [
            ]);
        }
    }

    // add a new qualification
    public function editQualificationAction()
    {
        $qualification = Profile::getQuals($_POST['qid']);
      /*  echo "@@@@@@@@@";
        var_dump($qualification);
        echo "@@@@@@@@@";*/
        View::renderTwigTemplate('/Profile/editQualification.html', [
            'qualification' => $qualification
        ]);
    }

    // Updates existing qualification in the database
    public function processEditQualificationAction()
    {
        /*echo "@@@@@@@@@";
        var_dump($_POST);
        echo "@@@@@@@@@";*/

        if (Profile::editQualification($_POST)) {
            Flash::addMessage("Update Successful");
            $this->redirect('/fyp/public/?Myprofile/index');
        } else {
            Flash::addMessage("Update Failed");
            View::renderTwigTemplate('/Profile/editQualification.html', [
            ]);
        }
    }

    // Functions for controller to process adding, displaying and editing Experience

    // add a new experience
    public function addExperienceAction()
    {
        View::renderTwigTemplate('/Profile/addExperience.html', [
        ]);
    }

    // Add experience to database
    public function processNewExperienceAction()
    {
       /* echo "@@@@@@@@@";
        var_dump($_POST);
        echo "@@@@@@@@@";*/

        if(Profile::addExperience($_POST))
        {
            Flash::addMessage("Update Successful");
            $this->redirect('/fyp/public/?Myprofile/index');
        } else {
            Flash::addMessage("Update Failed");
            View::renderTwigTemplate('/Profile/AddExperience.html', [
            ]);
        }
    }

    // add a new experience
    public function editExperienceAction()
    {
        $experience = Profile::getExperience($_POST['eid']);
      /*  echo "@@@@@@@@@";
        var_dump($experience);
        echo "@@@@@@@@@";*/
        View::renderTwigTemplate('/Profile/editExperience.html', [
            'experience' => $experience
        ]);
    }

    // Updates existing experience in the database
    public function processEditExperienceAction()
    {
        /*echo "@@@@@@@@@";
        var_dump($_POST);
        echo "@@@@@@@@@";*/

        if (Profile::editExperience($_POST)) {
            Flash::addMessage("Update Successful");
            $this->redirect('/fyp/public/?Myprofile/index');
        } else {
            Flash::addMessage("Update Failed");
            View::renderTwigTemplate('/Profile/editExperience.html', [
            ]);
        }
    }



    // Functions for controller to process adding, displaying and editing skills

    // add a new skill
    public function addSkillsAction()
    {
        View::renderTwigTemplate('/Profile/addSkills.html', [
        ]);
    }

    // Add skills to database
    public function processNewSkillsAction()
    {
       /* echo "@@@@@@@@@";
        var_dump($_POST);
        echo "@@@@@@@@@";*/

        if(Profile::addSkills($_POST))
        {
            Flash::addMessage("Update Successful");
            $this->redirect('/fyp/public/?Myprofile/index');
        } else {
            Flash::addMessage("Update Failed");
            View::renderTwigTemplate('/Profile/AddSkills.html', [
            ]);
        }
    }

    // shows edit skills page
    public function editSkillsAction()
    {
//        echo "rrrr" . $_POST['sid'] . "rrrr";
        $skills = Profile::getSkills($_POST['sid']);
      /*  echo "@@@@@@@@@";
        var_dump($skills);
        echo "@@@@@@@@@";*/
        View::renderTwigTemplate('/Profile/editSkill.html', [
            'skills' => $skills
        ]);
    }

    // Updates existing skills in the database
    public function processEditSkillAction()
    {
       /* echo "@@@@@@@@@";
        var_dump($_POST);
        echo "@@@@@@@@@";*/

        if (Profile::editSkills($_POST)) {
            Flash::addMessage("Update Successful");
            $this->redirect('/fyp/public/?Myprofile/index');
        } else {
            Flash::addMessage("Update Failed");
            View::renderTwigTemplate('/Profile/editSkill.html', [
            ]);
        }
    }




}

?>

