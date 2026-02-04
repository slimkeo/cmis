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
  
  // Check if CSV parsing was successful
  if ($file_data === false) {
      echo json_encode(array('status' => 'error', 'message' => 'Invalid CSV file or file is empty'));
      return;
  }
  
  // Check if array is empty
  if (empty($file_data)) {
      echo json_encode(array('status' => 'error', 'message' => 'No valid records found in CSV'));
      return;
  }
  
  $data = array();
  $insert_count = 0;
  
  foreach($file_data as $row)
  {
      // Validate required fields
      if (empty($row["date"]) && empty($row["street"])) {
          continue; // Skip rows with no required data
      }
      
      $data[] = array(
           'date'        => isset($row["date"]) ? $row["date"] : '',
           'street'      => isset($row["street"]) ? $row["street"] : '',
           'marshal'     => isset($row["marshal"]) ? $row["marshal"] : '',
           'broughtback' => isset($row["broughtback"]) ? $row["broughtback"] : '',
           'systemcash'  => isset($row["systemcash"]) ? $row["systemcash"] : '',
           'actual'      => isset($row["actual"]) ? $row["actual"] : '',
           'varience'    => isset($row["varience"]) ? $row["varience"] : ''
      );
  }
  
  if (!empty($data)) {
      $this->csv_import_model->insert($data);
      echo json_encode(array('status' => 'success', 'message' => count($data) . ' records imported successfully'));
  } else {
      echo json_encode(array('status' => 'error', 'message' => 'No valid records to insert'));
  }
 }
 
  
}