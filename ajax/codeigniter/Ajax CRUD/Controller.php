function studentModal()
    {
        $STUDENT_ID = $_POST['STUDENT_ID'];
        $data['view_only'] = 'yes';
        $data['student_id'] = $STUDENT_ID;
        $data["students_info"] = $this->student_model->getStudentInfoAll($STUDENT_ID);
        //echo "<pre>"; print_r($data); exit; echo "</pre>";
        echo $this->load->view('student/details_modal_view', $data, true);
    }


    function studentDetails($param_student_id = '')
    {
        if ($param_student_id != '') {
            $student_id = $param_student_id;
        } else {
            $student_id = $this->STUDENT_ID;
        }

        $data['student_id'] = $student_id;
        $data["students_info"] = $this->student_model->getStudentInfoAll($student_id);
        //echo "<pre>"; print_r($data["students_info"]); exit; echo "</pre>";
        $data['content_view_page'] = 'student/details_modal_view';


        if ($this->STUDENT_ID != '') {
            $this->student_portal->display($data);
        } else {
            $this->admin_template->display($data);
        }
    }

    function personalDetails($param_student_id = '')
    {

        if ($param_student_id != '') {
            $student_id = $param_student_id;
        } else {
            $student_id = $this->STUDENT_ID;
        }


        $data['student_id'] = $student_id;
        $data["students_info"] = $this->student_model->getStudentInfoAll($student_id);

        $this->load->view('student/student_personal_information', $data);
    }


    function updateStudentPersonalDetails($param_student_id = '')
    {
        if ($param_student_id != '') {
            $student_id = $param_student_id;

        } else {
            $student_id = $this->STUDENT_ID;
        }

        $data['student_id'] = $student_id;


        if (1) {
            $this->form_validation->set_rules('FULL_NAME_BN', 'Full name BN', 'required');
            $this->form_validation->set_rules('PLACE_OF_BIRTH', 'place', 'required');

            $student_info = $this->student_model->getStudentInfoAll($student_id);

            $data["student_info"] = $this->student_model->getStudentInfoAll($student_id);

            if ($this->form_validation->run() == FALSE) {
                //   echo "false";exit;

                $data['nationality'] = $this->utilities->getAll('country');
                $data['religion'] = $this->utilities->findAllByAttribute('m00_lkpdata', array('GRP_ID' => 3));
                $data['merital_status'] = $this->utilities->findAllByAttribute('m00_lkpdata', array('GRP_ID' => 8));
                $data['blood_group'] = $this->utilities->findAllByAttribute('m00_lkpdata', array('GRP_ID' => 4));

                $this->load->view('student/update_student_personal_information', $data);
            } else {

                require(APPPATH . 'views/common/image_upload/class.upload.php');
                $applicant_photo_name = '';
                $signature_photo_name = '';
                $foo = new Upload($_FILES['photo']);
                if ($foo->uploaded) {
                    // large size image
                    $foo->file_new_name_body = 'photo_' . $student_info->REGISTRATION_NO;
                    $foo->image_border = 1;
                    $foo->file_overwrite = true;
                    //$foo->image_border_color    = '#231F20';
                    $foo->allowed = array('image/*');
                    $foo->Process('upload/student/photo/');
                    if ($foo->processed) {
                        $applicant_photo_name = 'photo_' . $student_info->REGISTRATION_NO . '.' . $foo->file_src_name_ext;
                    } else {
                        echo 'error : ' . $foo->error;
                    }
                }

                $sig_photo = new Upload($_FILES['signature']);
                if ($sig_photo->uploaded) {
                    // large size image
                    $sig_photo->file_new_name_body = 'signature_' . $student_info->REGISTRATION_NO;
                    $sig_photo->image_border = 1;
                    $sig_photo->file_overwrite = true;
                    //$foo->image_border_color    = '#231F20';
                    $sig_photo->allowed = array('image/*');
                    $sig_photo->Process('upload/student/signature/');
                    if ($sig_photo->processed) {
                        $signature_photo_name = 'signature_' . $student_info->REGISTRATION_NO . '.' . $sig_photo->file_src_name_ext;
                    } else {
                        echo 'error : ' . $sig_photo->error;
                    }
                }
                // ### student personal information ###
                $student_info = array(
                    'FULL_NAME_BN' => $this->input->post('FULL_NAME_BN'),
                    'PLACE_OF_BIRTH' => $this->input->post('PLACE_OF_BIRTH'),
                    'BLOOD_GROUP' => $this->input->post('BLOOD_GRP'),
                    'MARITAL_STATUS' => $this->input->post('MARITAL_STATUS'),
                    'NATIONALITY' => $this->input->post('NATIONALITY'),
                    'NATIONAL_ID' => $this->input->post('NATIONAL_ID'),
                    'BIRTH_CERTIFICATE' => $this->input->post('BIRTH_CERTIFICATE'),
                    'RELIGION_ID' => $this->input->post('RELIGION_ID'),


                    'HEIGHT_FEET' => $this->input->post('HEIGHT_FEET'),
                    'HEIGHT_CM' => $this->input->post('HEIGHT_CM'),
                    'WEIGHT_KG' => $this->input->post('WEIGHT_KG'),
                    'WEIGHT_LBS' => $this->input->post('WEIGHT_LBS'),
                );

                //echo "<pre>"; print_r($student_info); exit;

                if ($applicant_photo_name != '') {
                    $student_info['PHOTO'] = $applicant_photo_name;

                }
                if ($signature_photo_name != '') {
                    $student_info['SIGNATURE_PHOTO'] = $signature_photo_name;

                }

                $this->utilities->updateData('student_personal_info', $student_info, array('STUDENT_ID' => $student_id));

                echo $applicant_photo_name;
            }

        } else {

            redirect('applicant/applicantDetails');
        }

    }
