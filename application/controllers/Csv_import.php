<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Csv_import extends CI_Controller {
 
 public function __construct()
 {
  parent::__construct();
  $this->load->model('csv_import_model');
  $this->load->library('csvimport');
 }

 function index()
 {
  $this->load->view('csv_import');
 }

 function load_data()
 {
  $result = $this->csv_import_model->select();
  $output = '
   <h3 align="center">Imported User Details from CSV File</h3>
        <div class="table-responsive">
         <table class="table table-bordered table-striped">
          <tr>
           <th>#</th>
           
           <th>Street</th>
           <th>Marshal</th>
           <th>Brought Back</th>
		   <th>System Cash</th>
           <th>Actual</th>
           <th>Varience</th>
          </tr>
  ';
  $count = 0;
  if($result->num_rows() > 0)
  {
   foreach($result->result() as $row)
   {
    $count = $count + 1;
    $output .= '
    <tr>
     <td>'.$count.'</td>     
     <td>'.$row->street.'</td>
     <td>'.$row->marshal.'</td>
     <td>'.$row->broughtback.'</td>
	 <td>'.$row->systemcash.'</td>
     <td>'.$row->actual.'</td>
     <td>'.$row->varience.'</td>
    </tr>
    ';
   }
  }
  else
  {
   $output .= '
   <tr>
       <td colspan="5" align="center">Data not Available</td>
      </tr>
   ';
  }
  $output .= '</table></div>';
  echo $output;
 }

 function import()
 {
  $file_data = $this->csvimport->get_array($_FILES["csv_file"]["tmp_name"]);
  foreach($file_data as $row)
  {
   $data[] = array(
    	  'date' 		=> $row["date"],
          'street'  	=> $row["street"],
          'marshal'   	=> $row["marshal"],
          'broughtback' => $row["broughtback"],
		  'systemcash'  => $row["systemcash"],
          'actual'   	=> $row["actual"],
          'varience'    => $row["varience"]
   );
  }
  $this->csv_import_model->insert($data);
 }
 
  
}