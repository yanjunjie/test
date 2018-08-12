<?php

class Parents_template {

    protected $_ci;

    function __construct() {

        $this->_ci = &get_instance();
    }

    function display($data = null) {

        $data['pageContentTitle'] = ((isset($data['contentTitle']) == '') ? ' ' : $data['contentTitle']);
        $data['pageTitle'] =  ((isset($data['pageTitle']) == '') ? ' ' :  $data['pageTitle']);
        $data['breadcrumbs'] = ((isset($data['breadcrumbs']) == '') ? array() : $data['breadcrumbs']);
        $data['_content'] = $this->_ci->load->view((isset($data['content_view_page']) == '') ? 'parents_template/content' : $data['content_view_page'], $data, true);

        $this->_ci->load->view('parent.php', $data);
    }

}

?>