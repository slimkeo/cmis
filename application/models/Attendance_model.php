<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance_model extends CI_Model {

    protected $table = 'attendance';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Insert attendance only if member_code not already present.
     * Returns insert_id or false when already exists.
     */
    public function insert_if_not_exists($row)
    {
        // simple check: member_code unique? (you can adjust logic)
        $exists = $this->db->get_where($this->table, ['momo' => $row['momo']])->num_rows();
        if ($exists > 0) {
            return false;
        }

        $this->db->insert($this->table, $row);
        return $this->db->insert_id();
    }



    public function otp_exists($otp)
    {
        $this->db->where('otp', $otp);
        return $this->db->count_all_results($this->table) > 0;
    }

    public function count_sent()
    {
        // counts rows with non-null otp (or change criteria)
        $this->db->where('otp IS NOT NULL', null, false);
        return $this->db->count_all_results($this->table);
    }

	public function add_manual_attendee($data)
	{
	    // Prevent duplicate national ID or passbook
	    $exists = $this->db
	        ->where('momo', $data['momo'])
	        ->get('attendance')
	        ->num_rows();

	    if ($exists > 0) {
	        return [
	            'success' => false,
	            'message' => 'Number already exists.'
	        ];
	    }

	    $data['createdate'] = date('Y-m-d H:i:s');
	    $data['status']     = 1;

	    $this->db->insert('attendance', $data);

	    return [
	        'success' => true,
	        'id'      => $this->db->insert_id()
	    ];
	}    
}