<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct() {
        parent::__construct();
		$this->load->model('student_model');
    }

	public function index()
	{
		$this->load->view('user_form');
	}

	public function addData()
	{
		$data = array();
		$data['firstname'] = $this->input->post('firstname', true);
		$data['lastname'] = $this->input->post('lastname', true);
		$data['stud'] = $this->input->post('stud', true);
		$data['maths'] = $this->input->post('mathsmarks', true);
		$data['science'] = $this->input->post('sciencemarks', true);
		$data['english'] = $this->input->post('englishmarks', true);
		$addData = $this->student_model->addData($data);
		if(!empty($addData)){
			echo json_encode(array("STATUS" => 200));
		} else {
			echo json_encode(array("STATUS" => 101));
		}
	}

	public function getStudentList()
	{
		$data = array();
		$data['limit'] = $this->input->post("pageid");
		$data['limit1'] = $this->input->post("limit");
		$data['key'] = $this->input->post("key");
		$data['search'] = $this->input->post("search");
		$getData = $this->student_model->getStudentList($data);
		if(!empty($getData)){
			echo json_encode(array("DATA"=>$getData, "STATUS"=>200));
		} else {
			echo json_encode(array("DATA"=>"", "STATUS"=>101));
		}
	}

	public function list()
	{
		$this->load->view('student_list');
	}
}
