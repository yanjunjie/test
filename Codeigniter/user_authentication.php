//Controller:
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{
    public static $model = 'MyModel';
    const  TITLE = 'Login';

    public function __construct()
    {

        parent::__construct();

        //$this->load->database();
        $this->load->model(self::$model);
        //$this->load->helper(self::$helper);
        $this->load->library('form_validation');
        //$this->load->library('upload');
        //$this->load->library('image_lib');
        //$this->load->library('session');

        if ($this->session->userdata('logged_in')) {
            redirect('back');
        }

    }

    public function index()
    {
        $this->load->view('back/LoginPage');
    }

    //Check Login Data
    public function checkLoginData() {

        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            if($this->session->userdata('logged_in')){
                $this->load->view("back/BackMaster");
            }else{
                $this->load->view('back/LoginPage');
            }
        } else {
            $data = array(
                'username' => $this->input->post('username'),
                'password' => md5($this->input->post('password'))
            );
            $result = $this->MyModel->login($data);

            if ($result) {
                $session_data = array(
                    'username' => $result->username,
                    'password' => $result->password,
                );

                // Add user data in session
                $this->session->set_userdata($session_data);
                $this->session->set_userdata('logged_in',$session_data);
                redirect('back');
            } else {
                $data = array(
                    'error_alert' => 'Invalid Username or Password'
                );
                $this->load->view('back/LoginPage', $data);
            }
        }
    }
    //End Check Login Data


}
?>



//Model:
// Read data using username and password
    public function login($data) {
        $condition = "username ='" . $data['username'] . "' AND " . "password ='" . $data['password'] . "'";
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where($condition);
        $query = $this->db->get();
        return $query->row();
    }

    //Temp
    //Admin login info
    public function logincheck($user_name, $user_pass, $user_type){
        $this->db->select('*');
        $this->db->from(self::$admin);
        $this->db->where('adm_username', $user_name);
        $this->db->where('adm_userpass', $user_pass);
        $this->db->where('user_type', $user_type);
        $query = $this->db->get();
        return $query->row();
    }
	
	
//Html:
	<?php if (isset($error_alert)): ?>
    <div class="alert alert-danger alert-dismissable fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Failure!</strong> <?php echo isset($error_alert)?$error_alert:''; ?>
    </div>
    <?php endif; ?>

    <?php if(validation_errors() != false): ?>
        <div class="alert alert-danger alert-dismissable fade in">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Failure!</strong> <?php echo validation_errors();?>
        </div>
    <?php endif; ?>

    <?php if (isset($success_alert)): ?>
        <div class="alert alert-success alert-dismissable fade in">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Success!</strong> <?php echo isset($success_alert)?$success_alert:''; ?>
        </div>
    <?php endif; ?>

//	

