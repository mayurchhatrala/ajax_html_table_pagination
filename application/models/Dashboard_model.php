<?php

class Dashboard_model extends CI_Model {

    var $table;
    var $content;
    var $admin;

    function __construct() {
        parent::__construct();
        $this->load->helper('cookie');
        $this->content = 'content';
        $this->admin = 'admin';
    }
    
    function total_user() {
        $rec = $this->db->query("SELECT user_id FROM tbl_user where status = 'Active' AND is_deleted = '0' ");
        return $rec->num_rows();
    }

     function total_club($id = '') {
        if (!empty($id)) {
            $this->db->where("club_id", $id);
        }
        $rec = $this->db->select("club_id")->get_where('tbl_club', array("status" => 'Active'));
        return $rec->num_rows();
    }

     function total_event($id = '') {
        if (!empty($id)) {
            $this->db->where("club_id", $id);
        }
        $rec = $this->db->select("event_id")->get_where('tbl_event', array("status" => 'Active'));
        return $rec->num_rows();
    }

    function total_inactive_user() {
        $rec = $this->db->query("SELECT user_id FROM tbl_user where status = 'Inactive' AND is_deleted = '0' ");
        return $rec->num_rows();
    }

    function last_24_user() {
        $rec = $this->db->query("SELECT * FROM tbl_user where (created_date >= NOW() - INTERVAL 1 DAY) AND is_deleted = '0' ");
        if($rec->num_rows() > 0) {
            return $rec->result_array();
        } else {
            return '';
        }
    }
}

?>