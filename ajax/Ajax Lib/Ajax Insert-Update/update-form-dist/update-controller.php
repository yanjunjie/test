function waiverInfo($param_student_id = '')
    {
        if ($param_student_id != '') {
            $student_id = $param_student_id;
        } else {
            $student_id = $this->STUDENT_ID;
        }

        $data['student_id'] = $student_id;
        $data['student_info'] = $this->student_model->getStudentAllWaiverInfo($student_id);

        $this->load->view('student/student_waiver_info', $data);
    }

    function updateWaiverInfo($param_student_id = '', $stu_waiver_id = '')
    {
        if ($param_student_id != '') {
            $student_id = $param_student_id;
        } else {
            $student_id = $this->STUDENT_ID;
        }

        $data['student_id'] = $student_id;

        if (1) {

            $data["ins_session"] = $this->utilities->academicSessionList();
            $data["student_waiver_info"] = $this->student_model->getStudentWaiverInfo($student_id, $stu_waiver_id);

            $data["waiver_type"] = $this->db->get('waiver_view')->result();

            //echo "<pre>"; print_r($data["waiver_type"]); exit;

            $this->form_validation->set_rules('SESSION_ID', 'Session', 'required');

            if ($this->form_validation->run() == FALSE) {

                $this->load->view('student/update_waiver_info', $data);
            } else {

                $STU_WAIVER_ID = $this->input->post('stu_waiver_id');

                $student_waiver_info = array(
                    'STUDENT_ID' => $student_id,
                    'SESSION_ID' => $this->input->post('SESSION_ID'),
                    'WAIVER_TYPE' => $this->input->post('WAIVER_ID'),
                    'PERCENTAGE' => $this->input->post('PERCENTAGE'),
                    'ACTIVE_STATUS' => $this->input->post('is_active')
                );

                $inactive_status_all = array(
                    'ACTIVE_STATUS' => ''
                );

                //echo "<pre>"; print_r($student_waiver_info); exit;

                $this->utilities->updateData('student_waiver_info', $inactive_status_all, array('STUDENT_ID' => $student_id));
                $this->utilities->updateData('student_waiver_info', $student_waiver_info, array('STUDENT_ID' => $student_id, 'STU_WAIVER_ID' => $STU_WAIVER_ID));

            }

        } else {

            redirect('applicant/applicantDetails');
        }
    }
