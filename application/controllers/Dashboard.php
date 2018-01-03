<?php

class Dashboard extends CI_Controller {

    var $viewData = array();

    function __construct() {
        parent::__construct();
        $this->load->model('dashboard_model');
        chk_admin_session();
    }

    function index() {

        $viewData = array();
        if( $this->session->userdata('ADMINLOGIN') == 1 ) { 

            $viewData['total_user'] = $this->dashboard_model->total_user();
            $viewData['total_club'] = $this->dashboard_model->total_club();
            $viewData['total_event'] = $this->dashboard_model->total_event();
            $viewData['total_inactive_user'] = $this->dashboard_model->total_inactive_user();
            $viewData['last_24_user'] = $this->dashboard_model->last_24_user();
        } else if( $this->session->userdata('ADMINLOGIN') == 3 ){

            $id = $this->session->userdata('ADMINID');
            
            $viewData['total_club'] = $this->dashboard_model->total_club($id);
            $viewData['total_event'] = $this->dashboard_model->total_event($id);
        }
        
        // SPACIFY FILE NAME
        $viewData['view_file'] = 'app/dashboard/index';
        $this->load->view('default', $viewData);
    }
    
}
