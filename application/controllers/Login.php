<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('crud_model');
        $this->load->database();
        $this->load->library('session');
        /* cache control */
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 2607 Jul 2023 05:00:00 GMT");
    }

    //Default function, redirects to logged in user area
    public function index() {

        if ($this->session->userdata('user_login') == 1)
            redirect(base_url() . 'index.php?burial/dashboard', 'refresh');

         if ($this->session->userdata('account_login') == 1)
             redirect(base_url() . 'index.php?client', 'refresh');

        $this->load->view('backend/login');
    }

    //Ajax login function 
    function ajax_login() {
        $response = array();

        //Recieving post input of email, password from ajax request
        $email = $_POST["email"];
        $password = sha1($_POST["password"]);
        $response['submitted_data'] = $_POST;

        //Validating login
        $login_status = $this->validate_login($email, $password);
        $response['login_status'] = $login_status;
        if ($login_status == 'success') {
            $response['redirect_url'] = '';

            $data['last_login']        = date("Y-m-d H:i:s");

            $this->db->where('id', $this->session->userdata('user_id'));
            $this->db->update('admin',$data);
        }

        //Replying ajax request with validation response
        echo json_encode($response);
    }

    //Validating login from ajax request
    //Validating login from ajax request
    function validate_login($email = '', $password = '') {
        $credential = array('email' => $email, 'password' => $password);


        // Checking login credential for admin 
        $query = $this->db->get_where('admin', $credential);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $this->session->set_userdata('user_login', '1');
            $this->session->set_userdata('level',$row->level );
            $this->session->set_userdata('user_id', $row->id);
            $this->session->set_userdata('name', $row->name);
            // user_type 1 admin 2 clerk and 3 accounts
            $this->session->set_userdata('user_type',$row->level);
            $this->session->set_userdata('login_type', 'burial');
            return 'success';
        }

        
              // Checking login credential for parent `id`, `national_id`, `fullname`, `lastname`, `contact`, `dob`, `email`, `password`, `gender`, `address`, `town`, `organization`, `org_contact`, `salary`, `status`, `createdate`, `timestamp`, `file`

         $query = $this->db->get_where('client', $credential);
         if ($query->num_rows() > 0) {
             $row = $query->row();
             $this->session->set_userdata('client_login', '1');
             $this->session->set_userdata('client_id', $row->id);
             $this->session->set_userdata('login_user_id', $row->id);
             $this->session->set_userdata('name', $row->fullname);
             $this->session->set_userdata('login_type', 'client');
             return 'success';
         }

        return 'invalid';
    }

    /*     * *DEFAULT NOR FOUND PAGE**** */

    function four_zero_four() {
        $this->load->view('four_zero_four');
    }

    // PASSWORD RESET BY EMAIL
    function forgot_password()
    {
        $this->load->view('backend/forgot_password');
    }

    function ajax_forgot_password()
    {
        $resp                   = array();
        $resp['status']         = 'false';
        $email                  = $_POST["email"];
        $reset_account_type     = '';
        //resetting user password here
        $new_password           =   substr( md5( rand(100000000,20000000000) ) , 0,7);

        // Checking credential for admin
        $query = $this->db->get_where('admin' , array('email' => $email));
        if ($query->num_rows() > 0) 
        {
            $reset_account_type     =   'admin';
            $this->db->where('email' , $email);
            $this->db->update('admin' , array('password' => sha1($new_password)));
            $resp['status']         = 'true';
        }
        // Checking credential for student
        $query = $this->db->get_where('supervisor' , array('email' => $email));
        if ($query->num_rows() > 0) 
        {
            $reset_account_type     =   'supervisor';
            $this->db->where('email' , $email);
            $this->db->update('supervisor' , array('password' => sha1($new_password)));
            $resp['status']         = 'true';
        }
        // Checking credential for administrator
        $query = $this->db->get_where('administrator' , array('email' => $email));
        if ($query->num_rows() > 0) 
        {
            $reset_account_type     =   'administrator';
            $this->db->where('email' , $email);
            $this->db->update('administrator' , array('password' => sha1($new_password)));
            $resp['status']         = 'true';
        }
        // Checking credential for parent
        $query = $this->db->get_where('municipality' , array('email' => $email));
        if ($query->num_rows() > 0) 
        {
            $reset_account_type     =   'municipality';
            $this->db->where('email' , $email);
            $this->db->update('parent' , array('password' => sha1($new_password)));
            $resp['status']         = 'true';
        }

        // send new password to user email
        if ($reset_account_type !== '' ){
         $this->email_model->password_reset_email($new_password , $reset_account_type , $email);
        }
        

        $resp['submitted_data'] = $_POST;

        echo json_encode($resp);
    }

    /*     * *****LOGOUT FUNCTION ****** */

    function logout() {
        $this->session->sess_destroy();
        $this->session->set_flashdata('logout_notification', 'logged_out');
        redirect(base_url(), 'refresh');
    }

}
