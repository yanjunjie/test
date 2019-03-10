<?php
class Cia_lib{

//Existence checking, exists or not a value in a table
    public function cia_attr_exists()
    {
        $table=$this->input->post('table');
        $attr=$this->input->post('attr');
        $id=$this->input->post('id');
        $res = $this->utilities->findById($table, $attr, $id);
        if($res)
        {
            echo "yes";
        }
        else
        {
            echo "no";
        }
        exit();
    }

//Ajax Delete by ID
    public function cia_delete()
    {
        $table=$this->input->post('table');
        $attr=$this->input->post('attr');
        $id=$this->input->post('id');
        $res = $this->db->delete($table,array($attr=>$id));
        if($res){
            echo 'yes';
        }
	else
	{
	    echo 'no';
	}
	exit();
    }

/*
* Dependency Start ---------------------------------------------------------------------------
*/

//Ajax Find Dependency by Primary ID (One to Many relationship)
public function cia_dependency_by_id()
{
    $attr_val=$this->input->post('id');
    $table=$this->input->post('table');
    $attr=$this->input->post('attr');
    $view = $this->input->post('view');

    if($view and $attr_val and $table)
    {
        $data = array(
            'result'=>$this->utilities->findAllByAttribute($table, array($attr=>$attr_val))
        );
        $dependency = $this->load->view($view,$data,true);
        echo $dependency;
    }
    else
    {
        echo "no";
    }
    exit();
}

//Ajax Find Dependency by Join Two Table (One to Many Relationship by Foreign ID)
public function cia_dependency_by_join_two_tbl()
{
    /*
     * id is for table1
     * attr1 is in Condition
     * attr2 is both Table1 and Table2
     * */
    $data = array();
    $id=$this->input->post('id');
    $table1=$this->input->post('table');
    $table2=$this->input->post('table2');
    $attr1=$this->input->post('attr');
    $attr2=$this->input->post('attr2');
    $view = $this->input->post('view');

    $result = $this->db->query("
        select b.*
        from $table1 a
        left join $table2 b on b.$attr2 = a.$attr2
        where a.$attr1 = '$id'
    ")->result();

    if($result)
    {
        $data['result']= $result;
        $dependency = $this->load->view($view,$data,true);
        echo $dependency;
    }
    else
        echo "no";
    exit();
}

//Ajax Find Dependency by Joining Three Tables (One to Many and Many to One Relationship)
public function cia_dependency_by_one_to_many_to_one()
{
    /*
     * id is for table1
     * attr1 is both Table1 and Table2 as well as Condition
     * attr2 is both Table2 and Table3
     * */

    $data = array();
    $id=$this->input->post('id');
    $table1=$this->input->post('table');
    $table2=$this->input->post('table2');
    $table3=$this->input->post('table3');
    $attr1=$this->input->post('attr');
    $attr2=$this->input->post('attr2');
    $view = $this->input->post('view');

    $result = $this->db->query("
        select c.*
        from $table1 a
        left join $table2 b on b.$attr1 = a.$attr1
        left join $table3 c on c.$attr2 = b.$attr2
        where a.$attr1 = '$id'
    ")->result();

    if($result)
    {
        $data['result']= $result;
        $dependency = $this->load->view($view,$data,true);
        echo $dependency;
    }
    else
        echo "no";
    exit();
}


//Insertion Test
    public function insertion()
    {
		//note the s in the function name (keys)
		function array_keys_exists($array,$keys) 
		{
		    foreach($keys as $k) 
		    {
		        if(isset($array[$k])) 
		        {
		        	return true;
		        }
		    }
		    
		}


		/*
			$assi_data['SESSION_ID'] = $this->input->post('YSESSION_ID');
            $assi_data['CATEGORY'] = $this->input->post('LKP_ID');
            $assi_data['CRE_BY'] = $this->user['EMP_ID'];
            $assi_data['CRE_DT'] = date("Y-m-d G:i:s");

            unset($_POST['YSESSION_ID']);
            unset($_POST['LKP_ID']);

            //Start file upload
            $MATERIAL_FILE_PATH = '';
            if(!empty($_FILES['ATTACHMENT']['name']))
            {
                $file_ext = pathinfo($_FILES['ATTACHMENT']['name'],PATHINFO_EXTENSION);
                $config['upload_path'] = 'upload/assignments/materials/';
                $config['allowed_types'] = 'jpg|jpeg|doc|docx|pdf';
                $config['file_name'] = date('Y-m-d-H-i-s').'.'.$file_ext;

                //initialize configuration
                $this->upload->initialize($config);

                if($this->upload->do_upload('ATTACHMENT')){
                    $finfo = $this->upload->data(); //upload the file to the above mentioned path
                    $MATERIAL_FILE_PATH = $finfo['file_name'];
                }
            }
            //End file upload

            $assi_data['ATTACHMENT']=$MATERIAL_FILE_PATH;
            $assi_data = array_merge($_POST, $assi_data);

            $this->utilities->insertData($assi_data,'UMS_COURSE_MATERIALS');
		*/



		//useful to validate a form for example
		/*<form>
		    <input type="text" name="field1" /><br />
		    <input type="text" name="field2" /><br />
		    <input type="text" name="field3" /><br />
		    <input type="text" name="field4" /><br />
		    <input type="text" name="field5" /><br />
		</form>*/

		/*if(!array_keys_exists($_POST,
		array("field1","field2","field3","field4","field5")
		)) 
		{
		    //some fields are missing, dont do anything (maybe hacking)
		}
		else
		{
		    //code ...
		}*/


		/*if(preg_match("/".$key."/i", join(",", array_keys($arr))))                
        return true; 
    else 
        return false;*/

	}

    public function cia_insert()
    {
        $data['contentTitle'] = 'My Post';
        $data["breadcrumbs"] = array(
            "My Post" => '#'
        );
        $data['pageTitle'] = 'University student portal';
        $data['content_view_page'] = 'student/forum/my_post';

        $this->form_validation->set_rules('FORUM_TITLE', 'Forum title', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            $this->student_portal->display($data);
        }
        else
        {
            ini_set('max_execution_time', 0);
            ini_set("memory_limit", -1);
            $this->db->trans_begin();

           $data = $_POST;
           $data['CRE_BY'] = $this->STUDENT_ID;
           $data['CRE_DT'] = date("Y-m-d G:i:s");
           $data['IS_STUDENT'] = 'Y';
           $this->utilities->insertData($data, 'UMS_FORUM_MST');

            if ($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                echo 'no';
            }
            else
            {
                $this->db->trans_commit();
                echo 'yes';
            }
            exit();
        }
    }

    //Sample Modal For a View Load
    public function sample_modal_for_view_load()
    {
        $id = $_POST['id'];
        $data['CM_ID']=$id?$id:'';
        $data['CourseMaterialDetailsById'] = $this->student_model->CourseMaterialDetailsById($id);
        echo $this->load->view('admin/assignment/courseMaterialDetailsById', $data, true);
    }

	//Remove array element(s) if exists
	function array_keys_exists_remove($array,$keys)
	{
	    foreach($keys as $k)
	    {
	        if(isset($array[$k]))
	        {
	            unset($array[$k]);
	        }
	        return $array;
	    }
	}

	//Search and replace an element by its value in array
	public function array_replace_values ($find, $replace, $array) {
	    if (!is_array($array)) {
	        return str_replace($find, $replace, $array);
	    }

	    $newArray = [];
	    foreach ($array as $key => $value) {
	        $newArray[$key] = array_replace_by_value($find, $replace, $value);
	    }
	    return $newArray;
	}

	//Search and replace by keys in array // This replaces value not keys
	public function array_replace_keys($array, $keys)
    {
        //Here $keys is also an associative array, if match $array's key and $keys's key then replace the value of $array's value by $kyes's value
        foreach ($keys as $search => $replace)
        {
            if ( isset($array[$search]))
            {
                $array[$replace] = $array[$search];
                unset($array[$search]);
            }
        }
        //return $array;
        //If $keys have extra element then merge it with main array
        return array_merge($array,$keys);
    }

    private function yearInfo()
    {
      $currentYear=date("Y");
      $startYear=$currentYear-5;
      $endyear=$currentYear+5;
      $yearInfo=array();
      for($i=$startYear;$i<=$endyear;$i++)
      {
        $yearInfo[]=$i;
      }
      return $yearInfo;
    }

    function insertDataB($data, $tableName) {
        // values
        $arr_values = array_map(function($v) {
            //return "'$v'";
            return "\"$v\"";
        }, array_values($data));
        $values = implode(", ", $arr_values);

        // fields
        $fields = implode(',', array_keys($data));

        // query
        $sql = "INSERT INTO $tableName ($fields) VALUES ($values)";

        return $this->db->query($sql);
    }
    
    function updateDataB($tableName, $data, $condition)
    {
        //Data
        $arr_data = array_map(function($k, $v){
            //return "$k='$v'";
            return "$k=\"$v\"";
        }, array_keys($data), array_values($data));
        $data_str = implode(", ",$arr_data);

        //Condition
        $arr_con = array_map(function($k, $v){
            //return "$k='$v'";
            return "$k=\"$v\"";
        }, array_keys($condition), array_values($condition));
        $con_str = implode(" AND ",$arr_con);

        //Query
        $sql = "UPDATE $tableName SET $data_str WHERE $con_str";

        return $this->db->query($sql);
    }

    //Content shown on Modal ++++++++++++++++++++++
    public function cia_modal()
    {
        if(!empty($_POST['modalContent']))
        {
            $data=array();
            $id = $this->input->post('id');
            $table = $this->input->post('table');
            $attr = $this->input->post('attr');
            if($id and $table and $attr)
            {
                $data["result"] = $this->utilities->findAllByAttribute($table, array($attr=>$id));
            }
            $data['id'] = $id;
            $modalContent = $this->input->post('modalContent');
            echo $this->load->view($modalContent, $data, true);
        }
        else
            echo "<h3 class='text-danger text-center'>No content found!</h3>";
        exit();
    }

    //DataTable +++++++++++++++++++++++++
    function cia_datatable()
    {
        // storing  request (ie, get/post) global array to a variable
        $requestData = $_REQUEST;
        // table
        $table = $this->input->post('table');
        // sortable columns

        $sortable_cols = json_decode($_POST['searchable_cols']);
        // $sortable_cols = array('ROLL_NO','FULL_NAME_EN','DEPARTMENT');

        // presentable columns
        $presentable_cols = json_decode($_POST['presentable_cols']);
        $presentable_cols_str = implode(',', $presentable_cols);

        // sortable and searchable request data
        $limit = $requestData['length']; // limit
        $start = $requestData['start']; // offset
        $sortable_col = $sortable_cols[$requestData['order'][0]['column']]; //column
        $dir = $requestData['order'][0]['dir']; // 'asc' or 'desc'
        $search = $requestData['search']['value']; // a search string

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
                SELECT * FROM (SELECT $presentable_cols_str, ROWNUM RN 
                            FROM $table
                            WHERE a.COURSE_TITLE like '%$search%' 
                            OR b.DEPT_NAME like '%$search%'
                            ORDER BY $sortable_col $dir) k 
                WHERE RN BETWEEN $start and $limit
            ")->result();

            $query = $this->db->query("
                SELECT $presentable_cols_str
                FROM $table 
                WHERE " . array_walk($presentable_cols,"search_data") . " and rownum <= " . $requestData['length'] .
                "ORDER BY " . $sortable_cols[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir']
            )->result();
            $totalFiltered = $query;
        }
        else
        {
            //ORDER BY " . $sortable_cols[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . " ," . $requestData['length']
            $query = $this->db->query("
                SELECT $presentable_cols_str
                FROM $table
                WHERE rownum <= " . $requestData['length'] .
                " ORDER BY " . $sortable_cols[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir']
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
        exit;
    }
    //End Datatable

    
    /**
     * @method      Bootstrap Alert Message
     * @access      public
     * @author      Bablu <bablu@atilimited.net>
     * @return      Alert Message
     */
    function alert_message($type = '', $msg = '', $msg_prefix = '')
    {
        $alert = '';

        if($type == 'success' and $msg)
        {
            $alert = '<div class="alert alert-success alert-dismissible fade in">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <p><strong>' .($msg_prefix ? $msg_prefix : 'Success!'). '</strong> ' .$msg. '.</p>
                      </div>';
        }
        else if($type == 'info' and $msg)
        {
            $alert = '<div class="alert alert-info alert-dismissible fade in">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <p><strong>' .($msg_prefix ? $msg_prefix : 'Info!'). '</strong> ' .$msg. '.</p>
                      </div>';
        }
        else if($type == 'warning' and $msg)
        {
            $alert = '<div class="alert alert-warning alert-dismissible fade in">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <p><strong>' .($msg_prefix ? $msg_prefix : 'Warning!'). '</strong> ' .$msg. '.</p>
                      </div>';
        }
        else if($type == 'danger' and $msg)
        {
            $alert = '<div class="alert alert-danger alert-dismissible fade in">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <p><strong>' .($msg_prefix ? $msg_prefix : 'Error!'). '</strong> ' .$msg. '.</p>
                      </div>';
        }
        else
        {
            $alert = '<div class="alert alert-info alert-dismissible fade in">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <p><strong>Alert!</strong> The Alert Type & Text Message are required.</p>
                      </div>';
        }

        return $alert;
    }



}
//End Class


