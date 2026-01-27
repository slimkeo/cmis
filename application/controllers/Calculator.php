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

class Calculator extends CI_Controller
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

    
    public function calculateCompoundInterest() {

        $principal = $_POST["amount"];
        $plan = $_POST["plan"];
        // Convert the rate from percentage to decimal and monthly rate 
        $time=$this->db->get_where('plan', array('id' => $plan))->row()->months;
        $rate=$this->db->get_where('plan', array('id' => $plan))->row()->rate;

        // Calculating compound interest
        $compound_interest = ($principal *($rate / 100))+$principal;
        //$compound_interest = $principal * pow((1 + ($rate / 100)), $time);
        $monthly_pay=$compound_interest/$time;
        $date = new DateTime(date("Y-m-d")); // Y-m-d
        $date->add(new DateInterval('P30D'));
        $effective_date= $date->format('Y-m-d');

        echo json_encode(array('unearned_interest' =>number_format($principal, 2, '.', ''),'total_balance' => number_format($compound_interest, 2, '.', ''),'monthly_pay' => number_format($monthly_pay,2,'.',''),'effective_date' => $effective_date));
      }

}

?>