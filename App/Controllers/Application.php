<?php


namespace App\Controllers;

// class to create and display applications

use App\Models\Applications;
use Core\View;
use App\Flash;
use function GuzzleHttp\describe_type;

class Application extends Admin\Authenticated
{

    // add constructor

    // show my applications page
    public function indexAction()
    {
        $app_details = Applications::getApplications();

//        var_dump($app_details);
        View::renderTwigTemplate('Applications/index.html', [
            'job_details' => $app_details
        ]);
    }

    // create a new application
    public function createApplication()
    {
        //var_dump($_POST);
        $applicant = [];
        $applicant['user_id'] = $_POST['userid'];
        $applicant['pos_id'] = $_POST['pid'];
        $applicant['app_date'] = Date('Y-m-d H:i:s', time());

        if(Applications::newApplication($applicant))
        {
            FLASH::addMessage('Succesfully applied');
            $this->indexAction();
        }
    }

    // Cancel Application
    public function withdrawApplication()
    {
        $applicant = [];
        $applicant['user_id'] = $_POST['userid'];
        $applicant['pos_id'] = $_POST['pid'];

        if(Applications::withdrawApp($applicant))
        {
            FLASH::addMessage('Succesfully withdrawn');
            $this->indexAction();
        }
    }

    // check if candidate has an application
    public static function applicationExist($job_list)
    {
        $list = Applications::getUserApps();

//        var_dump($list);
    }


}