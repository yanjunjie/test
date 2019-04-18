<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Welcome extends CI_Controller
{
    public function index($page = 1)
    {
        //load model
        $this->load->model('people_model');
        //hitung total data
        $total = $this->people_model->get_total();
        //ambil data
        $limit  = 10; //menentukan limit/jumlah data yang akan ditampilkan per page
        $result = $this->people_model->get_all($limit, $page); //$this->db->limit($pPagination['Length'], $pPagination['Start']);
        //menentukan url pagination
        $url = site_url('welcome/index');
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
        //menyiapkan data untuk dikirim ke view
        $data['result']     = $result;
        $data['pagination'] = $pagination;
        //load view
        $this->load->view('welcome_message', $data);
    }
}