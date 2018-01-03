<?php

class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('admin_model');
    }

    function index() {

        if ((isset($_POST) && count($_POST) > 0)) {

            $res = $this->admin_model->login_check();
            if ($res == true) {
                redirect('Dashboard');
            }
        } elseif ($this->session->userdata('ADMINLOGIN') == TRUE) {
            redirect('Dashboard');
        } else {
            $this->load->view('app/login/index');
        }
    }


}


