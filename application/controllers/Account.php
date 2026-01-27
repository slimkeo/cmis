<?php
if (!defined('BASEPATH'))
exit('No direct script access allowed');
/*  
*  @author : Sicelo Thabani Hlanze
*  date    : 15 January, 2023
*  Lula Parking Management system
*  https://lulaparking.com/user/carlos
*  Mbabane, Swaziland
*  carlos@lulaparking.com
*/

class Account extends CI_Controller
{
    
    
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

    public function get_accounts() {

        $client_id = $_POST["client_id"];

        $loan_list=$this->db->get_where('loan', array('client_id' => $client_id))->result_array();
        $account_list=$this->db->get_where('account', array('client_id' => $client_id))->result_array();

         // Return data as JSON
    echo json_encode(array(
        'loan_list' => $loan_list,
        'account_list' => $account_list
    ));
    }



}