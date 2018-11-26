<?php

//V.01

    //Datatables
    function _get_datatables_query($table)
    {

        $DEGREE_ID = $this->input->post('DEGREE_ID');
        $SESSION_ID = $this->input->post('SESSION_ID');

        //Form data
        $whereeeeeeeee = ['COURSE_ID'=>$DEGREE_ID, 'SESSION_ID'=>$SESSION_ID];


        //Searchable columns
        $column = array('FULL_NAME_ENG','APPLICATION_ID', 'MERIT_POSITION');
        $order = array('MERIT_POSITION' => 'desc');

        $this->db->from($table);

        $this->db->where($whereeeeeeeee);

        $i = 0;
        foreach ($column as $item)
        {
            if(!empty($_POST['search']['value']))
            {
                ($i === 0) ? $this->db->like($item, $_POST['search']['value']) : $this->db->or_like($item, $_POST['search']['value']);
            }

            $column[$i] = $item;
            $i++;
        }

        if(isset($_POST['order']))
        {
            $this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else
        {
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables($table)
    {
        $this->_get_datatables_query($table);

        if(!empty($_POST['length']))
        {
            if($_POST['length'] != -1)
            {
                $this->db->limit($_POST['length'], $_POST['start']);
            }
        }

        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($table)
    {
        $this->_get_datatables_query($table);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function count_all($table)
    {
        $this->db->from($table);
        return $this->db->count_all_results();
    }
    //End Datatables



//V.02

    //Datatable
    function dataTables()
    {

        $user_data = $this->session->userdata("logged_in");
        $COMMITTEE_ID = $this->input->post('COMMITTEE_ID');

        $result = $this->utilities->findAllByAttribute('NM_COMMITTEECHD', array('COMMITTEE_ID' => $COMMITTEE_ID));
        $found = 0;
        foreach ($result as $row){
            if($row->EMP_NO == $user_data['EMP_NO']){
                $found = 1;
                break;
            }
        }

        $list = array();
        $list = $this->utilities->get_datatables('NM_APPLICATION');
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

            $row[] = $person->ACTIVE_FLAG=="M" ? '<button data-id="'. $person->APPLICATION_ID .'" class="btn btn-danger btn-xs deselectAsMerit">Remove from Merit List</button>':'<button data-id="'. $person->APPLICATION_ID .'" class="btn btn-info btn-xs selectAsMerit">Add to Merit List</button>';

            $row[] = $person->ACTIVE_FLAG=="W" ? '<button data-id="'. $person->APPLICATION_ID .'" class="btn btn-danger btn-xs deselectAsWaiting">Remove from Waiting List</button>':'<button data-id="'. $person->APPLICATION_ID .'" class="btn btn-warning btn-xs selectAsWaiting">Add to Waiting List</button>';

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

        //Check committee member
        if(empty($found)){

            echo '{"res":"no"}';

        }else {
            //output to json format
            echo json_encode($output);
        }

        exit();
    }

    //End Datatable



//V.03

    function ajaxDatatableIndex()
    {
        $data['pageTitle'] = 'Blog List';
        $data['breadcrumbs'] = array('Blog List' => '#',);
        $data['content_view_page'] = 'teacher/ajax_datatable';
        $this->admin_template->display($data);
    }

    function ajaxDataTableDemo()
    {
        // table
        $table = $this->input->post('table');

        // storing  request (ie, get/post) global array to a variable
        $requestData = $_REQUEST;

        // sortable columns
        $sortable_cols = json_decode($_POST['searchable_cols']);

        /*$sortable_cols = array(
            'ROLL_NO','FULL_NAME_EN','DEPARTMENT'
        );*/

        // presentable columns
        $presentable_cols = json_decode($_POST['presentable_cols']);

        // getting total number records without any search
        $query = $this->db->query("SELECT ROLL_NO, FULL_NAME_EN, DEPARTMENT FROM students_info")->num_rows();

        // total number of records
        $totalData = $query;
        // default total number of filtered records
        $totalFiltered = $totalData;

        if (!empty($requestData['search']['value']))
        {
            // if there is a search parameter
            $query = $this->db->query("SELECT ROLL_NO, FULL_NAME_EN, DEPARTMENT FROM students_info WHERE ROLL_NO LIKE '" . $requestData['search']['value'] . "%' OR FULL_NAME_EN LIKE '" . $requestData['search']['value'] . "%' OR DEPARTMENT LIKE '" . $requestData['search']['value'] . "%' ORDER BY " . $sortable_cols[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['start'] . " ," . $requestData['length'] . " ")->result();
            $totalFiltered = $query;
        }
        else
        {
            $query = $this->db->query("SELECT ROLL_NO, FULL_NAME_EN, DEPARTMENT FROM students_info  ORDER BY " . $sortable_cols[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . " ")->result();
        }

        // loop for presentable columns records
        $data = array();
        foreach ($query as $row)
        {
            // preparing a record
            $nestedData = array();

            foreach ($presentable_cols as $presentable_col)
            {
                $nestedData[] = $row->$presentable_col;
            }

            // all records
            $data[] = $nestedData;
        }

        $json_data = array("draw" => intval($requestData['draw']),
            // for every request/draw by clientside
            "recordsTotal" => intval($totalData),
            // total number of records
            "recordsFiltered" => intval($totalFiltered),
            // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data" => $data

        );

        echo json_encode($json_data);
    }



//V04
function ajaxDataTable()
{
    // storing  request (ie, get/post) global array to a variable
    $requestData = $_REQUEST;

    // table
    $table = $this->input->post('table');

    // sortable columns
    $sortable_cols = json_decode($_POST['searchable_cols']);
    /*$sortable_cols = array('ROLL_NO','FULL_NAME_EN','DEPARTMENT');*/

    // presentable columns
    $presentable_cols = json_decode($_POST['presentable_cols']);
    $presentable_cols_str = implode(',', $presentable_cols);

    // search data from table
    function search_data($value,$key,$presentable_cols)
    {
        echo "$key LIKE '" . $_REQUEST['search']['value'] . "%'";
    }

    // getting total number records without any search
    $query = $this->db->query("SELECT $presentable_cols_str FROM $table")->num_rows();

    // total number of records
    $totalData = $query;
    // default total number of filtered records
    $totalFiltered = $totalData;

    if (!empty($requestData['search']['value']))
    {
        // if there is a search parameter
        $query = $this->db->query("
                SELECT $presentable_cols_str
                FROM $table 
                WHERE ".array_walk($presentable_cols,"search_data")."
                ORDER BY " . $sortable_cols[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . " ," . $requestData['length']
        )->result();
        $totalFiltered = $query;
    }
    else
    {
        $query = $this->db->query("
                SELECT $presentable_cols_str
                FROM $table
                ORDER BY " . $sortable_cols[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . " ," . $requestData['length']
        )->result();
    }

    // loop for presentable columns records
    $data = array();
    foreach ($query as $row)
    {
        // preparing a record
        $nestedData = array();

        foreach ($presentable_cols as $presentable_col)
        {
            $nestedData[] = $row->$presentable_col;
        }

        // all records
        $data[] = $nestedData;
    }

    $json_data = array("draw" => intval($requestData['draw']),
        // for every request/draw by clientside
        "recordsTotal" => intval($totalData),
        // total number of records
        "recordsFiltered" => intval($totalFiltered),
        // total number of records after searching, if there is no searching then totalFiltered = totalData
        "data" => $data

    );

    echo json_encode($json_data);
}


