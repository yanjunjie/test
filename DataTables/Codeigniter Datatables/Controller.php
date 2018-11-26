<?php

//v.01
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


//v.02

    public function ajaxCourseList()
    {

        $columns = array(
            0 =>'COURSE_ID',
            1 =>'COURSE_CODE',
            2=> 'COURSE_TITLE',
            3 =>'DEPT_NAME',

        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $totalData = $this->course_model->allposts_count();

        $totalFiltered = $totalData;

        if(empty($this->input->post('search')['value']))
        {
            $posts = $this->course_model->allCourse($limit,$start,$order,$dir);
        }
        else {
            $search = $this->input->post('search')['value'];
            $posts =  $this->course_model->posts_search($limit,$start,$search,$order,$dir)[0];
            $totalFiltered = $this->course_model->posts_search($limit,$start,$search,$order,$dir)[1];
        }

        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
            {
                $nestedData['COURSE_ID'] = $post->COURSE_ID;
                $nestedData['COURSE_CODE'] = $post->COURSE_CODE;
                $nestedData['COURSE_TITLE'] = $post->COURSE_TITLE;
                $nestedData['DEPT_NAME'] = $post->DEPT_NAME;
                $nestedData['ACTION'] ="

                <a class='label label-info openBigModal'
                id='$post->COURSE_ID'   data-action='course/courseInfo'
                data-type='edit' title='Course Information'><i class='fa fa-eye'></i>
                </a>&nbsp;

                <a class='label label-default openModal' id='$post->COURSE_ID'
                title='Update Course Information' data-action='course/courseFormUpdate'
                data-type='edit'><i class='fa fa-pencil'></i>
                </a>&nbsp;
                <a class='label label-danger deleteCourse'
                id='$post->COURSE_ID'  title='Click For
                Delete' data-action='setup/deleteDegree'
                data-type='delete' data-field='COURSE_ID'
                data-tbl='aca_course'><i class='fa fa-times'></i>
                </a>

                ";




                //$nestedData['body'] = substr(strip_tags($post->body),0,50)."...";
               // $nestedData['created_at'] = date('j M Y h:i a',strtotime($post->created_at));
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"            => intval($this->input->post('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        echo json_encode($json_data);
    }