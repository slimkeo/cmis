<?php
 
class Csv extends CI_Controller {
 
    function __construct() {
        parent::__construct();
        $this->load->model('csv_model');
        $this->load->library('csvimport');
    }
 
    function index() {
        $data['collections'] = $this->csv_model->get_addressbook();
        $this->load->view('csv_import', $data);
    }
 
    function importcsv() {
        $data['collections'] = $this->csv_model->get_addressbook();
        $data['error'] = '';    //initialize image upload error array to empty
 
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'csv';
        $config['max_size'] = '1000';
 
        $this->load->library('upload', $config);
 
        // If upload failed, display error
        if (!$this->upload->do_upload()) {
            $data['error'] = $this->upload->display_errors();
            $this->load->view('csv_import', $data);
        } else {
            $file_data = $this->upload->data();
            $file_path =  './uploads/'.$file_data['file_name'];
 
            if ($this->csvimport->get_array($file_path)) {
                $csv_array = $this->csvimport->get_array($file_path);
                $insert_count = 0;
                
                foreach ($csv_array as $row) {
                    // Validate required fields are not empty
                    if (empty($row['date']) || empty($row['street'])) {
                        continue; // Skip invalid rows
                    }
                    
                    $insert_data = array(
                        'date'=>$row['date'],
                        'street'=>$row['street'],
                        'marshal'=>isset($row['marshal']) ? $row['marshal'] : '',
                        'broughtback'=>isset($row['broughtback']) ? $row['broughtback'] : '',
                        'systemcash'=>isset($row['systemcash']) ? $row['systemcash'] : '',
                        'actual'=>isset($row['actual']) ? $row['actual'] : '',
                        'varience'=>isset($row['varience']) ? $row['varience'] : '',
                    );
                    $this->csv_model->insert_csv($insert_data);
                    $insert_count++;
                }
                
                if ($insert_count > 0) {
                    $this->session->set_flashdata('success', $insert_count . ' records imported successfully');
                    redirect(base_url().'csv');
                } else {
                    $data['error'] = "No valid records found in CSV file";
                    $this->load->view('csv_import', $data);
                }
            } else {
                $data['error'] = "Invalid CSV file or file is empty";
                $this->load->view('csv_import', $data);
            }
        } 
 
}
/*END OF FILE*/