<?php

class Logout extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin_model');
        $this->load->helper('cookie');
    }

    function index() {

        $logid = addUserActivityLog('cms', '9');
        $this->session->unset_userdata(true);
        $this->session->sess_destroy();

        if (FALSE !== $this->session->userdata('ADMINLOGIN')) {
            redirect('login','refresh');
        } 

    }
}
