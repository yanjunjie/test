<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Publicity extends CI_Controller{
    public static $model = 'MyModel';
    //public static $model 	 = array('myModel');
    const  TITLE = 'Metro Home';

    public function __construct()
    {

        parent::__construct();
        $this->load->model(self::$model);
        $this->load->helper('form');
        
    }

    public function index($page=1)
    {

        //Select options like 10, 20, 30, 40
        if(!empty($_POST['sel'])){
            $limit = $this->input->post('sel');
        }else
            $limit = 10;
        //End Select options like 10, 20, 30, 40  

        //get total data
        $total = $this->MyModel->get_total();
        //per page, select records 1 - 10 (inclusive)
        //$limit  = 10;
        //get records according to limit
        $result = $this->MyModel->get_all($limit, $page); //$this->db->limit($pPagination['Length'], $pPagination['Start']);
        //menentukan url pagination
        $url = site_url('publicity/index');
        //load library pagination
        $this->load->library('pagination');
        //config library pagination dengan style twitter bootstrap css
        $config['base_url']         = $url;
        $config['total_rows']       = $total;
        $config['per_page']         = $limit;
        $config['use_page_numbers'] = true;
        $config['num_links']        = 5;
        $config['full_tag_open']    = '<ul class="pagination">';
        $config['full_tag_close']   = '</ul>';
        $config['first_link']       = 'First';
        $config['last_link']        = 'Last';
        $config['first_tag_open']   = '<li>';
        $config['first_tag_close']  = '</li>';
        $config['prev_link']        = '&laquo';
        $config['prev_tag_open']    = '<li class="prev">';
        $config['prev_tag_close']   = '</li>';
        $config['next_link']        = '&raquo';
        $config['next_tag_open']    = '<li>';
        $config['next_tag_close']   = '</li>';
        $config['last_tag_open']    = '<li>';
        $config['last_tag_close']   = '</li>';
        $config['cur_tag_open']     = '<li class="active"><a href="#">';
        $config['cur_tag_close']    = '</a></li>';
        $config['num_tag_open']     = '<li>';
        $config['num_tag_close']    = '</li>';
        $this->pagination->initialize($config);
        $pagination = $this->pagination->create_links();
        $data['result']     = $result;
        $data['total']     = $total;
        $data['pagination'] = $pagination;
        $data['publicity_search_msg']='';

        //Displaying X to Y of Z results
        $data['result_start'] = ($page - 1) * $config['per_page'] + 1;
        if ($data['result_start'] == 0) $data['result_start']= 1; 
            $data['result_end'] = $data['result_start']+$config['per_page']-1;

        if ($data['result_end'] < $config['per_page'])   
            $data['result_end'] = $config['per_page'];  
        else if ($data['result_end'] > $config['total_rows'])
            $data['result_end'] = $config['total_rows'];

        //load view
        $this->load->view('publicity_page', $data);
        
    }

    public function search_publicity()
    {
        $search_publicity = $this->input->post('search_publicity');
        if (!empty($search_publicity)) {

            $data['result']     = '';
            $data['total']     = '';
            $data['pagination'] = '';
            $data['result_start'] = '';
            $data['result_end'] = '';
            $data['publicity_search_msg'] = 'Click the search button again to refresh ';
            $data['result'] = $this->MyModel->search_publicityM($search_publicity);

            if ($data['result']) {
                $this->load->view('publicity_page', $data);
            }else{
                $sdata['search_result_msg'] = "Result not found";
                redirect('publicity');
            }
        }else{
            $sdata['search_result_msg'] = "Please enter something for search";
            redirect('publicity');
        }

            
    }


}