<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @category   FrontPortal
 * @package    Portal
 * @author     Emdadul <Emdadul@atilimited.net>
 * @copyright  2015 ATI Limited Development Group
 */
class Lab_setup extends MY_Controller
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

    }

    public function index()
    {
        $data['contentTitle'] = 'Laboratory Setup';
        $data['breadcrumbs'] = array(
            'Admin' => 'admin',
            'Lab Experiment' => '#'
        );
        $data['dimention'] = "horizental";
        $data['content_view_page'] = 'admin/lab_setup/lab_setup';
        $data['UM_LABRATORIES'] = $this->utilities->findAllByAttribute('UM_LABRATORIES', array("ACTIVE_STATUS" => "Y"));

        $this->form_validation->set_rules('LAB_NAME', 'Laboratory Name', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->admin_template->display($data);
        }
        else
        {
            $this->db->trans_begin();

            $exp_data['LAB_NAME'] = $this->input->post('LAB_NAME');
            $exp_data['LAB_DESC'] = $this->input->post('LAB_DESC');
            $exp_data['ACTIVE_STATUS'] = $this->input->post('ACTIVE_STATUS');
            $exp_data['CRE_BY'] = $this->user['EMP_ID'];
            $exp_data['ORG_ID'] = $this->user['ORG_ID'];
            $exp_data['ORDER_NO'] = '1';

            $this->utilities->insert('UM_LABRATORIES', $exp_data);

            if ($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('Error', 'Error! Data not inserted successfully.');
            }
            else
            {
                $this->db->trans_commit();
                $this->session->set_flashdata('Success', 'Success! Data inserted successfully.');
                redirect('lab_setup');
            }
        }
    }

    public function lab_setup_edit($id='')
    {
        $data['contentTitle'] = 'Lab Experiment';
        $data['breadcrumbs'] = array(
            'Admin' => 'admin',
            'Lab Experiment' => '#'
        );
        $data['dimention'] = "horizental";
        $data['content_view_page'] = 'admin/lab_setup/lab_setup_edit';

        $data['UM_LABRATORIES'] = $this->utilities->findAllByAttribute('UM_LABRATORIES', array("ACTIVE_STATUS" => "Y", "LAB_ID" => $id));


        $this->form_validation->set_rules('LAB_NAME', 'Laboratory Name', 'required');

        if ($this->form_validation->run() == FALSE)
        {
            $this->admin_template->display($data);
        }
        else
        {
            //die(var_dump($_POST));
            $this->db->trans_begin();

            $exp_data['LAB_NAME'] = $this->input->post('LAB_NAME');
            $exp_data['LAB_DESC'] = $this->input->post('LAB_DESC');
            $exp_data['ACTIVE_STATUS'] = $this->input->post('ACTIVE_STATUS');
            $exp_data['CRE_BY'] = $this->user['EMP_ID'];
            $exp_data['ORG_ID'] = $this->user['ORG_ID'];
            $exp_data['ORDER_NO'] = '1';

            $this->utilities->update2('UM_LABRATORIES',array('LAB_ID'=>$id), $exp_data);

            if ($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('Error', 'Error! Data not updated successfully.');
            }
            else
            {
                $this->db->trans_commit();
                $this->session->set_flashdata('Success', 'Success! Data updated successfully.');
                redirect('lab_setup/');
            }
        }
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

    public function lab_experiment()
    {
        $data['contentTitle'] = 'Lab Experiment';
        $data['breadcrumbs'] = array(
            'Admin' => 'admin',
            'Lab Experiment' => '#'
        );
        $data['dimention'] = "horizental";
        $data['content_view_page'] = 'admin/lab_setup/lab_experiment';

        $data['UM_LABRATORIES'] = $this->utilities->findAllByAttribute('UM_LABRATORIES', array("ACTIVE_STATUS" => 'Y'));
        $data['HR_EMPLOYEE'] = $this->utilities->findAllByAttribute('HR_EMPLOYEE', array("ACTIVE_STATUS" => "Y"));
        $data['UM_LAB_EXPERIMENT'] = $this->utilities->findAllByAttribute('UM_LAB_EXPERIMENT', array("ACTIVE_STATUS" => "Y"));

        $this->form_validation->set_rules('EXP_NAME', 'Experiment Name', 'required');
        $this->form_validation->set_rules('LAB_ID[]', 'Laboratories', 'required');
        $this->form_validation->set_rules('EMP_NO[]', 'Supervisor', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->admin_template->display($data);
        }
        else
        {
            //die(var_dump($_POST));
            $this->db->trans_begin();

            $exp_data['EXP_NAME'] = $this->input->post('EXP_NAME');
            $exp_data['DESCRIPTION'] = $this->input->post('DESCRIPTION');
            $exp_data['ACTIVE_STATUS'] = $this->input->post('ACTIVE_STATUS');
            $exp_data['CRE_BY'] = $this->user['EMP_ID'];
            $exp_data['ORG_ID'] = $this->user['ORG_ID'];
            $LAB_ID = $this->input->post('LAB_ID');
            $EMP_NO = $this->input->post('EMP_NO');

            $EXP_ID = $this->utilities->insert('UM_LAB_EXPERIMENT', $exp_data);

            foreach ($LAB_ID as $value)
            {
                $um_lab_exp_assign_info = array(
                    'EXP_ID' => $EXP_ID,
                    'LAB_ID' => $value,
                    'ACTIVE_STATUS' => $this->input->post('ACTIVE_STATUS'),
                    'CRE_BY' => $this->user['EMP_ID'],
                    'ORG_ID' => $this->user['ORG_ID']
                );

                $this->utilities->insert('UM_LAB_EXP_ASSIGN', $um_lab_exp_assign_info);
            }

            foreach ($EMP_NO as $value2)
            {
                $um_lab_sup_assign_info = array(
                    'EXP_ID' => $EXP_ID,
                    'EMP_NO' => $value2,
                    'ACTIVE_STATUS' => $this->input->post('ACTIVE_STATUS'),
                    'CRE_BY' => $this->user['EMP_ID'],
                    'ORG_ID' => $this->user['ORG_ID']
                );

                $this->utilities->insert('UM_LAB_SUPERVISOR_ASSIGN', $um_lab_sup_assign_info);
            }

            if ($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('Error', 'Error! Data not inserted successfully.');
            }
            else
            {
                $this->db->trans_commit();
                $this->session->set_flashdata('Success', 'Success! Data inserted successfully.');
                redirect('lab_setup/lab_experiment');
            }
        }
    }

    public function lab_experiment_edit($id='')
    {
        $data['contentTitle'] = 'Lab Experiment';
        $data['breadcrumbs'] = array(
            'Admin' => 'admin',
            'Lab Experiment' => '#'
        );
        $data['dimention'] = "horizental";
        $data['content_view_page'] = 'admin/lab_setup/lab_experiment_edit';

        $data['UM_LAB_EXPERIMENT'] = $this->utilities->findAllByAttribute('UM_LAB_EXPERIMENT', array("ACTIVE_STATUS" => "Y", "EXP_ID" => $id));

        $where = " where t2.EXP_ID = '$id'";
        $data['UM_LABRATORIES_S'] = $this->utilities->findByLeftJoinT2("UM_LABRATORIES", "UM_LAB_EXP_ASSIGN", "lab_id", "lab_id", $where);

        $where2 = " where t2.EXP_ID = '$id'";
        $data['HR_EMPLOYEE_S'] = $this->utilities->findByLeftJoinT2("HR_EMPLOYEE", "UM_LAB_SUPERVISOR_ASSIGN", "EMP_NO", "EMP_NO", $where2);

        $data['UM_LABRATORIES'] = $this->utilities->findAllByAttribute('UM_LABRATORIES', array("ACTIVE_STATUS" => 'Y'));
        $data['HR_EMPLOYEE'] = $this->utilities->findAllByAttribute('HR_EMPLOYEE', array("ACTIVE_STATUS" => "Y"));


        $this->form_validation->set_rules('EXP_NAME', 'Experiment Name', 'required');
        $this->form_validation->set_rules('LAB_ID[]', 'Laboratories', 'required');
        $this->form_validation->set_rules('EMP_NO[]', 'Supervisor', 'required');

        if ($this->form_validation->run() == FALSE)
        {
            $this->admin_template->display($data);
        }
        else
        {
            //die(var_dump($_POST));
            $this->db->trans_begin();

            $exp_data['EXP_NAME'] = $this->input->post('EXP_NAME');
            $exp_data['DESCRIPTION'] = $this->input->post('DESCRIPTION');
            $exp_data['ACTIVE_STATUS'] = $this->input->post('ACTIVE_STATUS');
            $exp_data['CRE_BY'] = $this->user['EMP_ID'];
            $exp_data['ORG_ID'] = $this->user['ORG_ID'];
            $LAB_ID = $this->input->post('LAB_ID');
            $EMP_NO = $this->input->post('EMP_NO');

            $this->utilities->update2('UM_LAB_EXPERIMENT',array('EXP_ID'=>$id), $exp_data);

            $this->utilities->delete('UM_LAB_EXP_ASSIGN', array('EXP_ID'=>$id));
            foreach ($LAB_ID as $value)
            {
                $um_lab_exp_assign_info = array(
                    'EXP_ID' => $id,
                    'LAB_ID' => $value,
                    'ACTIVE_STATUS' => $this->input->post('ACTIVE_STATUS'),
                    'CRE_BY' => $this->user['EMP_ID'],
                    'ORG_ID' => $this->user['ORG_ID']
                );

                $this->utilities->insert('UM_LAB_EXP_ASSIGN', $um_lab_exp_assign_info);
            }

            $this->utilities->delete('UM_LAB_SUPERVISOR_ASSIGN', array('EXP_ID'=>$id));
            foreach ($EMP_NO as $value2)
            {
                $um_lab_sup_assign_info = array(
                    'EXP_ID' => $id,
                    'EMP_NO' => $value2,
                    'ACTIVE_STATUS' => $this->input->post('ACTIVE_STATUS'),
                    'CRE_BY' => $this->user['EMP_ID'],
                    'ORG_ID' => $this->user['ORG_ID']
                );

                $this->utilities->insert('UM_LAB_SUPERVISOR_ASSIGN', $um_lab_sup_assign_info);
            }

            if ($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('Error', 'Error! Data not updated successfully.');
            }
            else
            {
                $this->db->trans_commit();
                $this->session->set_flashdata('Success', 'Success! Data updated successfully.');
            }
            redirect('lab_setup/lab_experiment');
        }
    }

    public function lab_experiment_delete($id='')
    {
        $res = $this->utilities->delete('UM_LAB_EXPERIMENT', array('EXP_ID'=>$id));

        if ($res)
        {
            $this->utilities->delete('UM_LAB_SUPERVISOR_ASSIGN', array('EXP_ID'=>$id));
            $this->utilities->delete('UM_LAB_EXP_ASSIGN', array('EXP_ID'=>$id));
            $this->session->set_flashdata('Success', 'Success! Data deleted successfully.');
        }
        else
        {
            $this->session->set_flashdata('Error', 'Error! Data not deleted successfully.');
        }
        redirect('lab_setup/lab_experiment');
    }


}

/* End of file setup.php */
/* Location: ./application/controllers/setup.php */
