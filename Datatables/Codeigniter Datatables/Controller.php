<?php
 public function dataTables()
    {
        $list = $this->utilities->get_datatables('NM_APPLICATION');
        $data = array();

        foreach ($list as $key=>$person)
        {
            $row = array();
            $row[] = $person->FULL_NAME_ENG;
            $row[] = $person->APPLICATION_ID;
            $row[] = $person->MERIT_POSITION;
            $row[]='';
	     $row[] ='
		<a href="" class="btn btn-warning btn-xs">Edit</a>
		<button onclick="return confirmDel();" class="btn btn-danger btn-xs"> Delete </button>
	    ';
            //$row[] = $person->QUOTA_NAME;

            $data[] = $row;
        }

        if(!empty($_POST['draw'])){
            $draw = $_POST['draw'];
        }else{
            $draw = 0;
        }

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $this->utilities->count_all('NM_APPLICATION'),
            "recordsFiltered" => $this->utilities->count_filtered("NM_APPLICATION"),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }
