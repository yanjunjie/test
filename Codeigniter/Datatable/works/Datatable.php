<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Datatable extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('datatable_model');

        header("Expires: Thu, 19 Nov 1981 08:52:00 GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
    }

    function index()
    {
        echo "404 Not Found";
    }

    //Datatables for course and session wise
    public function course_ses_wise_datatable()
    {

        $list = array();
        $list = $this->datatable_model->get_datatables('NM_APPLICATION');
        $NM_QUOTAs = $this->utilities->findAll('NM_QUOTA');

        $data = array();

        foreach ($list as $key=>$person)
        {
            $row = array();
            $row[] = '<a href="#" data-id="'.$person->APPLICATION_ID.'" class="btn btn-xs details">'.$person->FULL_NAME_ENG.'</a>';
            $row[] = $person->APPLICATION_ID;
            $row[] = $person->MERIT_POSITION;

            foreach ($NM_QUOTAs as $QUOTA_ID)
            {
                if($person->QUOTA_ID == $QUOTA_ID->QUOTA_ID){
                    $row[] = $QUOTA_ID->QUOTA_NAME;
                    break;
                }
            }

            $row[] = $person->ACTIVE_FLAG=="Y" ? '<span style="color:green;">Selected</span>':'<span style="color:red;">Not Selected</span>';
            $data[] = $row;
        }

        if(!empty($_POST['draw'])){
            $draw = $_POST['draw'];
        }else{
            $draw = 0;
        }

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $this->datatable_model->count_all('NM_APPLICATION'),
            "recordsFiltered" => $this->datatable_model->count_filtered("NM_APPLICATION"),
            "data" => $data,
        );

        //Check committee member
        if(empty($data)){

            echo '{"res":"no"}';

        }else {
            //output to json format
            echo json_encode($output);
        }

        exit();
    }

    //End Datatables for course and session wise


}


