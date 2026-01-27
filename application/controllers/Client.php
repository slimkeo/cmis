<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*  
 *  @author : Sicelo Thabani Hlanze
 *  date    : 15 January, 2023
 */

class Client extends CI_Controller
{
    
    
	function __construct()
	{
		parent::__construct();
		$this->load->database();
        $this->load->library('session');
        $this->load->library('phpqrcode/qrlib');
		
       /*cache control*/
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		
    }
    
    /***default functin, redirects to login page if no admin logged in yet***/
    public function index()
    {

        //if($this->pcode_validation($this->db->get_where('settings' , array('type' =>'purchase_code'))->row()->description) == TRUE) {}
        if ($this->session->userdata('client_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');
        if ($this->session->userdata('client_login') == 1)
            redirect(base_url() . 'index.php?client/dashboard', 'refresh');
    }

    /***ADMIN DASHBOARD***/
    function dashboard($year='')
    {
        if ($this->session->userdata('client_login') != 1)
            redirect(base_url(), 'refresh');
            

        $page_data['page_name']  = 'dashboard';
        $page_data['year']  = $year;      
        $page_data['page_title'] = get_phrase('client_dashboard');
        $this->load->view('backend/index', $page_data);
    }
    
        /***ADMIN DASHBOARD***/
    function daterangestatement($year='')
    {
        if ($this->session->userdata('client_login') != 1)
            redirect(base_url(), 'refresh');
            

        $page_data['page_name']  = 'dashboard';
        $page_data['year']  = $year;      
        $page_data['page_title'] = get_phrase('daterange_statement');
        $this->load->view('backend/index', $page_data);
    }

       /******MANAGE OWN PROFILE AND CHANGE PASSWORD***/
function manage_profile($param1 = '', $param2 = '', $param3 = '')
{
    if ($this->session->userdata('client_login') != 1)
        redirect(base_url() . 'index.php?login', 'refresh');

    if ($param1 == 'update_profile_info') {
        $data['national_id']    = $this->input->post('national_id');
        $data['fullname']       = $this->input->post('fullname');
        $data['lastname']       = $this->input->post('lastname');
        $data['contact']        = $this->input->post('contact');
        $data['dob']            = $this->input->post('dob');
        $data['email']          = $this->input->post('email');
        $data['gender']         = $this->input->post('gender');
        $data['address']        = $this->input->post('address');
        $data['town']           = $this->input->post('town');
        $data['organization']   = $this->input->post('organization');
        $data['org_contact']    = $this->input->post('org_contact');
        $data['salary']         = $this->input->post('salary');

        $current_user_id = $this->session->userdata('client_id');

        // Ensure email is unique
        $this->db->where('email', $data['email']);
        $this->db->where('id !=', $current_user_id);
        $query = $this->db->get('client');

        if ($query->num_rows() > 0) {
            $this->session->set_flashdata('error_message', 'The email is already in use by another user.');
            redirect(base_url() . 'index.php?client/manage_profile/', 'refresh');
        } else {
            $this->db->where('id', $current_user_id);
            $this->db->update('client', $data);
            $this->session->set_flashdata('flash_message', 'Profile updated successfully.');
            redirect(base_url() . 'index.php?client/manage_profile/', 'refresh');
        }
    }

    if ($param1 == 'update_password') {
        $current_password_input = sha1($this->input->post('current_password'));
        $new_password = sha1($this->input->post('new_password'));
        $confirm_new_password = sha1($this->input->post('confirm_new_password'));

        $current_password = $this->db->get_where('client', array(
            'id' => $this->session->userdata('client_id')
        ))->row()->password;

        if ($current_password == $current_password_input && $new_password == $confirm_new_password) {
            $this->db->where('id', $this->session->userdata('client_id'));
            $this->db->update('client', array('password' => $new_password));
            $this->session->set_flashdata('flash_message', 'Password updated successfully.');
        } else {
            $this->session->set_flashdata('flash_message_error', 'Password mismatch.');
        }
        redirect(base_url() . 'index.php?client/manage_profile/', 'refresh');
    }

    $page_data['page_name']  = 'manage_profile';
    $page_data['page_title'] = 'Manage Profile';
    $page_data['edit_data']  = $this->db->get_where('client', array('id' => $this->session->userdata('login_user_id')))->result_array();
    $this->load->view('backend/index', $page_data);
}

        /***ADMIN DASHBOARD***/
    function myloans($year='')
    {
        if ($this->session->userdata('client_login') != 1)
            redirect(base_url(), 'refresh');
            

        $page_data['page_name']  = 'myloans';   
        $page_data['myloans']   = $this->db->get_where('loan', array('client_id' => $this->session->userdata('login_user_id')))->result_array();
        $page_data['page_title'] = get_phrase('my_loans');
        $this->load->view('backend/index', $page_data);
    } 

            /***ADMIN DASHBOARD***/
    function bymobile($year='')
    {
        if ($this->session->userdata('client_login') != 1)
            redirect(base_url(), 'refresh');
            

        $page_data['page_name']  = 'bymobile';     
        $page_data['page_title'] = get_phrase('by_mobile');
        $this->load->view('backend/index', $page_data);
    } 

             /***ADMIN DASHBOARD***/
    function byaccount($year='')
    {
        if ($this->session->userdata('client_login') != 1)
            redirect(base_url(), 'refresh');
            

        $page_data['page_name']  = 'byaccount';     
        $page_data['page_title'] = get_phrase('by_account');
        $this->load->view('backend/index', $page_data);
    }      

            /***CLIENT DETAILS***/
    function client_details($param1='',$param2='',$param3='')
    {
        if ($this->session->userdata('client_login') != 1)
            redirect(base_url(), 'refresh');
            
        if ($param1 == 'do_update') {
            $data['national_id']        = $this->input->post('national_id');
            $data['fullname']        = $this->input->post('fullname');
            $data['lastname']        = $this->input->post('lastname');
            $data['contact']        = $this->input->post('contact');
            $data['address']       = $this->input->post('address');
            $data['town']       = $this->input->post('town');
            $data['organization']       = $this->input->post('           ');
            $data['org_contact']        = $this->input->post('org_contact');
            $data['gender']        = $this->input->post('gender');
            $data['salary']        = $this->input->post('salary');
            $data['status']       = $this->input->post('status');
            
            $this->db->where('id', $param2);
            $this->db->update('client', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
          //  redirect(base_url() . 'index.php?admin/client', 'refresh');
        }





        $page_data['page_name']  = 'client_details';   
        $page_data['page_title'] = get_phrase('client_detail');
        $this->load->view('backend/index', $page_data);
    } 
    
    /*****SITE/SYSTEM SETTINGS*********/
    function system_settings($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('client_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');
        
        if ($param1 == 'do_update') {
        
            $data['description'] = $this->input->post('system_name');
            $this->db->where('type' , 'system_name');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('system_title');
            $this->db->where('type' , 'system_title');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('address');
            $this->db->where('type' , 'address');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('phone');
            $this->db->where('type' , 'phone');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('paypal_email');
            $this->db->where('type' , 'paypal_email');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('currency');
            $this->db->where('type' , 'currency');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('footer_text');
            $this->db->where('type' , 'footer_text');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('system_email');
            $this->db->where('type' , 'system_email');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('footer_text');
            $this->db->where('type' , 'footer_text');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('system_name');
            $this->db->where('type' , 'system_name');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('language');
            $this->db->where('type' , 'language');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('running_year');
            $this->db->where('type' , 'running_year');
            $this->db->update('settings' , $data);
            
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated')); 
            redirect(base_url() . 'index.php?admin/system_settings/', 'refresh');
        }
        if ($param1 == 'upload_logo') {
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/logo.png');
            $this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
            redirect(base_url() . 'index.php?admin/system_settings/', 'refresh');
        }
        if ($param1 == 'change_skin') {
            
            $data['description'] = $this->input->post('skin_colour');
            $this->db->where('type' , 'skin_colour');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('borders_style');
            $this->db->where('type' , 'borders_style');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('header_colour');
            $this->db->where('type' , 'header_colour');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('sidebar_colour');
            $this->db->where('type' , 'sidebar_colour');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('sidebar_size');
            $this->db->where('type' , 'sidebar_size');
            $this->db->update('settings' , $data);

            $this->session->set_flashdata('flash_message' , get_phrase('theme_selected')); 
            redirect(base_url() . 'index.php?admin/system_settings/', 'refresh'); 
            
        }

        $page_data['page_name']  = 'system_settings';
        $page_data['page_title'] = get_phrase('system_settings');
        $page_data['settings']   = $this->db->get('settings')->result_array();
        $this->load->view('backend/index', $page_data);
    }

    function daterange($param1="",$param2=""){
        if($param1=="search"){
            $startdate_dmy=$this->input->post('startdate');
            $enddate_dmy=$this->input->post('enddate');

            $timestamp1 = strtotime($startdate_dmy);
            $timestamp2 = strtotime($enddate_dmy);

            $startdate = date("Y-m-d", $timestamp1);
            $enddate = date("Y-m-d", $timestamp2);
            redirect(base_url() . 'index.php?admin/daterangereport/'.$startdate.'/'.$enddate, 'refresh');
        }
        if($param1=="by_user"){
            $startdate_dmy=$this->input->post('startdate');
            $enddate_dmy=$this->input->post('enddate');
            $timestamp1 = strtotime($startdate_dmy);
            $timestamp2 = strtotime($enddate_dmy);

            $startdate = date("Y-m-d", $timestamp1);
            $enddate = date("Y-m-d", $timestamp2);
            redirect(base_url() . 'index.php?client/userreport/'.$param2.'/'.$startdate.'/'.$enddate, 'refresh');
        }

        $page_data['page_name']  = 'daterange';
        $page_data['page_title'] = get_phrase('daterange');
        $this->load->view('backend/index', $page_data);
    }
        public function client_statement($param1) {
            if ($this->session->userdata('client_login') != 1)
                redirect(base_url(), 'refresh');

            $account=$this->input->post('account');
            $startdate_dmy=$this->input->post('startdate');
            $enddate_dmy=$this->input->post('enddate');

            $timestamp1 = strtotime($startdate_dmy);
            $timestamp2 = strtotime($enddate_dmy);

            $startdate = date("Y-m-d", $timestamp1);
            $enddate = date("Y-m-d", $timestamp2);
            redirect(base_url() . 'index.php?client/accountdaterangereport/'.$startdate.'/'.$enddate.'/'.$account, 'refresh'); 
    }
      function accountdaterangereport($param1="",$param2="",$param3=""){
            if ($this->session->userdata('client_login') != 1)
                redirect(base_url(), 'refresh');



        $page_data['page_name']  = 'clientdaterangereport';
        $page_data['account']  = $param3;
        $page_data['startdate']  = $param1;
        $page_data['enddated']  = $param2;
        $page_data['page_title'] = get_phrase('daterange_report').' '.$param3.':'.$param1.'-'.$param2;
        $this->load->view('backend/index', $page_data);
    }    

public function search_client_by_phone() {
    $phone = $this->input->post('phone');

    $client = $this->db->get_where('client', ['contact' => $phone])->row();

    if ($client) {
        // Get primary account
        $account = $this->db->get_where('account', [
            'client_id' => $this->session->userdata('client_id'),
            'isPrimary' => 1
        ])->row();

        echo json_encode([
            'status' => 'success',
            'client_id' => $client->national_id,
            'fullname' => $client->fullname,
            'account_id' => $account->id,
            'lastname' => $client->lastname,
            'account_balance' => $account ? number_format($account->balance, 2) : '0.00'
        ]);
    } else {
        echo json_encode(['status' => 'error']);
    }
}


public function search_client_by_account() {
    $account_id = $this->input->post('account_id');


    $sender_client_id = $this->session->userdata('client_id');
        // Fetch sender primary account
    $sender_account = $this->db->get_where('account', [
        'client_id' => $sender_client_id,
        'isPrimary' => 1
    ])->row();

    $account = $this->db->get_where('account', ['id' => $account_id])->row();

    if ($account) {
        // Get primary account
        $client = $this->db->get_where('client', [
            'id' => $account->client_id
        ])->row();

        echo json_encode([
            'status' => 'success',
            'client_id' => $client->national_id,
            'fullname' => $client->fullname,
            'account_id' => $account->id,
            'lastname' => $client->lastname,
             'account_balance' => $account ? number_format($sender_account->balance, 2) : '0.00'
        ]);
    } else {
        echo json_encode(['status' => 'error']);
    }
}


public function send_byMobile_to_primary_account()
{
    $receiver_account = $this->input->post('account_id'); 
    $amount = $this->input->post('amount');

    // Validate amount
    if (!is_numeric($amount) || $amount <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid amount']);
        return;
    }

    $sender_client_id = $this->session->userdata('client_id');

    // Fetch sender primary account
    $sender_account = $this->db->get_where('account', [
        'client_id' => $sender_client_id,
        'isPrimary' => 1
    ])->row();

    // Fetch recieved primary account
    $receiver_account = $this->db->get_where('account', [
        'id' => $receiver_account,
        'isPrimary' => 1
    ])->row();

    if (!$sender_account || $sender_account->balance < $amount) {
        echo json_encode(['status' => 'error', 'message' => 'Insufficient funds or sender account not found']);
        return;
    }


    if (!$receiver_account) {
        echo json_encode(['status' => 'error', 'message' => 'Receiver account not found']);
        return;
    }

    $new_sender_balance = $sender_account->balance - $amount;
    $new_receiver_balance = $receiver_account->balance + $amount;


   // Begin transaction
    $this->db->trans_start();

    // Deduct from sender
    $this->db->where('id', $sender_account->id);
    $this->db->update('account', [
        'balance' => $new_sender_balance,
        'last_transaction' => date('Y-m-d H:i:s')
    ]);

    // Add to receiver
    $this->db->where('id', $receiver_account->id);
    $this->db->update('account', [
        'balance' => $new_receiver_balance,
        'last_transaction' => date('Y-m-d H:i:s')
    ]);

    $this->db->trans_complete();

    if ($this->db->trans_status() === TRUE) {
        echo json_encode([
            'status' => 'success',
            'new_balance' => number_format($new_sender_balance, 2)
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Transaction failed']);
    }
}

public function send_byAccount_to_primary_account()
{
    $receiver_account = $this->input->post('account_id'); 
    $amount = $this->input->post('amount');

    // Validate amount
    if (!is_numeric($amount) || $amount <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid amount']);
        return;
    }

    $sender_client_id = $this->session->userdata('client_id');

    // Fetch sender primary account
    $sender_account = $this->db->get_where('account', [
        'client_id' => $sender_client_id,
        'isPrimary' => 1
    ])->row();

    // Fetch recieved primary account
    $receiver_account = $this->db->get_where('account', [
        'id' => $receiver_account,
        'isPrimary' => 1
    ])->row();

    if (!$sender_account || $sender_account->balance < $amount) {
        echo json_encode(['status' => 'error', 'message' => 'Insufficient funds or sender account not found']);
        return;
    }


    if (!$receiver_account) {
        echo json_encode(['status' => 'error', 'message' => 'Receiver account not found']);
        return;
    }

    $new_sender_balance = $sender_account->balance - $amount;
    $new_receiver_balance = $receiver_account->balance + $amount;


   // Begin transaction
    $this->db->trans_start();

    // Deduct from sender
    $this->db->where('id', $sender_account->id);
    $this->db->update('account', [
        'balance' => $new_sender_balance,
        'last_transaction' => date('Y-m-d H:i:s')
    ]);

    // Add to receiver
    $this->db->where('id', $receiver_account->id);
    $this->db->update('account', [
        'balance' => $new_receiver_balance,
        'last_transaction' => date('Y-m-d H:i:s')
    ]);

    $this->db->trans_complete();

    if ($this->db->trans_status() === TRUE) {
        echo json_encode([
            'status' => 'success',
            'new_balance' => number_format($new_sender_balance, 2)
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Transaction failed']);
    }
}


}     

