<?php

// defined('BASEPATH') OR exit('No direct script access allowed');

class Student_model extends CI_Model {

	public function __construct() {
        parent::__construct();
        $this->load->database();
    }

	public function addData($requestData = array())
	{
		$resultCount = 0;
		if($requestData['maths'] > 40){
			$resultCount = $resultCount + 1;
		}
		if($requestData['science'] > 40){
			$resultCount = $resultCount + 1;			
		}
		if($requestData['english'] > 40){
			$resultCount = $resultCount + 1;			
		}

		if($requestData['maths'] > 40 && $requestData['science'] > 40 && $requestData['english'] > 40){
			$result = "Pass";
		} else {
			$result = "Fail";
		}

		$requestData['total_marks'] = $requestData['maths'] + $requestData['science'] + $requestData['english'];;
		$requestData['total_pass'] = $resultCount;
		$requestData['result'] = $result;
		$this->db->insert('tbl_stud', $requestData);
		$id = $this->db->insert_id();
		if(!empty($id)){
			return 1;
		} else {
			return 0;
		}
		
	}

	public function getStudentList($requestData = array())
	{
		$mylimit = !empty($requestData['limit1']) ? ($requestData['limit1']) : 10;
		$page = !empty($requestData['limit']) ? ($requestData['limit']) : 0;
		$limit = !empty($requestData['limit']) ? ($requestData['limit'] * $mylimit) : 0;

		if($requestData['key'] == 'name'){
			$where = $this->db->where(" firstname like '%".$requestData['search']."%' OR lastname like '%".$requestData['search']."%' ");
		}
		$totalRecQry = $this->db->get('tbl_stud');

		if($requestData['key'] == 'name'){
			$where = $this->db->where(" firstname like '%".$requestData['search']."%' OR lastname like '%".$requestData['search']."%' ");
		}
		$qry = $this->db->limit($mylimit,$limit)->get('tbl_stud');
		
		// echo $this->db->last_query(); exit;
		if($qry->num_rows() > 0){
			$data = array();
			$data['total_record'] = $totalRecQry->num_rows();
			$data['DATA'] = $qry->result_array();
			$data['per_page'] = ceil($totalRecQry->num_rows() / $mylimit);
			$data['current_page'] = (int) $page;
			return $data;
		} else {
			return 0;
		}
	}

} 

?>