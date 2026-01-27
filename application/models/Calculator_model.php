<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Calculator_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }


    public function calculateCompoundInterest($principal, $plan) {
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

        return array('unearned_interest' =>number_format($principal, 2, '.', ''),'total_balance' => number_format($compound_interest, 2, '.', ''),'monthly_pay' => number_format($monthly_pay,2,'.',''),'effective_date' => $effective_date);
      }
}

?>