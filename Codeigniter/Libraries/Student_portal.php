<?php

class Student_portal {

    protected $_ci;

    function __construct() {

        $this->_ci = &get_instance();
    }

    function display($data = null) {
        $data['pageContentTitle'] = ((isset($data['contentTitle']) == '') ? ' ' : $data['contentTitle']);
        $data['pageTitle'] = '.: Online University Management System :.' . ((isset($data['pageTitle']) == '') ? ' ' : ' || ' . $data['pageTitle']);
        $data['breadcrumbs'] = ((isset($data['breadcrumbs']) == '') ? array() : $data['breadcrumbs']);
        $data['_content'] = $this->_ci->load->view((isset($data['content_view_page']) == '') ? 'student_portal/content' : $data['content_view_page'], $data, true);
        $this->_ci->load->view('student_portal.php', $data);
    }

}

?>