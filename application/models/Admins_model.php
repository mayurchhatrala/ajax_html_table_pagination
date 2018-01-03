<?php

class Admins_model extends CI_Model {

    var $table, $tblKey, $fUploadFolder, $RESP;
    var $tableFollower, $tableFollowing;

    function __construct() {

        parent::__construct();
        $this->table = 'tbl_admin';
        $this->tblKey = 'iAdminID';
        $this->fUploadFolder = 'User';
        $this->load->library("DatatablesHelper");
        $this->STATUS = FAIL_STATUS;
        $this->MSG = INSUFF_DATA;
        // $this->load->library("apn");
    } 

    private function _setReponseArray($record = array()) {
        try {
            $this->RESP = array(
                'MSG' => $this->MSG,
                'STATUS' => $this->STATUS,
                'RECORD' => $record
            );
        } catch (Exception $ex) {
            throw new Exception('Crud Model : Error in _setReponseArray function - ' . $ex);
        }
    }

    function getUserDataAll($postData = '') {

        try {
            $restult = $this->db->select('iAdminID as iAdminID')->get($this->table);
            if ($restult->num_rows() > 0) {
                return $restult->result_array();
            } else {
                return '';
            }
        } catch (Exception $ex) {

            return $ex->getMessage();
        }
    }

    /*
     *      GET FOLLOWR AND FOLLWING DETAIL
     */

    function checkUserName($userName = '', $userId = '') {
        try {

            if ($userName != '') {
                $restult = $this->db->select(
                                " u.email as email, "
                                . " u.user_id as user_id"
                        )
                        ->where_not_in("u.user_id", !empty($userId) ? $userId : '')
                        ->get_where("$this->table as u", array("u.email" => $userName, "is_deleted" => '0')
                );

                // echo $this->db->last_query(); exit;

                if ($restult->num_rows() > 0) {
                    $this->MSG = "User ";
                    $this->STATUS = SUCCESS_STATUS;
                } else {
                    $this->MSG = USER_EXISTS;
                }
            } else {
                $this->MSG = NO_DATA;
            }

            $this->_setReponseArray();

            return $this->RESP;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    /*
     *    GET A POST FROM THE ID
     */

    function getUserDataById($postId = '') {

        try {
            $path = IMAGE_URL . 'Default/';
            $restult = $this->db->select(""
                            . " u.iAdminID as admin_id, "
                            . " u.vFirstName as vFirstName,"
                            . " u.vLastName as vLastName,"
                            . " u.vEmail as vEmail,"
                            . " IF(u.vProfile != '', CONCAT('$path', 'thumb/' , u.vProfile),'') as user_image_thumb, "
                            . " IF(u.vProfile != '', CONCAT('$path', u.vProfile),'') as user_image"
                    )
                    ->get_where("$this->table as u", array("u.$this->tblKey" => $postId));
            if ($restult->num_rows() > 0) {
                $data = $restult->row_array();
                return $data;
            } else {
                return '';
            }
        } catch (Exception $ex) {

            return $ex->getMessage();
        }
    }

    /*
     *  TO ADD POST
     */

    function addPost($postData = array()) {

        try {

            extract($postData);

            $data = array(
                'iAdminTypeID' => $iAdminTypeID,
                'vFirstName' => $first_name,
                'vLastName' => $last_name,
                'vEmail' => $email,
                'vPassword' => $password,
                'eStatus' => 'active',
                'tLastLogin' => time()
            );

            $this->db->insert($this->table, $data);

            if ($this->db->affected_rows() > 0) {

                $insID = $this->db->insert_id();

                if ($insID > 0) {
                    if (isset($_FILES['admin_image']['name']) && !empty($_FILES['admin_image']['name'])) {
                        $upload = uploadimage($_FILES['admin_image'], 'admin_image', 'Default');
                        $updateData = array('vProfile' => $upload[0]);
                        $this->db->update($this->table, $updateData, array($this->tblKey => $insID));
                    }
                }

                $this->RESP['RECORDID'] = $insID;

                $this->MSG = ADMIN_ADDED;

                $this->STATUS = SUCCESS_STATUS;
            } else {

                $this->MSG = INSERT_WARN;
            }

            $this->_setReponseArray();

            return $this->RESP;
        } catch (Exception $ex) {

            throw new Exception('Crud Model : Error in addRecord function - ' . $ex);
        }
    }

    /*
     *  TO EDIT POST
     */

    function editPost($postData = array()) {
        try {
            extract($postData);

            $data = array(
                'vFirstName' => $first_name,
                'vLastName' => $last_name,
                'vEmail' => $email,
                'eStatus' => 'active',
                'tLastLogin' => time()
            );
            /*if(!empty($password)) {
                $data['password'] = $password;
            }*/
            $this->db->update($this->table, $data, array($this->tblKey => $admin_id));

            if (isset($_FILES['admin_image']['name']) && !empty($_FILES['admin_image']['name'])) {                
                $upload = uploadimage($_FILES['admin_image'], 'admin_image', 'Default');
                $updateData = array('vProfile' => $upload[0]);
                $this->db->update($this->table, $updateData, array($this->tblKey => $admin_id));
            }

            if ($this->db->affected_rows() > 0) {
                $this->RESP['RECORDID'] = $admin_id;
                $this->MSG = ADMIN_EDITED;
                $this->STATUS = SUCCESS_STATUS;
            } else {
                $this->MSG = "No Record Updated.";
            }

            $this->_setReponseArray();

            return $this->RESP;
        } catch (Exception $ex) {

            throw new Exception('Crud Model : Error in addRecord function - ' . $ex);
        }
    }

// **********************************************************************
//                  remove USER
// **********************************************************************

    function remove($SubCatData = array()) {

        extract($SubCatData);

        $query = $this->db->query("DELETE FROM $this->table WHERE $this->tblKey = $id");
        if ($this->db->affected_rows() > 0) {
            $this->RESP['RECORDID'] = $id;
            $this->MSG = ADMIN_DELETED;
            $this->STATUS = SUCCESS_STATUS;
        } else {

            $this->MSG = POST_NOT_DEL_SUCC;
        }

        $this->_setReponseArray();

        return $this->RESP;
    }

// **********************************************************************
//                  user's Status
// **********************************************************************

    function changeUserStatus($iUserID) {

        $query = $this->db->query("UPDATE $this->table SET status = IF (status = '1', '0','1') WHERE $this->tblKey = $iUserID");

        if ($this->db->affected_rows() > 0)
            return $query;
        else
            return '';
    }

// **********************************************************************
//                  user's Listing
// **********************************************************************

    function get_paginationresult() {

        $path = IMAGE_URL . 'Default/';        
        $data = $this->datatableshelper->query("SELECT u.iAdminID as iAdminID, "
                . " u.vFirstName as vFirstName,"
                . " u.vLastName as vLastName,"
                . " u.vEmail as vEmail,"
                . " IF(u.vProfile != '', CONCAT('$path', u.vProfile), '') as vProfile"
                . " FROM $this->table as u "
        );
        return $data;
    }

}
