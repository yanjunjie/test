<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model("model_myclass", "mmc", TRUE);
        $this->load->model('model_table', "mt", TRUE);
    }
    public function index()  {
        $data['title'] = "Login";
        $this->load->view('login', $data);
    }
    function procedure(){
        $user = mysql_real_escape_string($this->input->post('txtUserName'));
        $pass = md5($this->input->post('txtPassword'));
        $x = "SELECT tbl_user.*,tbl_brunch.* from tbl_user left join tbl_brunch on tbl_brunch.brunch_id = tbl_user.userBrunch_id where tbl_user.User_Name ='$user' AND tbl_user.User_Password ='$pass'";
        $sql = mysql_query($x);
        $d = mysql_fetch_array($sql); 
        
        if($d['Status'] == "a"){
            if ($d['UserType'] =='a') {
                $verifycode = rand(0,99999);
                $id=$d['User_SlNo'];
                $fld='User_SlNo';
                $Data = array('verifycode' => $verifycode, );
                $this->mt->update_data("tbl_user", $Data, $id,$fld);

                $config = Array(
               'protocol' => 'smtp',
               'smtp_host' => 'ssl://host8.registrar-servers.com',
               'smtp_port' => 465,
               'smtp_user' => 'info@besteadbd.com',
               'smtp_pass' => 'bestead@1020'
                 );

                 $this->load->library('email');
                 $this->email->set_newline("\r\n");

                 $this->email->from('info@besteadbd.com');
                 $this->email->to("besteadbd@gmail.com");
                 $this->email->subject('Verify Code');
                 $this->email->message($d['FullName'].' '.'Code : '.$verifycode);

                 if($this->email->send())
                 {
                     echo "Your email sent.!";
                 } else {
                     show_error($this->email->print_debugger());
                 }
                $sdata['User_Name'] = $d['User_Name'];
                $this->session->set_userdata($sdata);
                redirect('loginVerify/verify_code');
            }else{
                $verifycode = rand(0,99999);
                $id=$d['User_SlNo'];
                $fld='User_SlNo';
                $Data = array('verifycode' => $verifycode, );
                $this->mt->update_data("tbl_user", $Data, $id,$fld);

                $config = Array(
               'protocol' => 'smtp',
               'smtp_host' => 'ssl://host8.registrar-servers.com',
               'smtp_port' => 465,
               'smtp_user' => 'info@besteadbd.com',
               'smtp_pass' => 'bestead@1020'
                 );

                 $this->load->library('email');
                 $this->email->set_newline("\r\n");

                 $this->email->from('info@besteadbd.com');
                 $this->email->to("besteadbd@gmail.com");
                 $this->email->subject('Verify Code');
                 $this->email->message($d['FullName'].' '.'Code : '.$verifycode);

                 if($this->email->send())
                 {
                     echo "Your email sent.!";
                 } else {
                     show_error($this->email->print_debugger());
                 }
                $sdata['User_Name'] = $d['User_Name'];
                $this->session->set_userdata($sdata);
               redirect('loginVerify/verify_code');
            }
            
        }
        else{
            $sdata['st'] = "Invalid Username or Password";
            $this->load->view('login', $sdata);
        }
    }
    

    public function forgotpassword()  {
        $data['title'] = "Forgot Password";
        $this->load->view('ForgotPassword', $data);
    }
    public function logout(){
        $this->session->unset_userdata('userId');
        $this->session->unset_userdata('User_Name');
        $this->session->unset_userdata('accountType');
        //$this->session->unset_userdata('useremail');
        redirect("login");
    }

}
