<?php

class Admin_model extends CI_Model {

    var $table;

    function __construct() {
        parent::__construct();
        $this->load->helper('cookie');
        $this->load->library('session');
        $this->table = 'tbl_admin';

        $this->club = 'tbl_club';
        $this->load->library('encrypt');
        $this->has_key = 'JZnKLA1cW9GG75Ex3QQAfUdRpDHfpN5h';
    }


    /*************************************************************************
     **					Check User Login
    *************************************************************************/

    function login_check() {
        // User Inputs
        $vEmail = $this->input->post('vEmail', TRUE);
        $vPassword = $this->input->post('vPassword', TRUE);

        // Query
        $EvPassword = md5($vPassword);
        $query = $this->db->query("SELECT * FROM tbl_admin WHERE vEmail = '$vEmail' AND vPassword='$EvPassword' ");        
        if ($query->num_rows() == 1) {      
            
            // If there is a user, then create session data
            $row = $query->row();
            if ($row->eStatus == "active") {
                // USER NOT EXISTS IN DATABASE
                if ($row != '') {
                    $userdata = array(
                        'ADMINID' => $row->iAdminID,
                        'ADMINFIRSTNAME' => $row->vFirstName,
                        'ADMINLASTNAME' => $row->vLastName,
                        'ADMINEMAIL' => $row->vEmail,
                        'ADMINTYPE' => $row->iAdminTypeID,
                        'ADMINLOGIN' => 1,
                        'ISADMIN' => 'y',
                        'LAST_ACTIVITY' => time()
                    );
                    //$this->session->sess_expiration = '86500';
                    $this->session->set_userdata($userdata);
                    return true;
                }
            }
        } else {

            $query = $this->db->query("SELECT * FROM $this->club WHERE email = '$vEmail' AND status = 'Active' ");
            if ($query->num_rows() > 0) {

                foreach ($query->result_array() as $key => $value) {

                    if( ($this->encrypt->decode($value['password'], $this->has_key) == $vPassword) && (strcasecmp($value['email'], $vEmail) == 0) ) {

                        $userdata = array(
                            'ADMINTYPE' => $value['admin_type_id'],
                            'ADMINLOGIN' => 3,
                            'ADMINID' => $value['club_id'],
                            'ADMINFIRSTNAME' => $value['club_name'],
                            'ADMINLASTNAME' => "",
                            'ADMINEMAIL' => $value['email'],
                            'LAST_ACTIVITY' => time(),
                            'ISADMIN' => 'n'
                        );
                        //$this->session->sess_expiration = '86500';
                        $this->session->set_userdata($userdata);
                        return TRUE;
                    }
                }
                $ers = array(
                    '0' => LOGIN_ERROR,
                );
                $this->session->set_userdata('ERROR', $ers);
                $this->load->view('app/login/index', '');
                return false;
            } else {
                $ers = array(
                    '0' => LOGIN_ERROR,
                );
                $this->session->set_userdata('ERROR', $ers);
                $this->load->view('app/login/index', '');
                return false;
            }
        }
    }

    /*
      | -------------------------------------------------------------------
      |  CHECK ADMIN EMAIL VALIDATION
      | -------------------------------------------------------------------
     */
    function check_admin_email_valid() {
        // User Inputs
        $admin_email = $this->input->post('vEmail');

        if (isset($admin_email) && $admin_email != '') {
            // Query
            $query = $this->db->get_where($this->table, array('vEmail' => $admin_email));

            // USER NOT EXISTS IN DATABASE
            if ($query->num_rows() == 0) {
                //SET ERROR
                $ers = array(
                    '0' => ADMIN_ERROR
                );
                $this->session->set_userdata('ERROR', $ers);
                $this->load->view('app/login/index', '');
                return false;
            } else {
                $row = $query->row();
                //IF USER IS VALID BUT STATUS IS NOT ACTIVATED YET
                if ($row->eStatus == NULL) {
                    //SET ERROR
                    $ers = array(
                        '0' => ACTIVE_ERROR
                    );
                    $this->session->set_userdata('ERROR', $ers);
                    $this->load->view('login_view', '');
                    return false;
                } else {

                    $this->db->update($this->table, array("vIsReset" => 1), array("iAdminID" => $row->iAdminID));

                    //SEND RESET PASSWORD LINK TO THE USER VIA EMAIL
                    $name = $row->vFirstName . " " . $row->vLastName;
                    $id = $row->iAdminID;
                    $email = $row->vEmail;

                    $subject = 'Forgot Password';
                    $this->load->library('email');
                    $this->load->library('encrypt');
                    
                    $this->email->set_mailtype("html");

                    //$encrypted_id	= strtr($this->encrypt->encode($id), '+/=', '___');
                    $encrypted_id = $this->encrypt->encode($id);
                    $data = array(
                        'link' => BASE_URL . "forgot_pass/activate/" . base64_encode($encrypted_id),
                        'email' => $email,
                        'subject' => $subject
                    );

                    // $this->load->view('email_template/resetpassword_view', $data);

                    $isSend = $this->__adminForgotPassword($data);
                    if(!empty($isSend)){
                        return true;
                    } else {
                        return false;
                    }

                }
            }
        } else { // EMAIL BOX LEFT BLANK
            //SET ERROR
            $ers = array(
                '0' => ADMIN_ERROR
            );
            $this->session->set_userdata('ERROR', $ers);
            $this->load->view('login_view', '');
            return false;
        }
    }
    /*
      | -------------------------------------------------------------------
      |  RESET ADMIN PASSWORD
      | -------------------------------------------------------------------
     */
    function reset_admin_pass($vPassword) {
        $id = $this->input->post('admin_id');

        $this->db->update($this->table, array("vIsReset" => 0), array("iAdminID" => $id));
        
        $this->db->update($this->table, array('vPassword' => md5($vPassword)), array('iAdminID' => $id));
        $query = $this->db->get_where($this->table, array('iAdminID ' => $id));
        $row = $query->row();
        if ($row != '') {
            return "Success";
        }
        else {
            return "";
        }
    }
    /*     * **********************************************************************
      Admin Setting(Getting user details by ADMINID=> From session Element)
     * ********************************************************************** */
    function admin_setting() {
        $query = $this->db->get_where($this->table, array('iAdminID ' => $this->session->userdata('ADMINID')));

        if ($query->num_rows() > 0)
            return $query->row_array();
        else
            return '';
    }
    // **********************************************************************
    // Edit Admin
    // **********************************************************************
    function editAdmin() {
        $admin_id = $this->session->userdata('ADMINID');
        $updateData = array('vFirstName' => $this->input->post('vFirstName'),
            'vLastName' => $this->input->post('vLastName')
        );

        $query = $this->db->update('tbl_admin', $updateData, array('iAdminID ' => $admin_id));

        if ($this->db->affected_rows() > 0) {
            $userdata = array(
                'ADMINLOGIN' => TRUE,
                'ADMINID' => $iAdminID,
                'ADMINFIRSTNAME' => $this->input->post('vFirstName'),
                'ADMINLASTNAME' => $this->input->post('vLastName'),
            );
            // STORE SESSION
            $this->session->set_userdata($userdata);
            return $query;
        } else
            return 1;
    }
    // **********************************************************************
    // Display List of Adminstrator Module
    // **********************************************************************
    function getAdminDataAll() {
        $this->db->from($this->table);
        $result = $this->db->get();
        if ($result->num_rows() > 0)
            return $result->result_array();
        else
            return '';
    }
    /*     * **********************************************************************
      Admin Setting(Getting user details by admin_id(Selected or inserted)
     * ********************************************************************** */
    function getAdminDataById($iAdminID) {
        $result = $this->db->get_where($this->table, array('iAdminID' => $iAdminID));

        if ($result->num_rows() > 0)
            return $result->row_array();
        else
            return '';
    }
    // **********************************************************************
    // Admin Status
    // **********************************************************************
    function changeAdminStatus($iAdminID) {
        //$updateData = array('admin_status' => 'IF (admin_status = "Active", "Inactive","Active")');
        //$query = $this->db->update($this->admin_tbl,$updateData, array('admin_role ' => $admin_role));
        $query = $this->db->query("UPDATE $this->table SET eStatus = IF (eStatus = 'Active', 'Inactive','Active') WHERE iAdminID = $iAdminID");

        if ($this->db->affected_rows() > 0)
            return $query;
        else
            return '';
    }
    // **********************************************************************
    // remove admin
    // **********************************************************************
    function removeAdmin($iAdminID) {
        $query = $this->db->delete($this->table, array('iAdminID' => $iAdminID));

        if ($this->db->affected_rows() > 0)
            return $query;
        else
            return '';
    }
    // **********************************************************************
    // add admin
    // **********************************************************************
    function addAdmin($postData) {
        extract($postData);
        $vPassword = md5($vPassword);

        $data = array('vFirstName' => $vFirstName,
            'vLastName' => $vLastName,
            'vEmail' => $vEmail,
            'eStatus' => 'Active',
            'vPassword' => $vPassword
        );

        $query = $this->db->insert($this->table, $data);

        if ($this->db->affected_rows() > 0)
            return $this->db->insert_id();
        else
            return '';
    }
    // **********************************************************************
    // Check Email Availibility
    // **********************************************************************
    function checkAdminEmailAvailable($vEmail, $iAdminID = '') {
        if ($iAdminID != '')
            $check = array('vEmail' => $vEmail, 'iAdminID  <>' => $iAdminID);
        else
            $check = array('vEmail' => $vEmail);


        $result = $this->db->get_where($this->table, $check);

        if ($result->num_rows() >= 1)
            return 0;
        else
            return 1;
    }
    /*     * **************************************************
     * *				Role Manegement
     * ************************************************** */
    function getAdminRoleListById($admin_role) {
        $result = $this->db->get_where($this->role_tbl, array('admin_role' => $admin_role));

        if ($result->num_rows() > 0)
            return $result->result_array();
        else
            return '';
    }
    function changeAdminRoladmin_status($iRoleId) {
        //$updateData = array('admin_status' => 'IF (admin_status = "Active", "Inactive","Active")');
        //$query = $this->db->update($this->table,$updateData, array('admin_role ' => $admin_role));
        $query = $this->db->query("UPDATE $this->role_tbl SET admin_status = IF (admin_status = 'Active', 'Inactive','Active') WHERE iRoleId = $iRoleId");

        if ($this->db->affected_rows() > 0)
            return $query;
        else
            return '';
    }
    function removeAdminRole($iRoleId) {
        $query = $this->db->delete($this->role_tbl, array('iRoleId' => $iRoleId));

        if ($this->db->affected_rows() > 0)
            return $query;
        else
            return '';
    }
    function getRoleDataById($iRoleId, $admin_role) {
        $result = $this->db->get_where($this->role_tbl, array('admin_role' => $admin_role, 'iRoleId' => $iRoleId));

        if ($result->num_rows() > 0)
            return $result->row_array();
        else
            return '';
    }
    function checkAdminRoleAvailable($vRoleName, $admin_role, $iRoleId = '') {
        if ($iRoleId != '')
            $check = array('vRoleName' => $vRoleName, 'admin_role' => $admin_role, 'iRoleId <>' => $iRoleId);
        else
            $check = array('vRoleName' => $vRoleName, 'admin_role' => $admin_role);


        $result = $this->db->get_where($this->role_tbl, $check);
        if ($result->num_rows() >= 1)
            return 0;
        else
            return 1;
    }
    function addRole($postData) {

        extract($postData);

        $data = array('vRoleName' => $vRoleName,
            'admin_role' => $admin_role,
            'admin_status' => $admin_status
        );

        $query = $this->db->insert($this->role_tbl, $data);

        if ($this->db->affected_rows() > 0)
            return $query;
        else
            return '';
    }
    function editRole($postData) {
        extract($postData);

        $updateData = array('vRoleName' => $vRoleName,
            'admin_status' => $admin_status
        );

        $query = $this->db->update($this->role_tbl, $updateData, array('iRoleId ' => $iRoleId));

        if ($this->db->affected_rows() > 0)
            return $query;
        else
            return '';
    }
    // **********************************************************************
    // Activation  Mail
    // **********************************************************************
    function sendActivationMailToAdmin($admin_id, $admin_pwd) {
        $query = $this->db->get_where($this->table, array('admin_id' => $admin_id));
        $row = $query->row();

        $this->load->library('email');
        $this->load->library('encrypt');
        $this->email->set_mailtype("html");

        $encrypted_id = $this->encrypt->encode($row->admin_email);

        $subject = "Your account has been created.";
        $data = array(
            'sitelink' => BASEURL . "login/",
            'acvtivation_link' => BASEURL . "confirmation/index/" . $encrypted_id,
            'email' => $row->admin_email,
            'subject' => $subject,
            'password' => $admin_pwd
        );

        $this->load->view('email/company_activation_view', $data);
    }
    // **********************************************************************
    // Activation Account
    // **********************************************************************
    function activateAccount($admin_email, $admin_pwd) {
        $updateData = array('admin_status' => 'Active', 'admin_pwd' => md5($admin_pwd));
        $query = $this->db->update($this->table, $updateData, array('admin_email' => $admin_email));
        if ($this->db->affected_rows() > 0)
            return 1;
        else
            return 0;
    }
    function checkAccountActivate($admin_email) {
        $checkData = array('admin_status' => 'Active', 'admin_email' => $admin_email);
        $query = $this->db->get_where($this->table, $checkData);
        if ($query->num_rows() == 0)
            return 1;
        else
            return 0;
    }
    function get_result() {

        $this->db->select('iAdminID,vFirstName,vLastName,vEmail');

        ///$this->db->like('table.field',$this->input->post('sSearch'));
        //$this->db->where('table.field2',$this->input->post('field2'));

        $this->db->limit(
                $this->input->post('iDisplayLength'), $this->input->post('iDisplayStart')
        );

        $query = $this->db->get('tbl_admin');

        //echo $this->db->last_query();exit;

        return $query->result_array();
    }

    // SEND FORGOT PASSWORD
    public function __adminForgotPassword($requestData = array())
    {
        extract($requestData);
        ##############################################################################################
        //Body
        ##############################################################################################
        $html = '<table width="98%" cellspacing="0" cellpadding="0" border="0">
            <tbody>
                <tr>
                    <td align="left" style="font-family:verdana;font-size:16px;line-height:1.3em;text-align:left;padding:15px;background: #cccccc;">
                        <p style="color:#CDB380;font-size:14px;letter-spacing: 5.5px; line-height: 2;font-weight:bold;margin:0">
                            <img src="' . IMAGE_URL . 'images/common/logo_new.png" alt="litty" height="80px" width="80px">
                        </p>
                    </td>
                </tr>
                <tr style="background:#E6E6E6;">
                    <td valign="top" align="left" style="font-family:verdana;font-size:16px;line-height:1.3em;text-align:left;padding:15px">
                        <table  width="100%">
                            <tr style="background:#FFFFFF;border-radius:5px;">
                                <td style="font-family:verdana;font-size:13px;line-height:1.3em;text-align:left;padding:15px;">
                                    <h1 style="font-family:verdana;color:#424242;font-size:28px;line-height:normal;letter-spacing:-1px">    
                                                                        Dear User,
                                    </h1>
                                    <p style="color:#ADADAD">
                                        Your Password Request is Accepted.
                                    </p>
                                    <p> 
                                        <a style="color:#000;text-decoration:none;font-family:Calibri;font-size:20px;line-height:135%;text-align: center;" href="' . $link . '" target="_blank">RESET PASSWORD</a>
                                    </p>
                                    <hr style="margin-top:30px;border-top-color:#ccc;border-top-width:1px;border-style:solid none none">
                                    <p>
                                        Thanks & regards,
                                        <br>
                                        litty Team.
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>';
       
        ##############################################################################################
        //SEND MAIL
        ##############################################################################################

        // $this->email->set_newline("\r\n");
        $this->email->set_mailtype("html");
        $this->email->from('admin@litty.com', 'litty');
        $this->email->to($email);
        $this->email->subject($subject);
        $this->email->message($html);
        $send_mail = $this->email->send();

        if ($send_mail) {
            // mprd($this->email->print_debugger());
            return 1;
        } else {
            // mprd($this->email->print_debugger());
            return 0;
        }
    }
}
?>