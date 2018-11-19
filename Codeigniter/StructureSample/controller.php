class MY_Controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function show_view($view, $data = array())
    {
        $this->load->view('header', $data);
        $this->load->view($view, $data);
        $this->load->view('footer', $data);
    }

}
Now, you can load any view, and we pass the $data array to both the header and footer too.

$this->show_view('homepage', $data);