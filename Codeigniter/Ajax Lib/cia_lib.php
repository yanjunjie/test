<?php
class Ci_ajax_lib{

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
    public function cia_delete_by_id()
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


//Ajax Find View by ID (One to Many relationship)
    public function ajax_find_view_by_id()
    {
        $table=$this->input->post('table');
        $attr=$this->input->post('attr');
        $attr_val=$this->input->post('attr_val');
        $url_data=$this->input->post('url_data');
        $view = $this->input->post('view');


        if($view and ($attr_val or $url_data ) and $table)
        {
            $data = array(
                'result'=>$url_data?$this->utilities->findByAndWhere($table, $url_data):$this->utilities->findAllById($table, $attr, $attr_val)
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


//Ajax Find View by Detail Table ID (Many to One relationship)

 public function ajax_find_view_by_detail_id()
    {
        $data = array();
        $master_table=$this->input->post('master_table');
        $detail_table=$this->input->post('detail_table');
        $attr_master=$this->input->post('attr_master');
        $attr_detail=$this->input->post('attr_detail');
        $attr_detail_val=$this->input->post('attr_detail_val');
        $view = $this->input->post('view');

        if($view and $attr_detail_val and $attr_detail  and $attr_master and $detail_table and $master_table)
        {
            $result_detail = $this->utilities->findByAttribute($detail_table, array($attr_detail => $attr_detail_val));

            if($result_detail)
            {
                $attr_master_val = $result_detail-> $attr_master;

                $result_detail = $this->utilities->findByAttribute($master_table, array($attr_master => $attr_master_val));

                if ($result_detail)
                {
                    $data = array(
                        'result'=>$result_detail
                    );
                    $dependency = $this->load->view($view,$data,true);
                    echo $dependency;
                }
                else
                {
                   echo 'not_found' ;
                }
            }
            else
            {
                echo "err";
            }
        }
        else
        {
            echo "no";
        }
        exit();
    }


//Ajax Find View by Master Table ID (One to Many and Many to One)

    public function ajax_find_view_by_map()
    {
       $data = array();
       $master_table1=$this->input->post('master_table1');
       $attr_master1_val=$this->input->post('attr_master1_val');

       $master_table2=$this->input->post('master_table2');
       $attr_master2=$this->input->post('attr_master2');

       $detail_table=$this->input->post('detail_table');
       $attr_detail=$this->input->post('attr_detail'); //initial attr of master1 although detail_table contains master2 attr
       $view = $this->input->post('view');

        //One to many
        $result_multiple = $this->utilities->findAllById($detail_table, $attr_detail, $attr_master1_val);

        //Many to One
        if($result_multiple)
        {
            $arr_duplicate_values =array();
            foreach ($result_multiple as $key=>$obj)
            {
                foreach ($obj as $key2=>$value)
                {
                    if($key2 ==$attr_master2)
                    {
                        $arr_duplicate_values[] = $value;

                    }
                }

            }

            //Query for M to O
            $arr_unique_values = array_unique($arr_duplicate_values);

            foreach ($arr_unique_values as $value)
            {
                $result[] = $this->utilities->findByAttribute($master_table2, array('ACTIVE_STATUS' => '1', $attr_master2=>$value));
            }

            if ($result)
            {
                $data = array(
                    'result'=>$result
                );
                $dependency = $this->load->view($view,$data,true);
                echo $dependency;
            }
            else
            {
                echo 'not_found' ;
            }
        }
        else
        {
            echo "err";
        }

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
			$this->db->trans_begin();
            $assi_data['SUBMISSION_DT'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('SUBMISSION_DT'))));
            $assi_data['SESSION_ID'] = $this->input->post('YSESSION_ID');
            $assi_data['CRE_BY'] = $this->user['EMP_ID'];
            $assi_data['CRE_DT'] = date("Y-m-d G:i:s");

            unset($_POST['YSESSION_ID']);
            $assi_data = array_merge($_POST, $assi_data);

            $this->utilities->insert('UMS_ASSIGNMENTS', $assi_data);


            if ($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                    //$this->session->set_flashdata('Error', 'Error! Data not inserted successfully.');
                    echo 'no';
            }
            else
            {
                $this->db->trans_commit();
                //$this->session->set_flashdata('Success', 'Success! Data inserted successfully.');
                echo 'yes';
            }
            exit();
            //redirect('lab_schedule/generate_schedule');
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








}
//End Class

