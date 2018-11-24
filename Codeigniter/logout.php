function logout()
    {
        $this->session->unset_userdata('applicant_logged_in');
        $this->session->unset_userdata('applicant_summary');
        $this->session->unset_userdata('app_academic_sess_array');
        redirect('Portal/login', 'refresh');
    }
