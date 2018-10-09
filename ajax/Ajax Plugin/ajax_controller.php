function ajaxModalById()
    {
        $id = $_POST['id'];
        $table = $_POST['table'];
        $view = $_POST['ajax_view'];
        $data["result"] = $this->student_model->findByAttribute($table, $id);
        $data['id']=$id;
        echo $this->load->view($view, $data, true);
        exit();
    }


//
