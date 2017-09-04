/*
    ***Landloard Registraion
    */
    public function onlineRegistration()
    {
        $reterData = array();

        //Start upload picture
        if(!empty($_FILES['lnd_photo']['name'])){ //if($_FILES['image']['error'] == 0){
            $config['upload_path'] = 'uploads/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['file_name'] = date("Y-m-d-H-i-s")."_".str_replace(' ', '-', $_FILES['lnd_photo']['name']);

            //Load upload library and initialize configuration
            $this->load->library('upload',$config);
            $this->upload->initialize($config);

            if($this->upload->do_upload('lnd_photo')){
                $finfo=$this->upload->data();
                $this->_createThumbnail($finfo['file_name']);
                $lnd_photo = $finfo['raw_name'].'_thumb'.$finfo['file_ext'];
                //$lnd_photo = $finfo['file_name'];
            }else{
                $lnd_photo = '';
            }
        }else{
            $lnd_photo = '';
        }
        //End upload picture

        //Data Check
        //if ( !empty($_POST['user_pass']) && !empty($_POST['lnd_name']) && !empty($_POST['lnd_birth_date']) && !empty($_POST['lnd_nid']) ) {

        //if ( !empty($_POST['lnd_nid']) ) {
            
            //form validation
            $this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');
                 
            $this->form_validation->set_error_delimiters('<label class="error">', '</label>'); /*<?php echo form_error('lnd_police_station'); ?>*/

            $this->form_validation->set_rules('lnd_name', 'Fullname', 'trim|required', array('required' => 'You must provide a %s.')); 

            $this->form_validation->set_rules('lnd_phone', 'Mobile No.', 'trim|required|min_length[11]|max_length[15]', array('required' => 'You must provide a %s.')); 

            $this->form_validation->set_rules('lnd_nid', 'National ID', 'trim|required|min_length[13]|is_unique[landloard.lnd_nid]', array('required' => 'You must provide a %s.')); 

            $this->form_validation->set_rules('lnd_police_station', 'Thana', 'trim|required', array('required' => 'You must provide a %s.')); 

            $this->form_validation->set_rules('lnd_holding_no', 'House No.', 'trim|required', array('required' => 'You must provide a %s.')); 

            $this->form_validation->set_rules('lnd_road_no', 'Road No.', 'trim|required', array('required' => 'You must provide a %s.')); 

            $this->form_validation->set_rules('lnd_locality', 'Locality/পাড়া', 'trim|required', array('required' => 'You must provide a %s.')); 

            $this->form_validation->set_rules('lnd_postcode', 'Post Code', 'trim|required', array('required' => 'You must provide a %s.')); 


            if ($this->form_validation->run() == FALSE)
            {

                $this->load->view('home_page');            
               
            }
            else
            {
                //lnd Table (1)
                //$lnd_id = $this->input->post('lnd_id');
                $lndData['lnd_pass'] = $this->input->post('user_pass');
                $lndData['user_type'] = $this->input->post('user_type');
                $lndData['lnd_fullname'] = $this->input->post('lnd_name');
                $lndData['lnd_father_name'] = $this->input->post('lnd_father_name');

                $lnd_birth_date = strtotime($_POST['lnd_birth_date']);
                $lndData['lnd_birth_date']=date("Y-m-d",$lnd_birth_date); /* password*/
                /*$lndData['lnd_birth_date'] = $this->input->post('lnd_birth_date'); /* password*/

                $lndData['lnd_maritial_status'] = $this->input->post('lnd_maritial_status');
                $lndData['lnd_permanent_add'] = $this->input->post('lnd_permanent_add');
                $lndData['lnd_profession_institute'] = $this->input->post('lnd_profession_institute');
                $lndData['lnd_religion'] = $this->input->post('lnd_religion');
                $lndData['lnd_educational_status'] = $this->input->post('lnd_educational_status');
                $lndData['lnd_phone'] = $this->input->post('lnd_phone');
                $lndData['lnd_email'] = $this->input->post('lnd_email');
                $lndData['lnd_nid'] = $this->input->post('lnd_nid'); /* user_name*/
                $lndData['lnd_passport'] = $this->input->post('lnd_passport');
                $lndData['lnd_emergency_name'] = $this->input->post('lnd_emergency_name');
                $lndData['lnd_emergency_relation'] = $this->input->post('lnd_emergency_relation');
                $lndData['lnd_emergency_address'] = $this->input->post('lnd_emergency_address');
                $lndData['lnd_emergency_phone'] = $this->input->post('lnd_emergency_phone');

                $lndData['lnd_previous_landlord_name'] = $this->input->post('lnd_previous_landlord_name');
                $lndData['lnd_previous_landlord_phone'] = $this->input->post('lnd_previous_landlord_phone');
                $lndData['lnd_previous_landlord_permanent_add'] = $this->input->post('lnd_previous_landlord_permanent_add');

                $lndData['lnd_prvious_leave_reason'] = $this->input->post('lnd_prvious_leave_reason');

                $lndData['lnd_present_landlord_name'] = $this->input->post('lnd_present_landlord_name');
                $lndData['lnd_present_landlord_phone'] = $this->input->post('lnd_present_landlord_phone');
                $lndData['lnd_present_start_date'] = $this->input->post('lnd_present_start_date');

                $lndData['lnd_division'] = $this->input->post('lnd_division');
                $lndData['lnd_district'] = $this->input->post('lnd_district');
                $lndData['lnd_police_station'] = $this->input->post('lnd_police_station');
                $lndData['lnd_flat_floor_no'] = $this->input->post('lnd_flat_floor_no');
                $lndData['lnd_holding_no'] = $this->input->post('lnd_holding_no');
                $lndData['lnd_road_no'] = $this->input->post('lnd_road_no');
                $lndData['lnd_locality'] = $this->input->post('lnd_locality');
                $lndData['lnd_postcode'] = $this->input->post('lnd_postcode');
                $lndData['lnd_photo'] = $lnd_photo;

                $lndInsertId = $this->MyModel->save_lnd_reg_data($lndData);

                if ($lndInsertId){
                    $sdata['message'] = 'Landlord added successfully';
                    $sdata['lndAddedSussess'] = 'Landlord added successfully';

                    //lnd_familymember Table (02)
                    $lndFMData['lnd_id'] = $lndInsertId; /* foreign key*/
                    $lndFMData['family_member_name'] = $this->input->post('family_member_name');
                    $lndFMData['family_member_age'] = $this->input->post('family_member_age');
                    $lndFMData['family_member_job'] = $this->input->post('family_member_job');
                    $lndFMData['family_member_phone'] = $this->input->post('family_member_phone');

                    $lndFMInsertId = $this->MyModel->save_lndFM_data($lndFMData);

                    if($lndFMInsertId){
                        $sdata['lndFMSuccess'] = 'Landlord family member added successfully';
                    }else{
                        $sdata['lndFMFailure'] = 'Landlord family member added failure';
                    }

                    //lnd_homeworker Table (03)
                    $lndHWData['lnd_id'] = $lndInsertId; /* foreign key*/
                    $lndHWData['homeworker_name'] = $this->input->post('homeworker_name');
                    $lndHWData['homeworker_nid'] = $this->input->post('homeworker_nid');
                    $lndHWData['homeworker_phone'] = $this->input->post('homeworker_phone');
                    $lndHWData['homeworker_permanent_add'] = $this->input->post('homeworker_permanent_add');

                    $lndHWInsertId = $this->MyModel->save_lndHW_data($lndHWData);

                    if($lndHWInsertId){
                        $sdata['lndHWSuccess'] = 'Landlord home worker added successfully';
                    }else{
                        $sdata['lndHWFailure'] = 'Landlord home worker added failure!';
                    }

                    //lnd_driver Table (04)
                    $lnd_driverData['lnd_id'] = $lndInsertId; /* foreign key*/
                    $lnd_driverData['driver_name'] = $this->input->post('driver_name');
                    $lnd_driverData['driver_nid'] = $this->input->post('driver_nid');
                    $lnd_driverData['driver_phone'] = $this->input->post('driver_phone');
                    $lnd_driverData['driver_permanent_add'] = $this->input->post('driver_permanent_add');

                    $lndDriverInsertId = $this->MyModel->save_lndDriver_data($lnd_driverData);

                    if($lndDriverInsertId){
                        $sdata['lndDriverSuccess'] = 'Landlord driver added successfully';
                    }else{
                        $sdata['lndDriverFailure'] = 'Landlord driver added failure!';
                    }
                    //Error msg for picture upload
                    if($lnd_photo == ''){
                        $sdata['error_msg_photo_lnd'] = 'Photo has not been uploaded!!';
                    }
                    $this->session->set_userdata($sdata);

                    redirect('home');
                }else{
                    $sdata['message'] = 'Try again! Landlord added failure';
                    $sdata['lndAddedFailure'] = 'Try again! Landlord added failure';
                    $this->session->set_userdata($sdata);
                    redirect('home');
                }
            }
            //End form validation lnd data
        /*}else{
            $sdata['message'] = 'Try again! Landlord added failure';
            $sdata['lndAddedFailure'] = 'Try again! Landlord added failure';
            $this->session->set_userdata($sdata);
            redirect('home');
        } //Data*/

    } //End Landloard Registraion

    /*
     * Thumbnail image creation for landloard
     */
    function _createThumbnail($filename)
    {
        $config['image_library']    = "gd2";
        $config['source_image']     = "uploads/" .$filename;
        $config['create_thumb']     = TRUE;
        $config['maintain_ratio']   = TRUE;
        $config['width']            = "160";
        $config['height']           = "200";

        $this->load->library('image_lib',$config);

        if(!$this->image_lib->resize())
        {
            echo $this->image_lib->display_errors();
        }
    } 
    //End Thumbnail image creation for landloard
