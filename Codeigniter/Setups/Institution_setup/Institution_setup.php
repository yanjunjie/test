<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @category   FrontPortal
 * @package    Portal
 * @author     Emdadul <Emdadul@atilimited.net>
 * @copyright  2015 ATI Limited Development Group
 */
class Institution_setup extends MY_Controller
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

    
    //Institution Setup Creation
    public function institution_setup()
    {
        $data['contentTitle'] = 'Institution Setup';
        $data['breadcrumbs'] = array(
            'Admin' => 'admin',
            'Institution Setup' => '#'
        );
        $data['dimention'] = "horizental";
        $data['content_view_page'] = 'admin/setup/institution_setup/institution_setup';
        $data['UM_INSTITUTIONS'] = $this->utilities->findAllByAttribute('UM_INSTITUTIONS', array("ACTIVE_STATUS" => "Y"));

        $this->form_validation->set_rules('INSTITUTE_NAME', 'Institute Name', 'required');
        $this->form_validation->set_rules('INS_TYPE', 'Institute Type', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->admin_template->display($data);
        }
        else
        {
            $this->db->trans_begin();
            $ins_data = $_POST;
            $ins_data['CRE_BY'] = $this->user['EMP_ID'];
            $ins_data['CRE_DT'] = date("Y-m-d G:i:s");

            $this->utilities->insert('UM_INSTITUTIONS', $ins_data);

            if ($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('Error', 'Error! Data not inserted successfully.');
            }
            else
            {
                $this->db->trans_commit();
                $this->session->set_flashdata('Success', 'Success! Data inserted successfully.');
                redirect('setup/institution_setup');
            }
        }
    }
    //Institution Setup Update
    public function institution_setup_edit($id='')
    {
        $data['contentTitle'] = 'Institution Setup';
        $data['breadcrumbs'] = array(
            'Admin' => 'admin',
            'Institution Setup' => '#'
        );
        $data['dimention'] = "horizental";
        $data['content_view_page'] = 'admin/setup/institution_setup/institution_setup_edit';

        $data['UM_INSTITUTIONS'] = $this->utilities->findByAttribute('UM_INSTITUTIONS', array("ACTIVE_STATUS" => "Y", "INSTITUTE_ID" => $id));


        $this->form_validation->set_rules('INSTITUTE_NAME', 'Institute Name', 'required');

        if ($this->form_validation->run() == FALSE)
        {
            $this->admin_template->display($data);
        }
        else
        {
            $this->db->trans_begin();

            $ins_data = $_POST;
            $ins_data['CRE_BY'] = $this->user['EMP_ID'];
            $ins_data['CRE_DT'] = date("Y-m-d G:i:s");

            $this->utilities->update2('UM_INSTITUTIONS',array('INSTITUTE_ID'=>$id), $ins_data);

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
            redirect('setup/institution_setup');
        }
    }
    //Delete
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

}

/* End of file setup.php */
/* Location: ./application/controllers/setup.php */
