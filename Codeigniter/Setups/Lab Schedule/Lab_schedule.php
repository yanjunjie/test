<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @category   FrontPortal
 * @package    Portal
 * @author     Emdadul <Emdadul@atilimited.net>
 * @copyright  2015 ATI Limited Development Group
 */
class Lab_schedule extends MY_Controller
{

    private $user;
    public $user_id = null;

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('logged_in') == FALSE) {
            redirect('auth/login', 'refresh');
        }
        $user_session = $this->user = $this->session->userdata("logged_in");
        $this->user_id = $user_session['USER_TYPE'];
        $this->load->model('utilities');

        date_default_timezone_set("Asia/Dhaka");
    }

    public function ajax_delete()
    {
        $table=$this->input->post('table');
        $attr=$this->input->post('attr');
        $id=$this->input->post('id');

        $res = $this->db->delete($table,array($attr=>$id));
        if($res){
            echo 'yes';
        }
        exit();
    }

    //Ajax Find Dependency View by ID //One to Many relationship
    public function ajax_find_view()
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

    //Ajax Find Dependency View by Detail ID //Many to One relationship
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

    //Ajax Find Dependency View by Detail ID //One to Many and Many to One relationship
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

    //Ajax Student Dependency View
    public function ajax_student_depent_view()
    {
        $EXP_ID=$this->input->post('EXP_ID');
        $YSESSION_ID=$this->input->post('YSESSION_ID');
        $DEGREE_ID=$this->input->post('DEGREE_ID');
        $FACULTY_ID=$this->input->post('FACULTY_ID');
        $DEPT_ID=$this->input->post('DEPT_ID');
        $PROGRAM_ID=$this->input->post('PROGRAM_ID');
        $BATCH_ID=$this->input->post('BATCH_ID');
        $SECTION_ID=$this->input->post('SECTION_ID');
        $SDL_DT=date("Y-m-d H:i:s", strtotime(str_replace('/', '-', $this->input->post('SDL_DT'))));

        //Searched Result Set
        if($YSESSION_ID && $DEGREE_ID && $FACULTY_ID && $DEPT_ID && $PROGRAM_ID && $BATCH_ID && $SECTION_ID)
        {
            $result = $this->utilities->findStudentData($EXP_ID, $SDL_DT, $YSESSION_ID, $DEGREE_ID, $FACULTY_ID, $DEPT_ID, $PROGRAM_ID, $BATCH_ID, $SECTION_ID);

            if(!empty($result))
            {
                $data['result'] = $result;
                $dependency = $this->load->view("admin/lab_schedule/student_dependency",$data,true);
                echo $dependency;
            }
            else
            {
                echo 'not_found';
            }
        }
        else
        {
            echo "no";
        }
        exit();
    }

    public function generate_schedule()
    {
        $data['contentTitle'] = 'Generate Schedule';
        $data['breadcrumbs'] = array(
            'Admin' => 'admin',
            'Generate Schedule' => '#'
        );
        $data['dimention'] = "horizental";
        $data['content_view_page'] = 'admin/lab_schedule/generate_schedule';

        $data['UM_LAB_EXPERIMENT'] = $this->utilities->findAllByAttribute('UM_LAB_EXPERIMENT', array("ACTIVE_STATUS" => 'Y'));
        $data['INS_FACULTY'] = $this->utilities->findAllByAttribute('INS_FACULTY', array("ACTIVE_STATUS" => '1'));
        $data['ADM_YSESSION'] = $this->utilities->findByLeftJoinT2("ADM_YSESSION", "INS_SESSION", "SESSION_ID", "SESSION_ID", '');
        $data['INS_DEGREE'] = $this->utilities->findAllByAttribute('INS_DEGREE', array("ACTIVE_STATUS" => '1'));
        $data['INS_DEPT'] = $this->utilities->findAllByAttribute('INS_DEPT', array("ACTIVE_STATUS" => '1'));
        $data['INS_PROGRAM'] = $this->utilities->findAllByAttribute('INS_PROGRAM', array("ACTIVE_STATUS" => '1'));
        $data['ACA_BATCH'] = $this->utilities->findAllByAttribute('ACA_BATCH', array("ACTIVE_STATUS" => '1'));
        $data['ACA_SECTION'] = $this->utilities->findAllByAttribute('ACA_SECTION', array("ACTIVE_STATUS" => '1'));
        $data['SA_ROOM'] = $this->utilities->findAllByAttribute('SA_ROOM', array("ACTIVE_STATUS" => '1'));

        $this->form_validation->set_rules('EXP_ID', 'Experiment name', 'required');
        $this->form_validation->set_rules('FACULTY_ID', 'Faculty name', 'required');
        $this->form_validation->set_rules('YSESSION_ID', 'Session', 'required');
        $this->form_validation->set_rules('DEGREE_ID', 'Degree', 'required');
        $this->form_validation->set_rules('DEPT_ID', 'Dept', 'required');
        $this->form_validation->set_rules('SECTION_ID', 'Section', 'required');
        $this->form_validation->set_rules('PROGRAM_ID', 'Program', 'required');
        $this->form_validation->set_rules('BATCH_ID', 'Batch', 'required');
        $this->form_validation->set_rules('ROOM_NO', 'Room', 'required');
        $this->form_validation->set_rules('CLASS_START_TIME', 'Class start time', 'required');
        $this->form_validation->set_rules('CLASS_END_TIME', 'Class end time', 'required');
        $this->form_validation->set_rules('SDL_DT', 'Schedule date', 'required');
        if(!array_key_exists('STUDENT_ID_EXIST',$_POST))
        {
            $this->form_validation->set_rules('STUDENT_ID[]', 'Sdudent Name', 'required');
        }


        if ($this->form_validation->run() == FALSE)
        {
            $this->admin_template->display($data);
        }
        else
        {
            $this->db->trans_begin();

            $sch_data['EXP_ID'] = $this->input->post('EXP_ID');
            $sch_data['FACULTY_ID'] = $this->input->post('FACULTY_ID');
            $sch_data['SESSION_ID'] = $this->input->post('SESSION_ID');
            $sch_data['DEGREE_ID'] = $this->input->post('DEGREE_ID');
            $sch_data['DEPT_ID'] = $this->input->post('DEPT_ID');
            $sch_data['SECTION_ID'] = $this->input->post('SECTION_ID');
            $sch_data['PROGRAM_ID'] = $this->input->post('PROGRAM_ID');
            $sch_data['BATCH_ID'] = $this->input->post('BATCH_ID');
            $sch_data['SESSION_ID'] = $this->input->post('YSESSION_ID');
            $sch_data['ROOM_NO'] = $this->input->post('ROOM_NO');
            $sch_data['CLASS_START_TIME'] = date("Y-m-d G:i:s", strtotime($this->input->post('CLASS_START_TIME')));
            $sch_data['CLASS_END_TIME'] = date("Y-m-d G:i:s", strtotime($this->input->post('CLASS_END_TIME')));
            $sch_data['SDL_DT'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('SDL_DT'))));
            $sch_data['ACTIVE_STATUS'] = $this->input->post('ACTIVE_STATUS');
            $sch_data['CRE_BY'] = $this->user['EMP_ID'];
            $sch_data['CRE_DT'] = date("Y-m-d G:i:s");

            $STUDENT_IDs = $this->input->post('STUDENT_ID');
            $STUDENT_ID_EXIST = $this->input->post('STUDENT_ID_EXIST');

            if(!empty($STUDENT_ID_EXIST) and !empty($sch_data['SDL_DT']) and !empty($sch_data['EXP_ID']) )
            {
                //Update
                foreach ($STUDENT_ID_EXIST as $STUDENT_ID)
                {
                    $res = $this->utilities->delete('UMS_LAB_SCHEDULE', array('STUDENT_ID' => $STUDENT_ID,'SDL_DT'=>$sch_data['SDL_DT'],'EXP_ID'=>$sch_data['EXP_ID']));
                    if($res)
                    {
                        $sch_data['STUDENT_ID'] = $STUDENT_ID;
                        $this->utilities->insertData($sch_data, 'UMS_LAB_SCHEDULE');
                    }
                }

            }

            //Insert new
            if(!empty($STUDENT_IDs))
            {
                foreach ($STUDENT_IDs as $STUDENT_ID)
                {
                    $sch_data['STUDENT_ID'] = $STUDENT_ID;
                    $this->utilities->insertData($sch_data, 'UMS_LAB_SCHEDULE');
                }
            }

            if ($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                //$this->session->set_flashdata('Error', 'Error! Data not inserted successfully.');
                echo 'err';
            }
            else
            {
                $this->db->trans_commit();
                //$this->session->set_flashdata('Success', 'Success! Data inserted successfully.');
                echo 'yes';
            }
            exit();
            //redirect('lab_schedule/generate_schedule');
        }
    }

   public function lab_attendees()

   {
       $data['contentTitle'] = 'Lab Attendees';
       $data['breadcrumbs'] = array(
           'Admin' => 'admin',
           'Lab Attendees' => '#'
       );
       $data['dimention'] = "horizental";
       $data['content_view_page'] = 'admin/lab_schedule/lab_attendees';

       $data['UM_LAB_EXPERIMENT'] = $this->utilities->findAllByAttribute('UM_LAB_EXPERIMENT', array("ACTIVE_STATUS" => 'Y'));
       $data['INS_FACULTY'] = $this->utilities->findAllByAttribute('INS_FACULTY', array("ACTIVE_STATUS" => '1'));
       $data['ADM_YSESSION'] = $this->utilities->findByLeftJoinT2("ADM_YSESSION", "INS_SESSION", "SESSION_ID", "SESSION_ID", '');
       $data['INS_DEGREE'] = $this->utilities->findAllByAttribute('INS_DEGREE', array("ACTIVE_STATUS" => '1'));
       $data['INS_DEPT'] = $this->utilities->findAllByAttribute('INS_DEPT', array("ACTIVE_STATUS" => '1'));
       $data['INS_PROGRAM'] = $this->utilities->findAllByAttribute('INS_PROGRAM', array("ACTIVE_STATUS" => '1'));
       $data['ACA_BATCH'] = $this->utilities->findAllByAttribute('ACA_BATCH', array("ACTIVE_STATUS" => '1'));
       $data['ACA_SECTION'] = $this->utilities->findAllByAttribute('ACA_SECTION', array("ACTIVE_STATUS" => '1'));
       $data['SA_ROOM'] = $this->utilities->findAllByAttribute('SA_ROOM', array("ACTIVE_STATUS" => '1'));

       $this->form_validation->set_rules('EXP_ID', 'Experiment name', 'required');
       $this->form_validation->set_rules('FACULTY_ID', 'Faculty name', 'required');
       $this->form_validation->set_rules('YSESSION_ID', 'Session', 'required');
       $this->form_validation->set_rules('DEGREE_ID', 'Degree', 'required');
       $this->form_validation->set_rules('DEPT_ID', 'Dept', 'required');
       $this->form_validation->set_rules('SECTION_ID', 'Section', 'required');
       $this->form_validation->set_rules('PROGRAM_ID', 'Program', 'required');
       $this->form_validation->set_rules('BATCH_ID', 'Batch', 'required');
       $this->form_validation->set_rules('ROOM_NO', 'Room', 'required');
       $this->form_validation->set_rules('SDL_DT', 'Schedule date', 'required');
       //$this->form_validation->set_rules('STUDENT_ID[]', 'Sdudent Name', 'required');

       if ($this->form_validation->run() == FALSE)
       {
           $this->admin_template->display($data);
       }
       else
       {
           $this->db->trans_begin();

           $sch_data['EXP_ID'] = $this->input->post('EXP_ID');
           $sch_data['FACULTY_ID'] = $this->input->post('FACULTY_ID');
           $sch_data['SESSION_ID'] = $this->input->post('SESSION_ID');
           $sch_data['DEGREE_ID'] = $this->input->post('DEGREE_ID');
           $sch_data['DEPT_ID'] = $this->input->post('DEPT_ID');
           $sch_data['SECTION_ID'] = $this->input->post('SECTION_ID');
           $sch_data['PROGRAM_ID'] = $this->input->post('PROGRAM_ID');
           $sch_data['BATCH_ID'] = $this->input->post('BATCH_ID');
           $sch_data['SESSION_ID'] = $this->input->post('YSESSION_ID');
           $sch_data['ROOM_NO'] = $this->input->post('ROOM_NO');
           $sch_data['SDL_DT'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('SDL_DT'))));
           $sch_data['ACTIVE_STATUS'] = $this->input->post('ACTIVE_STATUS');
           $sch_data['CRE_BY'] = $this->user['EMP_ID'];
           $sch_data['CRE_DT'] = date("Y-m-d G:i:s");

           $STDNT_IN_TIME = $this->input->post('STDNT_IN_TIME');
           $STDNT_OUT_TIME = $this->input->post('STDNT_OUT_TIME');
           $STUDENT_IDs = $this->input->post('STUDENT_ID');

           if(!empty($STUDENT_IDs) and !empty($sch_data['SDL_DT']) and !empty($sch_data['EXP_ID']) )
           {
               //Update
               foreach ($STUDENT_IDs as $STUDENT_ID)
               {
                   $STDNT_IN_TIMEf = date("Y-m-d G:i:s", strtotime($STDNT_IN_TIME[$STUDENT_ID]));
                   $STDNT_OUT_TIMEf = date("Y-m-d G:i:s", strtotime($STDNT_OUT_TIME[$STUDENT_ID]));

                   if(!empty($STDNT_IN_TIME[$STUDENT_ID]) and !empty($STDNT_OUT_TIME[$STUDENT_ID]))
                   {

                       $where = ",STDNT_IN_TIME='$STDNT_IN_TIMEf',STDNT_OUT_TIME='$STDNT_OUT_TIMEf'";
                   }
                   else
                   {
                       $where='';
                   }

                   $this->utilities->inOutTimeAttenUpdate('UMS_LAB_SCHEDULE', $STUDENT_ID, $sch_data['SDL_DT'], $sch_data['EXP_ID'], $where);
               }

           }

           if ($this->db->trans_status() === FALSE)
           {
               $this->db->trans_rollback();
               foreach ($STUDENT_IDs as $STUDENT_ID)
               //$this->session->set_flashdata('Error', 'Error! Data not inserted successfully.');
               echo 'err';
           }
           else
           {
               $this->db->trans_commit();
               //$this->session->set_flashdata('Success', 'Success! Data inserted successfully.');

               if(empty($STUDENT_IDs))
               {
                   echo 'err';
               }
               else
               {
                   echo 'yes';
               }

           }
           exit();
           //redirect('lab_schedule/generate_schedule');
       }
   }
    //Ajax Lab Attendees View
    public function ajax_lab_atten_view()
    {
        $EXP_ID=$this->input->post('EXP_ID');
        $YSESSION_ID=$this->input->post('YSESSION_ID');
        $DEGREE_ID=$this->input->post('DEGREE_ID');
        $FACULTY_ID=$this->input->post('FACULTY_ID');
        $DEPT_ID=$this->input->post('DEPT_ID');
        $PROGRAM_ID=$this->input->post('PROGRAM_ID');
        $BATCH_ID=$this->input->post('BATCH_ID');
        $SECTION_ID=$this->input->post('SECTION_ID');
        $SDL_DT=date("Y-m-d H:i:s", strtotime(str_replace('/', '-', $this->input->post('SDL_DT'))));

        //Searched Result Set
        if($YSESSION_ID && $DEGREE_ID && $FACULTY_ID && $DEPT_ID && $PROGRAM_ID && $BATCH_ID && $SECTION_ID)
        {
            $result = $this->utilities->findAttenStdData($EXP_ID, $SDL_DT, $YSESSION_ID, $DEGREE_ID, $FACULTY_ID, $DEPT_ID, $PROGRAM_ID, $BATCH_ID, $SECTION_ID);

            if(!empty($result))
            {
                $data['result'] = $result;
                $dependency = $this->load->view("admin/lab_schedule/atten_stu_list",$data,true);
                echo $dependency;
            }
            else
            {
                echo 'not_found';
            }
        }
        else
        {
            echo "no";
        }
        exit();
    }

}

/* End of file setup.php */
/* Location: ./application/controllers/setup.php */