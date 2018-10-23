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
