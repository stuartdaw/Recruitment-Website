<?php

namespace App\Controllers;

use App\Authenticate;
use App\Controllers\Application;
use App\Controllers\Admin\Authenticated;
use App\Flash;
use App\Models\Jobs;
use Core\View;


// Class to control display and access for jobs offered by the university

class Jobpostings extends Authenticated
{

    // display table
    public function indexAction()
    {
        $user = Authenticate::getUser();
        // check type of user
       if($user)
        {
           if($user->UA_TYPE == 'Lecturer')
           {
               $job_list = Jobs::showActiveJobs();

               /*$job_list = Jobs::showActiveJobs();
               $job_list = Application::applicationExist($job_list);*/
               //var_dump($job_list);
               View::renderTwigTemplate('/JobPostings/Job_list.html', [
                   'job_list' => $job_list
             ]);
           } elseif ($user->UA_TYPE == 'SIM MGMT')
           {
               $job_list = Jobs::showActiveJobs();

               View::renderTwigTemplate('/JobPostings/sim_job_list.html', [
                   'job_list' => $job_list
               ]);
           }

        } else {
            echo "WHO ARE YOU!!";
        }
    }

    //display full job details
    public function createShowJobAction()
    {
        $job = Jobs::showJob($_POST['pid']);

        View::renderTwigTemplate('/JobPostings/Job_page.html', [
            'job_details' => $job
        ]);
    }

    // add new job posting
    public function addJobPage()
    {
        View::renderTwigTemplate('/JobPostings/add_new_job.html');
    }

    // send new job to be added to database in the model class
    public function addNewJob()
    {
        if (Jobs::addJob()) {
            Flash::addMessage("Update Successful");
            $this->redirect('/fyp/public/?Jobpostings/index');
        } else {
            Flash::addMessage("Update Failed");
            View::renderTwigTemplate('/JobPostings/add_new_job.html', [
            ]);
        }
    }



}


?>