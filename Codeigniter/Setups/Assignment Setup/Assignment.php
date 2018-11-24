<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @category   Applicalnt
 * @package    Applicalnt Activity
 * @author     Frihim <frihim@atilimited.net>
 * @copyright  2015 ATI Limited Development Group
 */
class Assignment extends MY_Controller
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

    //Create Assignment
    public function createAssignment()
    {
        $data['contentTitle'] = 'Assignment';
        $data['breadcrumbs'] = array(
            'Create Assignment' => '#',
            'Assignment' => '#',
        );
        $data['content_view_page'] = 'admin/assignment/createAssignment';
        $data['dimention'] = "horizental";

        $data['UMS_ASSIGNMENTS'] = $this->utilities->findAllByAttribute('UMS_ASSIGNMENTS', array("ACTIVE_STATUS" => 'Y'));

        $data['ACA_COURSE'] = $this->utilities->findAllByAttribute('ACA_COURSE', array("ACTIVE_STATUS" => '1'));
        $data['UM_LAB_EXPERIMENT'] = $this->utilities->findAllByAttribute('UM_LAB_EXPERIMENT', array("ACTIVE_STATUS" => 'Y'));
        $data['INS_FACULTY'] = $this->utilities->findAllByAttribute('INS_FACULTY', array("ACTIVE_STATUS" => '1'));
        $data['ADM_YSESSION'] = $this->utilities->findByLeftJoinT2("ADM_YSESSION", "INS_SESSION", "SESSION_ID", "SESSION_ID", '');
        $data['INS_DEGREE'] = $this->utilities->findAllByAttribute('INS_DEGREE', array("ACTIVE_STATUS" => '1'));
        $data['INS_DEPT'] = $this->utilities->findAllByAttribute('INS_DEPT', array("ACTIVE_STATUS" => '1'));
        $data['INS_PROGRAM'] = $this->utilities->findAllByAttribute('INS_PROGRAM', array("ACTIVE_STATUS" => '1'));
        $data['ACA_BATCH'] = $this->utilities->findAllByAttribute('ACA_BATCH', array("ACTIVE_STATUS" => '1'));
        $data['ACA_SECTION'] = $this->utilities->findAllByAttribute('ACA_SECTION', array("ACTIVE_STATUS" => '1'));
        $data['SA_ROOM'] = $this->utilities->findAllByAttribute('SA_ROOM', array("ACTIVE_STATUS" => '1'));

        $this->form_validation->set_rules('ASSIGNMENT_TITLE', 'Assignment Title', 'required');
        $this->form_validation->set_rules('DESCRIPTION', 'Description', 'required');
        $this->form_validation->set_rules('YSESSION_ID', 'Session', 'required');
        $this->form_validation->set_rules('DEPT_ID', 'Dept', 'required');
        $this->form_validation->set_rules('SECTION_ID', 'Section', 'required');
        $this->form_validation->set_rules('PROGRAM_ID', 'Program', 'required');
        $this->form_validation->set_rules('BATCH_ID', 'Batch', 'required');
        $this->form_validation->set_rules('COURSE_ID', 'Course', 'required');
        $this->form_validation->set_rules('SUBMISSION_DT', 'Submission date', 'required');
        //$this->form_validation->set_rules('STUDENT_ID[]', 'Sdudent Name', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->admin_template->display($data);
        }
        else
        {
            $this->db->trans_begin();

            $assi_data['ASSIGNMENT_TITLE'] = $this->input->post('ASSIGNMENT_TITLE');
            $assi_data['DESCRIPTION'] = $this->input->post('DESCRIPTION');
            $assi_data['DEPT_ID'] = $this->input->post('DEPT_ID');
            $assi_data['SECTION_ID'] = $this->input->post('SECTION_ID');
            $assi_data['PROGRAM_ID'] = $this->input->post('PROGRAM_ID');
            $assi_data['BATCH_ID'] = $this->input->post('BATCH_ID');
            $assi_data['SESSION_ID'] = $this->input->post('YSESSION_ID');
            $assi_data['SECTION_ID'] = $this->input->post('SECTION_ID');
            $assi_data['COURSE_ID'] = $this->input->post('COURSE_ID');
            $assi_data['ACTIVE_STATUS'] = $this->input->post('ACTIVE_STATUS');
            $assi_data['SUBMISSION_DT'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('SUBMISSION_DT'))));
            //$assi_data = $_POST;
            $assi_data['CRE_BY'] = $this->user['EMP_ID'];
            $assi_data['CRE_DT'] = date("Y-m-d G:i:s");

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
        }
    }

    //Update Assignment
    public function createAssignmentUpdate($id=0)
    {
        if(!$id) redirect('assignment/createAssignment');

        $data['contentTitle'] = 'Assignment';
        $data['breadcrumbs'] = array(
            'Create Assignment' => '#',
            'Assignment' => '#',
        );
        $data['content_view_page'] = 'admin/assignment/createAssignmentEdit';
        $data['dimention'] = "horizental";

        $data['UMS_ASSIGNMENTS_BY_ID'] = $this->utilities->findByAttribute('UMS_ASSIGNMENTS', array("ACTIVE_STATUS" => "Y", "ASSIGNMENT_ID" => $id));
        $data['UMS_ASSIGNMENTS'] = $this->utilities->findAllByAttribute('UMS_ASSIGNMENTS', array("ACTIVE_STATUS" => 'Y'));

        $data['ACA_COURSE'] = $this->utilities->findAllByAttribute('ACA_COURSE', array("ACTIVE_STATUS" => '1'));
        $data['UM_LAB_EXPERIMENT'] = $this->utilities->findAllByAttribute('UM_LAB_EXPERIMENT', array("ACTIVE_STATUS" => 'Y'));
        $data['INS_FACULTY'] = $this->utilities->findAllByAttribute('INS_FACULTY', array("ACTIVE_STATUS" => '1'));
        $data['ADM_YSESSION'] = $this->utilities->findByLeftJoinT2("ADM_YSESSION", "INS_SESSION", "SESSION_ID", "SESSION_ID", '');
        $data['INS_DEGREE'] = $this->utilities->findAllByAttribute('INS_DEGREE', array("ACTIVE_STATUS" => '1'));
        $data['INS_DEPT'] = $this->utilities->findAllByAttribute('INS_DEPT', array("ACTIVE_STATUS" => '1'));
        $data['INS_PROGRAM'] = $this->utilities->findAllByAttribute('INS_PROGRAM', array("ACTIVE_STATUS" => '1'));
        $data['ACA_BATCH'] = $this->utilities->findAllByAttribute('ACA_BATCH', array("ACTIVE_STATUS" => '1'));
        $data['ACA_SECTION'] = $this->utilities->findAllByAttribute('ACA_SECTION', array("ACTIVE_STATUS" => '1'));
        $data['SA_ROOM'] = $this->utilities->findAllByAttribute('SA_ROOM', array("ACTIVE_STATUS" => '1'));

        $this->form_validation->set_rules('ASSIGNMENT_TITLE', 'Assignment Title', 'required');
        $this->form_validation->set_rules('DESCRIPTION', 'Description', 'required');
        $this->form_validation->set_rules('YSESSION_ID', 'Session', 'required');
        $this->form_validation->set_rules('DEPT_ID', 'Dept', 'required');
        $this->form_validation->set_rules('SECTION_ID', 'Section', 'required');
        $this->form_validation->set_rules('PROGRAM_ID', 'Program', 'required');
        $this->form_validation->set_rules('BATCH_ID', 'Batch', 'required');
        $this->form_validation->set_rules('COURSE_ID', 'Course', 'required');
        $this->form_validation->set_rules('SUBMISSION_DT', 'Submission date', 'required');
        //$this->form_validation->set_rules('STUDENT_ID[]', 'Sdudent Name', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->admin_template->display($data);
        }
        else
        {
            $this->db->trans_begin();
            $assi_data['ASSIGNMENT_TITLE'] = $this->input->post('ASSIGNMENT_TITLE');
            $assi_data['DESCRIPTION'] = $this->input->post('DESCRIPTION');
            $assi_data['DEPT_ID'] = $this->input->post('DEPT_ID');
            $assi_data['SECTION_ID'] = $this->input->post('SECTION_ID');
            $assi_data['PROGRAM_ID'] = $this->input->post('PROGRAM_ID');
            $assi_data['BATCH_ID'] = $this->input->post('BATCH_ID');
            $assi_data['SESSION_ID'] = $this->input->post('YSESSION_ID');
            $assi_data['SECTION_ID'] = $this->input->post('SECTION_ID');
            $assi_data['COURSE_ID'] = $this->input->post('COURSE_ID');
            $assi_data['ACTIVE_STATUS'] = $this->input->post('ACTIVE_STATUS');
            $assi_data['SUBMISSION_DT'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('SUBMISSION_DT'))));
            //$assi_data = $_POST;
            $assi_data['UPD_BY'] = $this->user['EMP_ID'];
            $assi_data['UPD_DT'] = date("Y-m-d G:i:s");
            $this->utilities->updateData('UMS_ASSIGNMENTS', $assi_data, array('ASSIGNMENT_ID'=>$id));

            if ($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('Error', 'Error! Data not updated successfully.');
                //echo 'no';
            }
            else
            {
                $this->db->trans_commit();
                $this->session->set_flashdata('Success', 'Success! Data updated successfully.');
                //echo 'yes';
            }

            redirect('assignment/createAssignment');
        }
    }

    //Ajax Delete by ID
    public function ajax_delete()
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


}
