<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Burial extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->library('phpqrcode/qrlib');
        $this->load->model('Member_model');
        $this->load->model('Attendance_model');
        $this->load->model('Beneficiary_model');
        $this->load->model('Enum_model');
        $this->load->model('Claims_model');
        // load config for SMS (you'll create this config or set constants)
        $this->load->config('sms_config', true); // optional, see notes        
        /* Cache control */
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }

    /** DEFAULT FUNCTION **/
    public function index()
    {
        if ($this->session->userdata('user_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');

        redirect(base_url() . 'index.php?burial/dashboard', 'refresh');
    }

        /**
     * Parse dd-mm-yyyy or yyyy-mm-dd into a unix timestamp.
     * Returns false if cannot parse.
     */
     function _parse_date_to_ts($date_str)
    {
        $date_str = trim((string)$date_str);
        if ($date_str === '') return false;

        if (strpos($date_str, '-') !== false) {
            $parts = explode('-', $date_str);
            if (count($parts) === 3) {
                // yyyy-mm-dd
                if (intval($parts[0]) > 12) {
                    $ts = strtotime($date_str);
                    return $ts ?: false;
                }
                // dd-mm-yyyy
                $ts = strtotime($parts[2] . '-' . $parts[1] . '-' . $parts[0]);
                return $ts ?: false;
            }
        }

        $ts = strtotime($date_str);
        return $ts ?: false;
    }

    /** DASHBOARD **/
    function dashboard($year = '')
    {
        if ($this->session->userdata('user_login') != 1)
            redirect(base_url(), 'refresh');

        $page_data['page_name']  = 'dashboard';
        $page_data['page_title'] = "Dashboard";
        $this->load->view('backend/index', $page_data);
    }

/********** MANAGE MEMBERS ********************/
function members($param1 = '', $param2 = '', $param3 = '')
{
    if ($this->session->userdata('user_login') != 1)
        redirect('login', 'refresh');

    // CREATE MEMBER
    if ($param1 == 'create') {

        $data['idnumber']    = $this->input->post('idnumber');
        $data['passbook_no'] = $this->input->post('passbook_no');
        $data['employeeno']  = $this->input->post('employeeno');
        $data['tscno']       = $this->input->post('tscno');
        $data['surname']     = $this->input->post('surname');
        $data['name']        = $this->input->post('name');
        $data['cellnumber']  = $this->input->post('cellnumber');
        $data['dob']         = $this->input->post('dob');
        $data['gender']      = $this->input->post('gender');
        $data['resident']    = $this->input->post('resident');
        $data['schoolcode']  = $this->input->post('schoolcode');
        
        // Format cellnumber: append 268 if not present
        if (!empty($data['cellnumber']) && strpos($data['cellnumber'], '268') !== 0) {
            $data['cellnumber'] = '268' . $data['cellnumber'];
        }

        // Prevent duplicate ID number or passbook number
        $this->db->group_start()
                 ->where('idnumber', $data['idnumber'])
                 ->or_where('passbook_no', $data['passbook_no'])
                 ->or_where('cellnumber', $data['cellnumber'])
                 ->or_where('employeeno', $data['employeeno'])
                 ->group_end();

        $exists = $this->db->get('members')->num_rows();

        if ($exists > 0) {
            $this->session->set_flashdata('flash_message_error', 'Member already registered: ID Number, Phone Number, Employment No and Pass Book Duplicacy not allowed');
        } else {
            $this->db->insert('members', $data);
            $member_id = $this->db->insert_id();
            
            // Handle nominee creation (only ONE nominee allowed per member)
            $nominee_name = trim((string)$this->input->post('nominee_fullname'));
            if (!empty($nominee_name)) {
                $user_id = $this->session->userdata('user_id');
                $nominee_data = [
                    'member_id'   => $member_id,
                    'fullname'    => $nominee_name,
                    'user'        => !empty($user_id) ? $user_id : null,
                    'createdate'  => date('Y-m-d H:i:s')
                ];
                $this->db->insert('nominee', $nominee_data);
            }
            
            $this->session->set_flashdata('flash_message', 'Member added successfully');
        }

        redirect(base_url() . 'index.php?burial/members', 'refresh');
    }

    // UPDATE MEMBER
    if ($param1 == 'do_update') {

        $data['idnumber']    = $this->input->post('idnumber');
        $data['passbook_no'] = $this->input->post('passbook_no');
        $data['employeeno']  = $this->input->post('employeeno');
        $data['tscno']       = $this->input->post('tscno');
        $data['surname']     = $this->input->post('surname');
        $data['name']        = $this->input->post('name');
        $data['cellnumber']  = $this->input->post('cellnumber');
        $data['dob']         = $this->input->post('dob');
        $data['gender']      = $this->input->post('gender');
        $data['resident']    = $this->input->post('resident');
        $data['schoolcode']  = $this->input->post('schoolcode');
        
        // Format cellnumber: append 268 if not present
        if (!empty($data['cellnumber']) && strpos($data['cellnumber'], '268') !== 0) {
            $data['cellnumber'] = '268' . $data['cellnumber'];
        }

        $this->db->where('id', $param2);
        $this->db->update('members', $data);

        // --- Handle nominee (only ONE nominee per member) ---
        $nominee_name = trim((string)$this->input->post('nominee_fullname'));

        // Fetch existing nominees for this member
        $existing_nominees = $this->db->get_where('nominee', ['member_id' => $param2])->result_array();
        $primary_nominee   = null;

        if (!empty($existing_nominees)) {
            $primary_nominee = $existing_nominees[0];

            // Ensure only one nominee row remains for this member
            if (count($existing_nominees) > 1) {
                $ids_to_keep = [$primary_nominee['id']];
                $this->db->where('member_id', $param2);
                $this->db->where_not_in('id', $ids_to_keep);
                $this->db->delete('nominee');
            }
        }

        // Decide how to apply updates
        if ($nominee_name === '') {
            // If field is empty, remove existing nominee (if any)
            if ($primary_nominee) {
                $this->db->where('id', $primary_nominee['id']);
                $this->db->delete('nominee');
            }
        } else {
            // We have nominee details to save
            $nominee_data = [
                'fullname' => $nominee_name,
            ];

            if ($primary_nominee) {
                // Update existing nominee
                $this->db->where('id', $primary_nominee['id']);
                $this->db->update('nominee', $nominee_data);
            } else {
                // Create new nominee for this member
                $user_id = $this->session->userdata('user_id');
                $nominee_data['member_id']  = $param2;
                $nominee_data['user']       = !empty($user_id) ? $user_id : null;
                $nominee_data['createdate'] = date('Y-m-d H:i:s');

                $this->db->insert('nominee', $nominee_data);
            }
        }

        $this->session->set_flashdata('flash_message', 'Member updated successfully');
        redirect(base_url() . 'index.php?burial/members', 'refresh');
    }

    // DELETE MEMBER
    if ($param1 == 'delete') {
        $this->db->where('id', $param2);
        $this->db->delete('members');
        $this->session->set_flashdata('flash_message', 'Member deleted successfully');

        redirect(base_url() . 'index.php?burial/members', 'refresh');
    }

    $page_data['members'] = $this->db->get('members')->result_array();
    $page_data['page_name'] = 'members';
    $page_data['page_title'] = 'Manage Members';

    $this->load->view('backend/index', $page_data);
}

    /********** MEMBER SELECTION PAGE ********************/
    function member_selection()
    {
        if ($this->session->userdata('user_login') != 1)
            redirect(base_url(), 'refresh');

        $page_data['page_name']  = 'burial/member_selection';
        $page_data['page_title'] = 'Member Selection';
        $this->load->view('backend/burial/member_selection', $page_data);
    }

    /********** MEMBER DETAILS ********************/
    function member_details($memberid)
    {
        if ($this->session->userdata('user_login') != 1)
            redirect(base_url(), 'refresh');
 
        $this->load->model('Beneficiary_model');
        
        // Member
        $page_data['member'] = $this->db
            ->where('id', $memberid)
            ->get('members')
            ->row_array();
        
        // Beneficiaries
        $page_data['beneficiaries'] = $this->Beneficiary_model->get_by_member($memberid);
        
        // Payable summary
        $summary = $this->Beneficiary_model->get_payable_summary($memberid);
        
        $page_data['total_beneficiaries']   = $summary['total_beneficiaries'];
        $page_data['payable_beneficiaries'] = $summary['payable_beneficiaries'];
        
        // Fees
        $page_data['principal_fee'] = (float) $this->db
            ->get_where('settings', ['type' => 'principal_fee'])
            ->row()->description;

        $page_data['member_fee'] = (float) $this->db
            ->get_where('settings', ['type' => 'member_fee'])
            ->row()->description;

        // Generate months: 36 months back from today + next 12 months
        $page_data['months'] = $this->generate_month_range();
        
        $page_data['memberid']    = $memberid;
        $page_data['page_name']  = 'burial/member_details';
        $page_data['page_title'] = 'Member Details';
        $this->load->view('backend/member_details', $page_data);
    }

    /********** GENERATE MONTH RANGE ********************/
    private function generate_month_range()
    {
        $months = [];
        
        // Current date
        $today = new DateTime();
        
        // 36 months back
        $start_date = new DateTime($today->format('Y-m-d'));
        $start_date->modify('-36 months');
        
        // 12 months forward
        $end_date = new DateTime($today->format('Y-m-d'));
        $end_date->modify('+12 months');
        
        // Generate months
        $current = clone $start_date;
        while ($current <= $end_date) {
            $months[] = [
                'year' => $current->format('Y'),
                'month' => $current->format('m'),
                'label' => $current->format('F Y'),
                'value' => $current->format('Y-m')
            ];
            $current->modify('+1 month');
        }
        
        return $months;
    }

    /********** BENEFICIARIES ********************/
    function beneficiaries($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('user_login') != 1)
            redirect(base_url(), 'refresh');

        /********** ADD BENEFICIARY **********/
        if ($param2 == 'add_beneficiary') {

            $data['memberid']        = $param1;
            $data['fullname']        = $this->input->post('fullname');
            $data['gender']          = $this->input->post('gender');
            $data['dob']             = $this->input->post('dob');
            $data['status']          = $this->input->post('status');
            $data['submission_date'] = $this->input->post('submission_date');
            $data['is_spouse']       = (int) $this->input->post('is_spouse');
            $status_date_input       = $this->input->post('status_date');

            // Default values for NEW beneficiary
            $data['replaced'] = 0;
            $data['replaced_with'] = null;

            // status_date handling
            if (
                ($data['status'] === 'BENEFITTED' || $data['status'] === 'BENEFITTED - REPLACED') &&
                $status_date_input
            ) {
                $data['status_date'] = $status_date_input;
            } elseif ($data['status'] === 'REPLACEE' && $status_date_input) {
                $data['status_date'] = $status_date_input; // death certificate date
            } else {
                $data['status_date'] = date('Y-m-d');
            }

            $replaced_with_id = null;

            /********** REPLACEE VALIDATION **********/
            if ($data['status'] === 'REPLACEE' && $this->input->post('replaced_with')) {

                $replaced_with_id = $this->input->post('replaced_with');

                $old = $this->db->get_where('beneficiaries', [
                    'id' => $replaced_with_id,
                    'memberid' => $param1
                ])->row_array();

                if (!$old) {
                    $this->session->set_flashdata('flash_message_error', 'Selected beneficiary to replace was not found');
                    redirect(base_url() . 'index.php?burial/beneficiaries/' . $param1, 'refresh');
                }

                // Submission date must match replaced beneficiary
                $data['submission_date'] = $old['submission_date'];

                // If old was NOT benefitted → require death cert & 2-month rule
                $old_status = $old['status'] ?? '';
                $old_was_benefitted = in_array($old_status, ['BENEFITTED', 'BENEFITTED - REPLACED']);

                if (!$old_was_benefitted) {

                    if (!$status_date_input) {
                        $this->session->set_flashdata('flash_message_error', 'Death Certificate Date is required');
                        redirect(base_url() . 'index.php?burial/beneficiaries/' . $param1, 'refresh');
                    }

                    $death_ts = $this->_parse_date_to_ts($status_date_input);
                    if (!$death_ts) {
                        $this->session->set_flashdata('flash_message_error', 'Invalid Death Certificate Date');
                        redirect(base_url() . 'index.php?burial/beneficiaries/' . $param1, 'refresh');
                    }

                    if (time() > strtotime('+2 months', $death_ts)) {
                        $this->session->set_flashdata('flash_message_error', 'Replacement must be done within 2 months from date of death');
                        redirect(base_url() . 'index.php?burial/beneficiaries/' . $param1, 'refresh');
                    }
                }
            }

            // Prevent duplicate names
            $this->db->where('memberid', $param1);
            $this->db->where('fullname', $data['fullname']);
            if ($this->db->get('beneficiaries')->num_rows() > 0) {
                $this->session->set_flashdata('flash_message_error', 'Beneficiary already exists');
                redirect(base_url() . 'index.php?burial/beneficiaries/' . $param1, 'refresh');
            }

            /********** INSERT NEW BENEFICIARY **********/
            $this->db->insert('beneficiaries', $data);
            $new_beneficiary_id = $this->db->insert_id();

            /********** UPDATE OLD BENEFICIARY **********/
            if ($data['status'] === 'REPLACEE' && $replaced_with_id) {

                $old = $this->db->get_where('beneficiaries', [
                    'id' => $replaced_with_id,
                    'memberid' => $param1
                ])->row_array();

                if ($old) {

                    $old_status = $old['status'] ?? '';
                    $old_was_benefitted = in_array($old_status, ['BENEFITTED', 'BENEFITTED - REPLACED']);

                    $update_old = [
                        'replaced'      => 1,
                        'replaced_with' => $new_beneficiary_id
                    ];

                    if ($old_was_benefitted) {
                        $update_old['status'] = 'BENEFITTED - REPLACED';
                    } else {
                        $update_old['status'] = 'DECEASED - REPLACED';
                        $update_old['status_date'] = $status_date_input;
                    }

                    $this->db->where('id', $replaced_with_id);
                    $this->db->where('memberid', $param1);
                    $this->db->update('beneficiaries', $update_old);
                }
            }

            $this->session->set_flashdata('flash_message', 'Beneficiary added successfully');
            redirect(base_url() . 'index.php?burial/beneficiaries/' . $param1, 'refresh');
        }

        /********** ADD BATCH BENEFICIARIES **********/
        if ($param2 == 'add_batch_beneficiaries') {

            $batch_submission_date = $this->input->post('batch_submission_date');
            $batch_fullnames = $this->input->post('batch_fullname');
            $batch_dobs = $this->input->post('batch_dob');
            $batch_genders = $this->input->post('batch_gender');
            $batch_is_spouses = $this->input->post('batch_is_spouse');
            $batch_statuses = $this->input->post('batch_status');
            $batch_status_dates = $this->input->post('batch_status_date');

            $added_count = 0;
            $errors = [];

            if (is_array($batch_fullnames) && count($batch_fullnames) > 0) {
                
                for ($i = 0; $i < count($batch_fullnames); $i++) {
                    
                    $fullname = $batch_fullnames[$i] ?? '';
                    
                    // Skip empty rows
                    if (empty($fullname)) continue;
                    
                    $gender = $batch_genders[$i] ?? '';
                    $dob = $batch_dobs[$i] ?? '';
                    $is_spouse = (int) ($batch_is_spouses[$i] ?? 0);
                    $status = $batch_statuses[$i] ?? 'ACTIVE';
                    $status_date = $batch_status_dates[$i] ?? '';
                    
                    // Validate required fields
                    if (empty($gender)) {
                        $errors[] = "Row " . ($i + 1) . ": Gender is required";
                        continue;
                    }
                    
                    if (empty($status)) {
                        $errors[] = "Row " . ($i + 1) . ": Status is required";
                        continue;
                    }
                    
                    // Validate status_date for BENEFITTED and DELETED
                    if (($status === 'BENEFITTED' || $status === 'DELETED') && empty($status_date)) {
                        $errors[] = "Row " . ($i + 1) . ": Status Date is required for " . $status;
                        continue;
                    }
                    
                    // Check for duplicates
                    $this->db->where('memberid', $param1);
                    $this->db->where('fullname', $fullname);
                    if ($this->db->get('beneficiaries')->num_rows() > 0) {
                        $errors[] = "Row " . ($i + 1) . ": Beneficiary '$fullname' already exists";
                        continue;
                    }
                    
                    // Prepare beneficiary data
                    $data = [
                        'memberid' => $param1,
                        'fullname' => $fullname,
                        'gender' => $gender,
                        'dob' => $dob,
                        'is_spouse' => $is_spouse,
                        'status' => $status,
                        'submission_date' => $batch_submission_date,
                        'status_date' => !empty($status_date) ? $status_date : date('Y-m-d'),
                        'replaced' => 0,
                        'replaced_with' => null
                    ];
                    
                    // Insert beneficiary
                    if ($this->db->insert('beneficiaries', $data)) {
                        $added_count++;
                    } else {
                        $errors[] = "Row " . ($i + 1) . ": Error inserting beneficiary";
                    }
                }
            }
            
            // Set flash messages
            if ($added_count > 0) {
                $this->session->set_flashdata('flash_message', $added_count . ' beneficiar' . ($added_count > 1 ? 'ies' : 'y') . ' added successfully');
            }
            
            if (!empty($errors)) {
                $this->session->set_flashdata('flash_message_error', implode(' | ', $errors));
            }
            
            if ($added_count == 0 && empty($errors)) {
                $this->session->set_flashdata('flash_message_error', 'No valid beneficiaries to add');
            }
            
            redirect(base_url() . 'index.php?burial/beneficiaries/' . $param1, 'refresh');
        }

        /********** EDIT BENEFICIARY **********/
        if ($param2 == 'edit_beneficiary') {

            // Get current beneficiary record
            $beneficiary = $this->db->get_where('beneficiaries', [
                'id' => $param3,
                'memberid' => $param1
            ])->row_array();

            if (!$beneficiary) {
                $this->session->set_flashdata('flash_message_error', 'Beneficiary not found');
                redirect(base_url() . 'index.php?burial/beneficiaries/' . $param1, 'refresh');
            }

            $update_data['fullname']        = $this->input->post('fullname');
            $update_data['gender']          = $this->input->post('gender');
            $update_data['dob']             = $this->input->post('dob');
            $update_data['submission_date'] = $this->input->post('submission_date');
            $update_data['status']          = $this->input->post('status');
            $update_data['is_spouse']       = (int) $this->input->post('is_spouse');
            $status_date_input              = $this->input->post('status_date');
            $replaced_with_input            = $this->input->post('replaced_with');

            // Handle status_date based on status
            if (
                ($update_data['status'] === 'BENEFITTED' || $update_data['status'] === 'BENEFITTED - REPLACED') &&
                $status_date_input
            ) {
                $update_data['status_date'] = $status_date_input;
            } elseif ($update_data['status'] === 'REPLACEE' && $status_date_input) {
                $update_data['status_date'] = $status_date_input; // death certificate date
            } elseif (!in_array($update_data['status'], ['BENEFITTED', 'BENEFITTED - REPLACED', 'REPLACEE'])) {
                // Clear status_date for other statuses
                $update_data['status_date'] = null;
            }

            // Handle replace_with (only for REPLACEE status)
            if ($update_data['status'] === 'REPLACEE' && !empty($replaced_with_input)) {
                $update_data['replaced_with'] = $replaced_with_input;
            } else {
                $update_data['replaced_with'] = null;
            }

            // Validate fullname doesn't duplicate (except current record)
            $duplicate_check = $this->db
                ->where('memberid', $param1)
                ->where('fullname', $update_data['fullname'])
                ->where('id !=', $param3)
                ->get('beneficiaries');

            if ($duplicate_check->num_rows() > 0) {
                $this->session->set_flashdata('flash_message_error', 'Beneficiary with this name already exists');
                redirect(base_url() . 'index.php?burial/beneficiaries/' . $param1, 'refresh');
            }

            // Update beneficiary
            $this->db->where('id', $param3);
            $this->db->where('memberid', $param1);
            $this->db->update('beneficiaries', $update_data);

            $this->session->set_flashdata('flash_message', 'Beneficiary updated successfully');
            redirect(base_url() . 'index.php?burial/beneficiaries/' . $param1, 'refresh');
        }

        /********** DELETE BENEFICIARY **********/
        if ($param2 == 'delete_beneficiary') {

            $this->db->where('id', $param3);
            $this->db->where('memberid', $param1);
            $this->db->delete('beneficiaries');

            $this->session->set_flashdata('flash_message', 'Beneficiary deleted successfully');
            redirect(base_url() . 'index.php?burial/beneficiaries/' . $param1, 'refresh');
        }

        /********** LOAD PAGE **********/
        $page_data['memberid']   = $param1;
        $page_data['page_name']  = 'beneficiaries';
        $page_data['page_title'] = $this->db
            ->get_where('members', ['id' => $param1])
            ->row()
            ->name . ' Beneficiaries';

        $this->load->view('backend/index', $page_data);
    }


    public function get_beneficiaries($memberid = '')
    {
        $draw   = intval($this->input->post("draw"));
        $start  = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
        $search = $this->input->post("search")['value'];

        // --------------------------------------------
        // 1️⃣ Total records (no search)
        // --------------------------------------------
        $this->db->where('memberid', $memberid);
        $recordsTotal = $this->db->count_all_results("beneficiaries");

        // --------------------------------------------
        // 2️⃣ Build filtered query
        // --------------------------------------------
        $this->db->from("beneficiaries");
        $this->db->where('memberid', $memberid);

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like("fullname", $search);
            $this->db->or_like("gender", $search);
            $this->db->or_like("dob", $search);
            $this->db->or_like("submission_date", $search);
            $this->db->or_like("status", $search);
            $this->db->or_like("status_date", $search);
            $this->db->group_end();
        }

        // --------------------------------------------
        // 3️⃣ Count filtered records
        // --------------------------------------------
        $recordsFiltered = $this->db->count_all_results('', false);

        // --------------------------------------------
        // 4️⃣ Rebuild query for pagination
        // --------------------------------------------
        $this->db->from("beneficiaries");
        $this->db->where('memberid', $memberid);

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like("fullname", $search);
            $this->db->or_like("gender", $search);
            $this->db->or_like("dob", $search);
            $this->db->or_like("submission_date", $search);
            $this->db->or_like("status", $search);
            $this->db->or_like("status_date", $search);
            $this->db->group_end();
        }

        $this->db->limit($length, $start);

        // --------------------------------------------
        // 5️⃣ Fetch results
        // --------------------------------------------
        $query = $this->db->get();

        $data = [];
        $count = $start + 1;
        foreach($query->result() as $r){
            // Calculate maturity status
            $submission_date = $r->submission_date;
            
            // Handle different date formats (dd-mm-yyyy or yyyy-mm-dd)
            $submission_timestamp = false;
            if (strpos($submission_date, '-') !== false) {
                $date_parts = explode('-', $submission_date);
                if (count($date_parts) == 3 && intval($date_parts[0]) > 12) {
                    $submission_timestamp = strtotime($submission_date);
                } else {
                    $submission_timestamp = strtotime($date_parts[2] . '-' . $date_parts[1] . '-' . $date_parts[0]);
                }
            } else {
                $submission_timestamp = strtotime($submission_date);
            }
            
            $today = strtotime(date('Y-m-d'));
            $one_year_ago = strtotime('-1 year', $today);
            $is_matured = ($submission_timestamp && $submission_timestamp <= $one_year_ago);
            
            // Determine maturity status
            if ($r->status == 'BENEFITTED' || $r->status == 'BENEFITTED - REPLACED') {
                $maturity_status = 'BENEFITTED';
                $maturity_badge = 'label-danger';
                $row_class = 'danger';
            } elseif ($r->status == 'REPLACEE') {
                $maturity_status = 'Matured';
                $maturity_badge = 'label-success';
                $row_class = 'success';
            } elseif ($is_matured) {
                $maturity_status = 'Matured';
                $maturity_badge = 'label-success';
                $row_class = 'success';
            } else {
                $maturity_status = 'Waiting';
                $maturity_badge = 'label-warning';
                $row_class = 'warning';
            }

            $data[] = [
                $count++,
                $r->fullname,
                $r->gender,
                $r->dob,
                $r->submission_date,
                $r->status,
                $r->status_date,
                '<span class="label ' . $maturity_badge . '">' . $maturity_status . '</span>',
                '
                <a href="#" class="btn btn-xs btn-success" onClick="showAjaxModal(\''.base_url().'index.php?modal/popup/modal_edit_beneficiary/'.$memberid.'/'.$r->id.'\');">
                    <i class="fa fa-pencil"></i>
                </a>
                <a href="#" class="btn btn-xs btn-danger" onClick="confirm_modal(\''.base_url().'index.php?burial/beneficiaries/'.$memberid.'/delete_beneficiary/'.$r->id.'\');">
                    <i class="fa fa-trash"></i>
                </a>
                '
            ];
        }

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                "draw" => $draw,
                "recordsTotal" => $recordsTotal,
                "recordsFiltered" => $recordsFiltered,
                "data" => $data
            ]));
    }

public function get_members()
{
    $draw   = intval($this->input->post("draw"));
    $start  = intval($this->input->post("start"));
    $length = intval($this->input->post("length"));
    $search = $this->input->post("search")['value'];

    // --------------------------------------------
    // 1️⃣ Total records (no search)
    // --------------------------------------------
    $recordsTotal = $this->db->count_all("members");

    // --------------------------------------------
    // 2️⃣ Build filtered query
    // --------------------------------------------
    $this->db->from("members");

    if (!empty($search)) {
        $this->db->group_start();
        $this->db->like("idnumber", $search);
        $this->db->or_like("surname", $search);
        $this->db->or_like("name", $search);
        $this->db->or_like("cellnumber", $search);
        $this->db->or_like("passbook_no", $search);
         $this->db->or_like("employeeno", $search);
        $this->db->group_end();
    }

    // --------------------------------------------
    // 3️⃣ Count filtered records
    // --------------------------------------------
    $recordsFiltered = $this->db->count_all_results('', false);

    // --------------------------------------------
    // 4️⃣ Pagination
    // --------------------------------------------
    $this->db->limit($length, $start);

    // --------------------------------------------
    // 5️⃣ Fetch results
    // --------------------------------------------
    $query = $this->db->get();

    $data = [];
    foreach($query->result() as $r){
   $data[] = [
    $r->id,
    $r->idnumber,
    $r->employeeno,
    $r->surname,
    $r->name,
    $r->passbook_no,
    $r->cellnumber,
    $r->gender,
    $r->schoolcode,

    '
    <a href="'.base_url('index.php?burial/member_statement/'.$r->id).'"
       class="btn btn-xs btn-info"
       target="_blank"
       data-toggle="tooltip"
       data-placement="top"
       title="View Statement">
        <i class="fa fa-money"></i>
    </a>

    <a href="'.base_url('index.php?burial/member_details/'.$r->id).'"
       class="btn btn-xs btn-info"
       target="_blank"
       data-toggle="tooltip"
       data-placement="top"
       title="View Member">
        <i class="fa fa-eye"></i>
    </a>

    <a href="'.base_url('index.php?burial/beneficiaries/'.$r->id).'"
       class="btn btn-xs btn-warning"
       data-toggle="tooltip"
       data-placement="top"
       title="View Beneficiaries">
        <i class="fa fa-users"></i>
    </a>

    <!-- EDIT (AJAX MODAL) -->
    <a href="#"
       class="btn btn-xs btn-primary"
       data-toggle="tooltip"
       data-placement="top"
       title="Edit Member"
       onclick="showAjaxModal(\''.base_url('index.php?modal/popup/modal_edit_member/'.$r->id).'\')">
        <i class="fa fa-edit"></i>
    </a>

    <a href="#"
       class="btn btn-xs btn-danger"
       data-toggle="tooltip"
       data-placement="top"
       title="Delete Member"
       onclick="confirm_modal(\''.base_url('index.php?burial/member/delete/'.$r->id).'\')">
        <i class="fa fa-trash"></i>
    </a>
    '
];
    }

    return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode([
            "draw" => $draw,
            "recordsTotal" => $recordsTotal,
            "recordsFiltered" => $recordsFiltered,
            "data" => $data
        ]));
}

public function get_member_statements()
{
    if ($this->session->userdata('user_login') != 1) {
        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['success' => false, 'data' => []]));
    }

    $draw   = intval($this->input->post("draw"));
    $start  = intval($this->input->post("start"));
    $length = intval($this->input->post("length"));
    $search = $this->input->post("search")['value'] ?? '';
    $memberid = intval($this->input->post("memberid"));

    if (!$memberid) {
        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                "draw" => $draw,
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => []
            ]));
    }

    // Total records for this member (no search)
    $recordsTotal = $this->db->where('memberid', $memberid)
                              ->count_all_results("statements");

    // Build filtered query
    $this->db->from("statements");
    $this->db->where('memberid', $memberid);

    if (!empty($search)) {
        $this->db->group_start();
        $this->db->like("date", $search);
        $this->db->or_like("description", $search);
        $this->db->or_like("type", $search);
        $this->db->or_like("status", $search);
        $this->db->or_like("source", $search);
        $this->db->group_end();
    }

    // Count filtered records
    $recordsFiltered = $this->db->count_all_results('', false);

    // Pagination
    $this->db->limit($length, $start);
    $this->db->order_by('date', 'DESC');

    // Fetch results
    $query = $this->db->get();

    $data = [];
    $count = $start + 1;
    foreach($query->result() as $r){
        $data[] = [
            $count++,
            date('Y-m-d', strtotime($r->date)),
            htmlspecialchars($r->description),
            number_format((float)$r->amount, 2),
            htmlspecialchars($r->type),
            htmlspecialchars($r->status),
            htmlspecialchars($r->source ?? 'N/A'),
            htmlspecialchars($r->created_at)
        ];
    }

    return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode([
            "draw" => $draw,
            "recordsTotal" => $recordsTotal,
            "recordsFiltered" => $recordsFiltered,
            "data" => $data
        ]));
}

public function member_statement($memberid)
{
    if ($this->session->userdata('user_login') != 1)
        redirect(base_url(), 'refresh');
    // Pagination settings
    $per_page = 36;

    // Use page query string ?page=offset
    $page = intval($this->input->get('page')) ?: 0;

    // Count total statements for member
    $this->db->from('statements');
    $this->db->where('memberid', $memberid);
    $total_rows = $this->db->count_all_results();

    // Fetch paginated statements
    $this->db->order_by('date', 'DESC');
    $query = $this->db->get_where('statements', ['memberid' => $memberid], $per_page, $page);
    $statements = $query->result_array();

    // Setup pagination
    $this->load->library('pagination');
    $config = [];
    $config['base_url'] = base_url("index.php?burial/member_statement/" . $memberid);
    $config['page_query_string'] = TRUE;
    $config['query_string_segment'] = 'page';
    $config['total_rows'] = $total_rows;
    $config['per_page'] = $per_page;
    $config['full_tag_open'] = '<ul class="pagination">';
    $config['full_tag_close'] = '</ul>';
    $config['first_link'] = 'First';
    $config['last_link'] = 'Last';
    $config['first_tag_open'] = '<li>';
    $config['first_tag_close'] = '</li>';
    $config['prev_tag_open'] = '<li>';
    $config['prev_tag_close'] = '</li>';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="active"><a href="#">';
    $config['cur_tag_close'] = '</a></li>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';

    $this->pagination->initialize($config);

    $page_data['memberid'] = $memberid;
    $page_data['statements'] = $statements;
    $page_data['pagination'] = $this->pagination->create_links();
    $page_data['total_rows'] = $total_rows;
    $page_data['page_name'] = 'member_statement';
    $page_data['page_title'] = 'Member Statement : '.$memberid;
    $this->load->view('backend/index', $page_data);
}

    ///initaite sms sending
    public function invite_batch_init()
    {
        // You can restrict members (e.g., active only). For now all members.
        $total = $this->Member_model->count_all_members();

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['total' => (int)$total]));
    }
    public function invite_batch()
    {
        // prevent PHP timeout for this single request (but keep small batch)
        set_time_limit(60);

        $offset = intval($this->input->post('offset'));
        $limit = intval($this->input->post('limit'));

        if ($limit <= 0) $limit = 100;

        // fetch batch of members
        $members = $this->Member_model->get_members_batch($offset, $limit);

        $logs = [];
        $success_count = 0;

        foreach ($members as $m) {
            // generate (unique-ish) OTP code — 6 digits to avoid collisions
            $otp = $this->generate_unique_otp();

            // prepare attendance record
            $att = [
                'passbook_no' => $m['passbook_no'],
                'national_id' => $m['idnumber'],
                'agm' => 1,
                'fullname' => trim($m['surname'] . ' ' . $m['name']),
                'momo' =>  $m['cellnumber'],
                'otp' => $otp,
                'createdate' => date('Y-m-d H:i:s'),
                'attended_at' => null
            ];

            // insert into attendance table (ignore duplicates if member already invited)
            $insert_id = $this->Attendance_model->insert_if_not_exists($att);

            if ($insert_id) {
                // send SMS
                $sms_ok = $this->send_sms_otp($m['cellnumber'], $otp, $att);

                if ($sms_ok) {
                    $logs[] = "SMS sent to {$m['cellnumber']} (code: {$otp})";
                    $success_count++;
                } else {
                    $logs[] = "SMS FAILED for {$m['cellnumber']} (code: {$otp})";
                    // you may update attendance row with failed flag if desired
                }
            } else {
                $logs[] = "Member / Number already exists, skipping....";
            }
        }

        // compute processed count for client progress
        $processed = count($members);

        // total_success - useful at finish
        $total_success = $this->Attendance_model->count_sent(); // implement below

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'processed' => $processed,
                'success_count' => $success_count,
                'logs' => $logs,
                'total_success' => $total_success
            ]));
    }

    /**
     * Generate unique 6-digit OTP.
     * Tries a few times to avoid DB collisions. Good enough for 15k.
     */
    private function generate_unique_otp($tries = 5)
    {
        for ($i = 0; $i < $tries; $i++) {
            $code = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
            if (!$this->Attendance_model->otp_exists($code)) {
                return $code;
            }
        }
        // fallback: force unique by using microtime hashed (guaranteed unique-ish)
        return substr(sha1(uniqid('', true)), 0, 6);
    }

    /**
     * Generic SMS sender. Replace with your provider details.
     * Returns boolean.
     */

    public function send_sms_otp($phone,$otp, $attendance_row = null) {

        // 2️⃣ Prepare message
        $message = "SNAT Burial AGM: 13 Dec 2025, 07:00 AM, Metropolitan Evangelical Church. OTP:$otp Members: Passbook, ID & payslip. Pensioners: ID, Passbook & proof.";


        // 3️⃣ URL encode message
        $encoded_message = urlencode($message);

        // 4️⃣ API key
        $api_key = "c25hdGJ1cmlhbEBzd2F6aS5uZXQtcmVhbHNtcw=="; // Replace with your real API key

        // 5️⃣ Construct API URL
        //$phone="26876404197";
        $url = "https://www.realsms.co.sz/urlSend?_apiKey={$api_key}&dest={$phone}&message={$encoded_message}";

        // 6️⃣ Send SMS using file_get_contents
        $response = file_get_contents($url);

        if ($response !== FALSE) {
            // Optional: you can parse response if RealSMS returns JSON/text
            return ['success' => true, 'message' => "SMS sent to {$phone}", 'api_response' => $response];
        } else {
            return ['success' => false, 'error' => "Failed to send SMS", 'api_response' => $response];
        }
    }
    public function send_broadcast()
    {
        // prevent PHP timeout for this single request (but keep small batch)
        set_time_limit(60);

        $offset = intval($this->input->post('offset'));
        $limit = intval($this->input->post('limit'));
        $message = $this->input->post('message');
        $message = urlencode($message);

        if ($limit <= 0) $limit = 100;

        // fetch batch of members
        $members = $this->Member_model->get_members_batch($offset, $limit);

        $logs = [];
        $success_count = 0;

        foreach ($members as $m) {

                // send SMS
                $sms_ok = $this->broadcast_message($m['cellnumber'], $message);

                if ($sms_ok) {
                    $logs[] = "SMS sent to {$m['cellnumber']} (message: {$message})";
                    $success_count++;
                } else {
                    $logs[] = "SMS FAILED for {$m['cellnumber']} (message: {$message})";
                    // you may update attendance row with failed flag if desired
                }
        }

        // compute processed count for client progress
        $processed = count($members);

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'processed' => $processed,
                'success_count' => $success_count,
                'logs' => $logs
            ]));
    }

    public function broadcast_message($phone,$message) {

        // 2️⃣ Prepare message
        /*$message = "SNAT Burial AGM TEST (internal staff and board members only). Date: 05 Dec 2025, 10:00 AM. Venue: Metropolitan Evangelical Church. Your code: $otp. Present this at registration.";*/


        // 4️⃣ API key
        $api_key = "c25hdGJ1cmlhbEBzd2F6aS5uZXQtcmVhbHNtcw=="; // Replace with your real API key

        // 5️⃣ Construct API URL
        //$phone="26876404197";
        $url = "https://www.realsms.co.sz/urlSend?_apiKey={$api_key}&dest={$phone}&message={$message}";

        // 6️⃣ Send SMS using file_get_contents
        $response = file_get_contents($url);

        if ($response !== FALSE) {
            // Optional: you can parse response if RealSMS returns JSON/text
            return ['success' => true, 'message' => "SMS sent to {$phone}", 'api_response' => $response];
        } else {
            return ['success' => false, 'error' => "Failed to send SMS", 'api_response' => $response];
        }
    }



    /********** MANAGE ATTENDANCE (Members Present at AGM) ********************/
    function attendance($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('user_login') != 1)
            redirect('login', 'refresh');

        if ($param1 == 'create') {
            $data = [
                "national_id" => $this->input->post('national_id'),
                "fullname"    => $this->input->post('fullname'),
                "passbook_no" => $this->input->post('passbook_no'),
                "momo"        => $this->input->post('momo'),
                "agm"         => $this->input->post('agm'),
                "otp"         => $this->generate_unique_otp(),
                "createdate" => date('Y-m-d H:i:s'),
                "attended_at" => date('Y-m-d H:i:s'),
            ];            

            // Prevent duplicate momo number
            $res = $this->Attendance_model->add_manual_attendee($data);
            if ($res['success']) {
                $this->session->set_flashdata('flash_message', get_phrase('Member added successfully'));
            } else {
                
                $this->session->set_flashdata('flash_message_error', get_phrase('Member exists, not added'));
            }
            redirect(base_url() . 'index.php?burial/attendance', 'refresh');
        }

        if ($param1 == 'do_update') {
            $data['fullname']     = $this->input->post('fullname');
            $data['national_id']  = $this->input->post('national_id');
            $data['contact']      = $this->input->post('contact');
            $data['passbook']     = $this->input->post('passbook');
            $data['momo']         = $this->input->post('momo');
            $data['agm']          = $this->input->post('agm');

            $this->db->where('id', $param2);
            $this->db->update('attendance', $data);
            $this->session->set_flashdata('flash_message', get_phrase('Member updated successfully'));
            redirect(base_url() . 'index.php?burial/attendance', 'refresh');
        }

        if ($param1 == 'delete') {
            $this->db->where('id', $param2);
            $this->db->delete('attendance');
            $this->session->set_flashdata('flash_message', get_phrase('Data deleted successfully'));
            redirect(base_url() . 'index.php?burial/attendance', 'refresh');
        }

        $page_data['attendees']   = $this->db->get('attendance')->result_array();
        $page_data['agms']   = $this->db->get('agms')->result_array();
        $page_data['page_name']   = 'attendance';
        $page_data['page_title']  = get_phrase('manage_attendance');
        $this->load->view('backend/index', $page_data);
    }
    public function get_attendance()
    {
        $draw   = intval($this->input->post("draw"));
        $start  = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
        $search = $this->input->post("search")['value'];

        // --------------------------------------------
        // 1️⃣ Total records (no search)
        // --------------------------------------------
        $recordsTotal = $this->db->count_all("attendance");

        // --------------------------------------------
        // 2️⃣ Build filtered query
        // --------------------------------------------
        $this->db->from("attendance");

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->or_like("passbook_no", $search);
            $this->db->or_like("national_id", $search);
            $this->db->or_like("otp", $search);
            $this->db->or_like("fullname", $search);
            $this->db->or_like("momo", $search);
            $this->db->group_end();
        }

        // --------------------------------------------
        // 3️⃣ Count filtered records
        // --------------------------------------------
        $recordsFiltered = $this->db->count_all_results('', false);

        // --------------------------------------------
        // 4️⃣ Pagination
        // --------------------------------------------
        $this->db->limit($length, $start);

        // --------------------------------------------
        // 5️⃣ Fetch results
        // --------------------------------------------
        $query = $this->db->get();
        $count=1;
        $data = [];
        foreach($query->result() as $r){
            $data[] = [
                $count++,
                $r->passbook_no,
                $r->national_id,
                $r->agm,
                $r->fullname,
                $r->momo,
                $r->otp,
                ($r->status == 1) ? "Attended" : "Not Attended",
                '
                <button 
                    class="btn btn-xs btn-warning resend-otp" 
                    data-url="' . base_url() . 'index.php?burial/send_sms_otp/' . $r->momo . '/' . $r->otp . '">
                    <i class="fa fa-refresh"></i> Resend OTP
                </button>
                '
            ];
        }

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                "draw" => $draw,
                "recordsTotal" => $recordsTotal,
                "recordsFiltered" => $recordsFiltered,
                "data" => $data
            ]));
    }
    //DISPLAY ATTENDED MEMBERS ON DATATABLE
     public function get_attended()
    {
        $draw   = intval($this->input->post("draw"));
        $start  = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
        $search = $this->input->post("search")['value'];

        // --------------------------------------------
        // 1️⃣ Total records (no search)
        // --------------------------------------------
        $this->db->where("status", 1);
        $recordsTotal = $this->db->count_all("attendance");

        // --------------------------------------------
        // 2️⃣ Build filtered query
        // --------------------------------------------
        $this->db->from("attendance");
         $this->db->where("status", 1);

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->or_like("passbook_no", $search);
            $this->db->or_like("national_id", $search);
            $this->db->or_like("otp", $search);
            $this->db->or_like("fullname", $search);
            $this->db->or_like("momo", $search);
            $this->db->group_end();
        }

        // --------------------------------------------
        // 3️⃣ Count filtered records
        // --------------------------------------------
        $recordsFiltered = $this->db->count_all_results('', false);

        // --------------------------------------------
        // 4️⃣ Pagination
        // --------------------------------------------
        $this->db->limit($length, $start);

        // --------------------------------------------
        // 5️⃣ Fetch results
        // --------------------------------------------
        $query = $this->db->get();
        $count=1;
        $data = [];
        foreach($query->result() as $r){
            $data[] = [
                $count++,
                "MSISDN",
                $r->momo,
                $this->db->get_where('settings' , array('type'=>'momo_amount'))->row()->description,
                "Lunch" 
            ];
        }

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                "draw" => $draw,
                "recordsTotal" => $recordsTotal,
                "recordsFiltered" => $recordsFiltered,
                "data" => $data
            ]));
    }   
    /********** MANAGE AGMs (Annual General Meetings) ********************/
    function agms($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('user_login') != 1)
            redirect('login', 'refresh');

        if ($param1 == 'create') {
            $data['description'] = $this->input->post('description');
            $data['date']        =date('Y-m-d', strtotime($this->input->post('date')));
            $data['year']        = $this->input->post('year');
            $data['createdate']  = date("Y-m-d");
            $data['user']     = $this->session->userdata('user_id');

            $this->db->insert('agms', $data);
            $this->session->set_flashdata('flash_message', get_phrase('AGM added successfully'));
            redirect(base_url() . 'index.php?burial/agms', 'refresh');
        }

        if ($param1 == 'do_update') {
            $data['description'] = $this->input->post('description');
            $data['date']        = $this->input->post('date');
            $data['year']        = $this->input->post('year');

            $this->db->where('id', $param2);
            $this->db->update('agms', $data);
            $this->session->set_flashdata('flash_message', get_phrase('AGM updated successfully'));
            redirect(base_url() . 'index.php?burial/agms', 'refresh');
        }

        if ($param1 == 'delete') {
            $this->db->where('id', $param2);
            $this->db->delete('agms');
            $this->session->set_flashdata('flash_message', get_phrase('AGM deleted successfully'));
            redirect(base_url() . 'index.php?burial/agms', 'refresh');
        }

        $page_data['agms']       = $this->db->get('agms')->result_array();
        $page_data['page_name']  = 'agms';
        $page_data['page_title'] = get_phrase('manage_agms');
        $this->load->view('backend/index', $page_data);
    }


    /********** report per agm ********************/
    function report_per_agm($agmid="")
    {
        if ($this->session->userdata('user_login') != 1)
            redirect(base_url(), 'refresh');

        $agmid = ($agmid==null) ? $this->input->post('agm') : $agmid ;

        $page_data['attendees']    = $this->db->get_where('attendance', array('agm' => $agmid))->result_array();
        $page_data['page_name']  = 'agm_details';
        $page_data['page_title'] = $this->db->get_where('agms', array('id' => $agmid))->row()->description.' Details';
        $this->load->view('backend/index', $page_data);
    }    

    /********** choose meeting for details ********************/
    function detailed_meetings()
    {
        if ($this->session->userdata('user_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data['page_name']  = 'detailed_meetings';
        $page_data['page_title'] = get_phrase('detailed_meetings');
        $this->load->view('backend/index', $page_data);
    }  
    /********** MANAGE USERS (System Users / Admins) ********************/
    function manage_users($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('user_login') != 1)
            redirect('login', 'refresh');

        if ($param1 == 'create') {
            $data['name']         = $this->input->post('fullname');
            $data['email']        = $this->input->post('email');
            $data['national_id']  = $this->input->post('national_id');
            $data['level']        = $this->input->post('level');
            $data['phone']        = $this->input->post('phone');
            $data['password']     = sha1(substr($data['national_id'], -6)); // last 5 digits as default password
            $data['createdate']   = date("Y-m-d");

            //check if user exists
             $check = $this->db->get_where('admin', array('national_id' => $data['national_id']))->num_rows();
            if ($check > 0) {
                $this->session->set_flashdata('flash_message_error', get_phrase('user_already_registered'));
            } else {
                $this->db->insert('admin', $data);
                $this->session->set_flashdata('flash_message', get_phrase('user_already_successfully'));
                redirect(base_url() . 'index.php?burial/manage_users', 'refresh');
            }
        }

        if ($param1 == 'do_update') {
            $data['name']        = $this->input->post('name');
            $data['email']       = $this->input->post('email');
            $data['national_id'] = $this->input->post('national_id');
            $data['level']       = $this->input->post('level');

            $this->db->where('id', $param2);
            $this->db->update('admin', $data);
            $this->session->set_flashdata('flash_message', get_phrase('User updated successfully'));
            redirect(base_url() . 'index.php?burial/manage_users', 'refresh');
        }

        if ($param1 == 'delete') {
            $this->db->where('id', $param2);
            $this->db->delete('admin');
            $this->session->set_flashdata('flash_message', get_phrase('User deleted successfully'));
            redirect(base_url() . 'index.php?burial/manage_users', 'refresh');
        }

        $page_data['users']      = $this->db->get('admin')->result_array();
        $page_data['page_name']  = 'manage_users';
        $page_data['page_title'] = get_phrase('manage_users');
        $this->load->view('backend/index', $page_data);
    }

    /********** USER / MEMBER DETAILS ********************/
    function user_details($user_id = '')
    {
        if ($this->session->userdata('user_login') != 1)
            redirect(base_url(), 'refresh');

        $page_data['user_id']    = $user_id;
        $page_data['page_name']  = 'user_details';
        $page_data['page_title'] = get_phrase('user_details');
        $this->load->view('backend/index', $page_data);
    }


    /********** USER / MEMBER DETAILS ********************/
    function sms_batch_invite($user_id = '')
    {
        if ($this->session->userdata('user_login') != 1)
            redirect(base_url(), 'refresh');

        $page_data['page_name']  = 'sms_batch_invite';
        $page_data['page_title'] = "SMS Batch Invite";
        $this->load->view('backend/index', $page_data);
    }
    function momo_agm()
    {
        if ($this->session->userdata('user_login') != 1)
            redirect('login', 'refresh');
        
        $page_data['page_name']  = 'momo_agm';
        $page_data['page_title'] = get_phrase('momo_agm');
        $this->load->view('backend/index', $page_data);
    }


    function pay_with_momo($agmid="")
    {
        if ($this->session->userdata('user_login') != 1)
            redirect('login', 'refresh');

        $agmid = ($agmid==null) ? $this->input->post('agm') : $agmid ;

        $page_data['page_name']  = 'pay_with_momo';
        $page_data['attendees']  = $this->db->get_where('attendance', array('agm' => $agmid))->result_array();
        $page_data['page_title'] = get_phrase('pay_with_momo');
        $this->load->view('backend/index', $page_data);
    }

    function update_with_momo()
    {
        if ($this->session->userdata('user_login') != 1)
            redirect('login', 'refresh');

        $attendeeid = $this->input->post('attendeeid');

            $data['paid']= 1;

            $this->db->where('id', $attendeeid);
            $this->db->update('attendance', $data);

         $response = array();

        $response['status'] = 'updated';

        //Replying ajax request with validation response
        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }    

    /********** USER / MEMBER DETAILS ********************/
    function upload_spreadsheet($user_id = '')
    {
        if ($this->session->userdata('user_login') != 1)
            redirect(base_url(), 'refresh');

        //$page_data['user_id']    = $user_id;
        $page_data['page_name']  = 'upload_spreadsheet';
        $page_data['page_title'] = "Upload Spreadsheet";
        $this->load->view('backend/index', $page_data);
    }

    /**
     * Save CSV file for staged processing (handles large files)
     */
    function upload_spreadsheet_do()
    {
        if ($this->session->userdata('user_login') != 1)
            redirect(base_url(), 'refresh');

        if (empty($_FILES['csv_file']) || !is_uploaded_file($_FILES['csv_file']['tmp_name'])) {
            $this->session->set_flashdata('flash_message_error', 'No CSV uploaded');
            redirect(base_url() . 'index.php?burial/upload_spreadsheet', 'refresh');
        }

        // Validate file type
        $file_name = $_FILES['csv_file']['name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        
        if ($file_ext !== 'csv') {
            $this->session->set_flashdata('flash_message_error', 'Invalid file type. Please upload a CSV file only.');
            redirect(base_url() . 'index.php?burial/upload_spreadsheet', 'refresh');
        }

        // Validate MIME type
        $mime_type = mime_content_type($_FILES['csv_file']['tmp_name']);
        $allowed_mimes = ['text/csv', 'text/plain', 'application/csv', 'application/x-csv', 'application/vnd.ms-excel'];
        
        if (!in_array($mime_type, $allowed_mimes)) {
            $this->session->set_flashdata('flash_message_error', 'Invalid file format. The file must be a valid CSV file');
            redirect(base_url() . 'index.php?burial/upload_spreadsheet', 'refresh');
        }

        $upload_type = $this->input->post('upload_type');
        $month = $this->input->post('month');
        $tmp_name = $_FILES['csv_file']['tmp_name'];

        // Validate selected month (YYYY-MM) and ensure it's within last 36 months
        $valid_months = [];
        for ($i = 0; $i < 36; $i++) {
            $valid_months[] = date('Y-m', strtotime("-{$i} months"));
        }

        if (empty($month) || !preg_match('/^\d{4}-\d{2}$/', $month) || !in_array($month, $valid_months)) {
            $this->session->set_flashdata('flash_message_error', 'Invalid or missing month. Please select a month within the last 36 months.');
            redirect(base_url() . 'index.php?burial/upload_spreadsheet', 'refresh');
        }

        // Open and validate CSV
        $handle = fopen($tmp_name, 'r');
        if ($handle === false) {
            $this->session->set_flashdata('flash_message_error', 'Unable to open uploaded file');
            redirect(base_url() . 'index.php?burial/upload_spreadsheet', 'refresh');
        }

        $first_row = fgetcsv($handle);
        if (!$first_row) {
            fclose($handle);
            $this->session->set_flashdata('flash_message_error', 'CSV file is empty');
            redirect(base_url() . 'index.php?burial/upload_spreadsheet', 'refresh');
        }

        // Validate column count
        if (count($first_row) < 4) {
            fclose($handle);
            $this->session->set_flashdata('flash_message_error', 'CSV must have at least 4 columns (employeeno, fullname, idnumber, amount)');
            redirect(base_url() . 'index.php?burial/upload_spreadsheet', 'refresh');
        }

        // Validate that first row contains headers
        $expected_headers = ['employeeno', 'fullname', 'idnumber', 'amount'];
        $first_row_lower = array_map('strtolower', array_map('trim', $first_row));
        $headers_match = true;
        for ($i = 0; $i < 4; $i++) {
            if (trim($first_row_lower[$i]) !== $expected_headers[$i]) {
                $headers_match = false;
                break;
            }
        }
        
        if (!$headers_match) {
            fclose($handle);
            $this->session->set_flashdata('flash_message_error', 'CSV must have headers in the first row: employeeno, fullname, idnumber, amount');
            redirect(base_url() . 'index.php?burial/upload_spreadsheet', 'refresh');
        }

        fclose($handle);

        // Save file to temp directory for staged processing
        $temp_dir = APPPATH . 'uploads/csv_temp/';
        if (!is_dir($temp_dir)) {
            mkdir($temp_dir, 0755, true);
        }

        $session_id = $this->session->userdata('user_id') . '_' . time();
        $temp_file = $temp_dir . $session_id . '.csv';
        
        if (!copy($tmp_name, $temp_file)) {
            $this->session->set_flashdata('flash_message_error', 'Failed to save uploaded file');
            redirect(base_url() . 'index.php?burial/upload_spreadsheet', 'refresh');
        }

        // Store session data for processing
        $this->session->set_userdata([
            'csv_session_id' => $session_id,
            'csv_upload_type' => $upload_type,
            'csv_month' => $month,
            'csv_temp_file' => $temp_file
        ]);

        // Load view with progress bar
        $page_data['page_name']  = 'upload_spreadsheet_process';
        $page_data['page_title'] = "Processing CSV Upload";
        $page_data['session_id'] = $session_id;
        $page_data['upload_type'] = $upload_type;
        $page_data['month'] = $month;
        $this->load->view('backend/index', $page_data);
    }

    /**
     * Process CSV in chunks via AJAX (handles large files)
     */
    function upload_spreadsheet_chunk()
    {
        if ($this->session->userdata('user_login') != 1) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'error' => 'Not authenticated']));
        }

        $session_id = $this->input->post('session_id');
        $offset = intval($this->input->post('offset'));
        $chunk_size = 500; // Process 500 rows per request

        // Retrieve session data
        $temp_file = $this->session->userdata('csv_temp_file');
        $upload_type = $this->session->userdata('csv_upload_type');
        $month = $this->session->userdata('csv_month');

        if (!$temp_file || !file_exists($temp_file)) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'error' => 'Session expired or file not found']));
        }

        $statement_date = $month . '-01';
        $columns = ['employeeno', 'fullname', 'idnumber', 'amount'];

        $handle = fopen($temp_file, 'r');
        if ($handle === false) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'error' => 'Unable to open file']));
        }

        // Check if this month has already been uploaded (duplicate month prevention)
        $month_str = $month; // e.g., "2024-03"
        $existing_count = $this->db
            ->where('date >=', $month_str . '-01')
            ->where('date <', date('Y-m-d', strtotime($month_str . '-01 +1 month')))
            ->where('type', 'Subscription')
            ->count_all_results('statements');

        $is_duplicate_month = ($existing_count > 0);

        // Skip to offset
        $current_row = 0;
        $rows_processed = 0;
        $inserted = 0;
        $missing = [];
        $skipped = 0;
        
        // Skip header row since we already validated it
        $header_row = fgetcsv($handle);

        while (($row = fgetcsv($handle)) !== false) {
            // Skip rows until we reach the offset
            if ($current_row < $offset) {
                $current_row++;
                continue;
            }

            // Process only chunk_size rows
            if ($rows_processed >= $chunk_size) {
                break;
            }

            // Skip completely empty rows
            if (empty(array_filter($row))) {
                $skipped++;
                $rows_processed++;
                $current_row++;
                continue;
            }

            // Build associative row using fixed column names
            $row_assoc = [];
            foreach ($columns as $i => $col) {
                $row_assoc[$col] = isset($row[$i]) ? trim($row[$i]) : '';
            }

            // Extract fields
            $employeeno = trim($row_assoc['employeeno'] ?? '');
            $idnumber = trim($row_assoc['idnumber'] ?? '');
            $amount = trim($row_assoc['amount'] ?? '');
            $fullname = trim($row_assoc['fullname'] ?? '');

            // Skip rows with no ID/employee number or invalid amounts
            if (empty($employeeno) && empty($idnumber)) {
                $skipped++;
                $rows_processed++;
                $current_row++;
                continue;
            }

            // Normalize amount - remove currency symbols, commas, etc.
            $amount = preg_replace('/[^0-9\.\-]/', '', $amount);
            $amount = floatval($amount);
            
            // Skip zero/empty amounts
            if ($amount == 0) {
                $skipped++;
                $rows_processed++;
                $current_row++;
                continue;
            }

            // Try to find member by employee number OR id number
            $this->db->start_cache();
            $this->db->group_start();
            if ($employeeno !== '') {
                $this->db->where('employeeno', $employeeno);
            }
            if ($idnumber !== '') {
                $this->db->or_where('idnumber', $idnumber);
            }
            $this->db->group_end();
            $member = $this->db->get('members')->row();
            $this->db->stop_cache();
            $this->db->flush_cache();

            if ($member) {
                // Check if statement already exists for this member in this month
                $existing = $this->db
                    ->where('memberid', $member->id)
                    ->where('date >=', $statement_date)
                    ->where('date <', date('Y-m-d', strtotime($statement_date . ' +1 month')))
                    ->where('type', 'Subscription')
                    ->count_all_results('statements');

                if ($existing > 0) {
                    // Duplicate found - skip this record
                    $skipped++;
                } else {
                    // New record - insert it
                    $statement_data = [
                        'memberid' => $member->id,
                        'date' => $statement_date,
                        'description' => ($upload_type === 'treasurer' ? 'Treasurer : '.date('F Y', strtotime($statement_date)) : 'SNAT EMP Subscription : '.date('F Y', strtotime($statement_date))),
                        'amount' => $amount,
                        'type' => 'Subscription',
                        'status' => 'Paid',
                        'source' => ($upload_type === 'treasurer' ? 'Treasure' : 'SNAT Employee'),
                        'user' => $this->session->userdata('user_id'),
                        'created_at' => date('Y-m-d')
                    ];

                    $this->db->insert('statements', $statement_data);
                    $inserted++;
                }
            } else {
                $missing[] = ['employeeno' => $employeeno, 'idnumber' => $idnumber, 'fullname' => $fullname];
            }

            $rows_processed++;
            $current_row++;
        }

        fclose($handle);

        // Check if there are more rows to process
        $has_more = false;
        if ($rows_processed >= $chunk_size) {
            $handle = fopen($temp_file, 'r');
            $line_count = 0;
            while (fgetcsv($handle) !== false) {
                $line_count++;
            }
            fclose($handle);
            $has_more = ($offset + $chunk_size) < $line_count;
        }

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'success' => true,
                'inserted' => $inserted,
                'skipped' => $skipped,
                'missing_count' => count($missing),
                'rows_processed' => $rows_processed,
                'next_offset' => $offset + $chunk_size,
                'has_more' => $has_more,
                'is_duplicate_month' => $is_duplicate_month,
                'missing' => array_slice($missing, 0, 10) // Return first 10 missing for display
            ]));
    }

    /**
     * Finalize CSV upload and cleanup
     */
    function upload_spreadsheet_finish()
    {
        if ($this->session->userdata('user_login') != 1) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'error' => 'Not authenticated']));
        }

        $temp_file = $this->session->userdata('csv_temp_file');
        
        // Delete temp file
        if ($temp_file && file_exists($temp_file)) {
            unlink($temp_file);
        }

        // Clear session data
        $this->session->unset_userdata(['csv_session_id', 'csv_upload_type', 'csv_month', 'csv_temp_file']);

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['success' => true]));
    }

    /********** SYSTEM SETTINGS ********************/
    function manage_system($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('user_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');

        if ($param1 == 'do_update') {
            $items = array('system_name', 'system_title', 'address', 'phone', 'system_email','momo_amount');
            foreach ($items as $item) {
                $data['description'] = $this->input->post($item);
                $this->db->where('type', $item);
                $this->db->update('settings', $data);
            }
            $this->session->set_flashdata('flash_message', get_phrase('data_updated'));
            redirect(base_url() . 'index.php?burial/manage_system', 'refresh');
        }

        if ($param1 == 'upload_logo') {
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/logo.png');
            $this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
            redirect(base_url() . 'index.php?burial/manage_system', 'refresh');
        }

        if ($param1 == 'change_skin') {
            $skins = array('skin_colour', 'borders_style', 'header_colour', 'sidebar_colour', 'sidebar_size');
            foreach ($skins as $skin) {
                $data['description'] = $this->input->post($skin);
                $this->db->where('type', $skin);
                $this->db->update('settings', $data);
            }
            $this->session->set_flashdata('flash_message', get_phrase('theme_updated'));
            redirect(base_url() . 'index.php?burial/manage_system', 'refresh');
        }

        $page_data['page_name']  = 'manage_system';
        $page_data['page_title'] = get_phrase('manage_system');
        $page_data['settings']   = $this->db->get('settings')->result_array();
        $this->load->view('backend/index', $page_data);
    }


    /********** MANAGE COMMUNIQUES ********************/
    function sms_communique($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('user_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');

        // ... (your existing language logic – unchanged except session check)
        $page_data['page_name']  = 'sms_communique';
        $page_data['page_title'] = "SMS Communique";
        $this->load->view('backend/index', $page_data);
    }
    /********** MANAGE Claims ********************/
    function claims($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('user_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');

        // CREATE CLAIM
        if ($param1 == 'create') {

            $claim_type = $this->input->post('claim_type') ? $this->input->post('claim_type') : 'BENEFICIARY';
            
            $data['member_id']      = $this->input->post('member_id');
            $data['claim_type']     = $claim_type;
            $data['national_id']    = $this->input->post('national_id');
            $data['amount']         = $this->input->post('amount');
            $data['claim_date']     = $this->input->post('claim_date');
            $data['bank']           = $this->input->post('bank');
            $data['account']        = $this->input->post('account');
            $data['mortuary']           = $this->input->post('date_of_entry');
            $data['date_of_entry']        = $this->input->post('date_of_entry');
            $data['approved_date']  = !empty($this->input->post('approved_date')) ? $this->input->post('approved_date') : null;
            $data['status']         = $this->input->post('status') ? $this->input->post('status') : 'PENDING';
            $data['payment_date']   = !empty($this->input->post('payment_date')) ? $this->input->post('payment_date') : null;
            // set processed_by to logged in user
            $data['processed_by']   = $this->session->userdata('user_id');
            $data['approved_by']    = !empty($this->input->post('approved_by')) ? $this->input->post('approved_by') : null;
            $data['notes']          = !empty($this->input->post('notes')) ? $this->input->post('notes') : null;
            $data['created_at']     = date('Y-m-d H:i:s');
            $data['updated_at']     = date('Y-m-d H:i:s');

            // Handle based on claim type
            if ($claim_type === 'BENEFICIARY') {
                // BENEFICIARY CLAIM
                $data['beneficiary_id'] = $this->input->post('beneficiary_id');
                $data['place_of_burial'] = !empty($this->input->post('place_of_burial')) ? $this->input->post('place_of_burial') : null;
                $data['date_of_burial']  = !empty($this->input->post('date_of_burial')) ? $this->input->post('date_of_burial') : null;
                
                // Check if national_id appears more than twice for beneficiary claims
                if (!empty($data['national_id'])) {
                    $this->db->where('national_id', $data['national_id'])
                             ->where('claim_type', 'BENEFICIARY');
                    $count = $this->db->get('claims')->num_rows();
                    
                    if ($count >= 2) {
                        $this->session->set_flashdata('flash_message_error', 'A beneficiary with this national ID can only have maximum 2 claims. Please use a member claim if this is the member themselves.');
                        redirect(base_url() . 'index.php?burial/claims', 'refresh');
                        return;
                    }
                }
                
                // Prevent duplicate claims for same member and beneficiary
                $this->db->where('member_id', $data['member_id'])
                         ->where('beneficiary_id', $data['beneficiary_id'])
                         ->where('claim_type', 'BENEFICIARY')
                         ->where('claim_date', $data['claim_date']);

                $exists = $this->db->get('claims')->num_rows();

                if ($exists > 0) {
                    $this->session->set_flashdata('flash_message_error', 'A claim already exists for this member and beneficiary on this date');
                    redirect(base_url() . 'index.php?burial/claims', 'refresh');
                    return;
                }
            } else {
                // MEMBER/NOMINEE CLAIM
                $nominee_id = $this->input->post('nominee_id');
                $data['nominee_id']      = !empty($nominee_id) ? $nominee_id : null;
                $data['beneficiary_id']  = null;
                $data['place_of_burial'] = null;
                $data['date_of_burial']  = null;
            }

            $this->db->insert('claims', $data);
            $claim_id = $this->db->insert_id();

            // Handle multiple document uploads (document_file[] and document_description[])
            if (!empty($_FILES) && isset($_FILES['document_file'])) {
                $descriptions = $this->input->post('document_description');

                $files = $_FILES['document_file'];
                $count = count($files['name']);

                // prepare upload path
                $upload_path = FCPATH . 'uploads/claim_documents/';
                if (!is_dir($upload_path)) mkdir($upload_path, 0755, true);

                $this->load->library('upload');

                for ($i = 0; $i < $count; $i++) {
                    if (empty($files['name'][$i])) continue;

                    $_FILES['docfile']['name']     = $files['name'][$i];
                    $_FILES['docfile']['type']     = $files['type'][$i];
                    $_FILES['docfile']['tmp_name'] = $files['tmp_name'][$i];
                    $_FILES['docfile']['error']    = $files['error'][$i];
                    $_FILES['docfile']['size']     = $files['size'][$i];

                    $ext = pathinfo($_FILES['docfile']['name'], PATHINFO_EXTENSION);
                    $new_name = 'claim_' . $claim_id . '_' . time() . '_' . $i . '.' . $ext;

                    $config['upload_path']   = $upload_path;
                    $config['allowed_types'] = 'pdf|jpg|jpeg|png|doc|docx';
                    $config['max_size']      = 5120;
                    $config['file_name']     = $new_name;

                    $this->upload->initialize($config);

                    if ($this->upload->do_upload('docfile')) {
                        $ud = $this->upload->data();
                        $doc_data = [
                            'claim_id' => $claim_id,
                            'description' => isset($descriptions[$i]) ? $descriptions[$i] : '',
                            'path' => 'uploads/claim_documents/' . $ud['file_name'],
                            'timestamp' => date('Y-m-d H:i:s')
                        ];
                        $this->db->insert('claims_documents', $doc_data);
                    }
                }
            }

            $this->session->set_flashdata('flash_message', 'Claim added successfully');

            redirect(base_url() . 'index.php?burial/claims', 'refresh');
        }

        // UPDATE CLAIM
        if ($param1 == 'do_update') {

            $claim_type = $this->input->post('claim_type') ? $this->input->post('claim_type') : 'BENEFICIARY';
            
            $data['member_id']      = $this->input->post('member_id');
            $data['claim_type']     = $claim_type;
            $data['national_id']    = $this->input->post('national_id');
            $data['amount']         = $this->input->post('amount');
            $data['claim_date']     = $this->input->post('claim_date');
            $data['bank']           = $this->input->post('bank');
            $data['account']        = $this->input->post('account');
            $data['approved_date']  = !empty($this->input->post('approved_date')) ? $this->input->post('approved_date') : null;
            $data['status']         = $this->input->post('status');
            $data['payment_date']   = !empty($this->input->post('payment_date')) ? $this->input->post('payment_date') : null;
            $data['processed_by']   = !empty($this->input->post('processed_by')) ? $this->input->post('processed_by') : null;
            $data['approved_by']    = !empty($this->input->post('approved_by')) ? $this->input->post('approved_by') : null;
            $data['notes']          = !empty($this->input->post('notes')) ? $this->input->post('notes') : null;
            $data['updated_at']     = date('Y-m-d H:i:s');

            // Handle based on claim type
            if ($claim_type === 'BENEFICIARY') {
                $data['beneficiary_id'] = $this->input->post('beneficiary_id');
                $data['place_of_burial'] = !empty($this->input->post('place_of_burial')) ? $this->input->post('place_of_burial') : null;
                $data['date_of_burial']  = !empty($this->input->post('date_of_burial')) ? $this->input->post('date_of_burial') : null;
                $data['nominee_id']      = null;
            } else {
                $data['beneficiary_id'] = null;
                $data['place_of_burial'] = null;
                $data['date_of_burial']  = null;
                $data['nominee_id']      = !empty($this->input->post('nominee_id')) ? $this->input->post('nominee_id') : null;
            }

            $this->db->where('id', $param2);
            $this->db->update('claims', $data);
            
            // Update beneficiary status to BENEFITTED if claim is APPROVED or PAID
            if (in_array($data['status'], ['APPROVED', 'PAID']) && !empty($data['beneficiary_id'])) {
                $this->db->where('id', $data['beneficiary_id'])->update('beneficiaries', ['status' => 'BENEFITTED']);
            }

            $this->session->set_flashdata('flash_message', 'Claim updated successfully');
            redirect(base_url() . 'index.php?burial/claims', 'refresh');
        }

        // DELETE CLAIM
        if ($param1 == 'delete') {
            $this->db->where('id', $param2);
            $this->db->delete('claims');
            
            // Also delete associated documents
            $this->db->where('claim_id', $param2);
            $this->db->delete('claims_documents');
            
            $this->session->set_flashdata('flash_message', 'Claim deleted successfully');

            redirect(base_url() . 'index.php?burial/claims', 'refresh');
        }

        // DELETE DOCUMENT
        if ($param1 == 'delete_document') {
            // Get document path first to delete file
            $document = $this->db->get_where('claims_documents', ['id' => $param2])->row_array();
            
            if ($document && file_exists($document['path'])) {
                unlink($document['path']);
            }
            
            $this->db->where('id', $param2);
            $this->db->delete('claims_documents');
            
            $this->session->set_flashdata('flash_message', 'Document deleted successfully');
            redirect(base_url() . 'index.php?burial/claims', 'refresh');
        }

        // VIEW CLAIM DETAILS
        if ($param1 == 'view' && !empty($param2)) {
            $claim_id = intval($param2);
            $page_data['claim'] = $this->db->get_where('claims', ['id' => $claim_id])->row_array();
            if (!$page_data['claim']) {
                $this->session->set_flashdata('flash_message_error', 'Claim not found');
                redirect(base_url() . 'index.php?burial/claims', 'refresh');
            }
            $page_data['documents'] = $this->db->get_where('claims_documents', ['claim_id' => $claim_id])->result_array();
            $page_data['page_name']  = 'claim_details';
            $page_data['page_title'] = 'Claim Details';
            $this->load->view('backend/index', $page_data);
            return;
        }

        // APPROVE CLAIM
        if ($param1 == 'approve' && !empty($param2)) {
            $claim_id = intval($param2);
            
            // Get claim to get beneficiary_id
            $claim = $this->db->get_where('claims', ['id' => $claim_id])->row_array();
            
            $update = [
                'status' => 'APPROVED',
                'approved_by' => $this->session->userdata('user_id'),
                'approved_date' => date('Y-m-d'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $this->db->where('id', $claim_id)->update('claims', $update);
            
            // Update beneficiary status to BENEFITTED
            if (!empty($claim['beneficiary_id'])) {
                $this->db->where('id', $claim['beneficiary_id'])->update('beneficiaries', ['status' => 'BENEFITTED']);
            }
            
            $this->session->set_flashdata('flash_message', 'Claim approved and beneficiary marked as BENEFITTED');
            redirect(base_url() . 'index.php?burial/claims/view/' . $claim_id, 'refresh');
        }

        // REJECT CLAIM
        if ($param1 == 'reject' && !empty($param2)) {
            $claim_id = intval($param2);
            $update = [
                'status' => 'REJECTED',
                'approved_by' => $this->session->userdata('user_id'),
                'approved_date' => date('Y-m-d'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $this->db->where('id', $claim_id)->update('claims', $update);
            $this->session->set_flashdata('flash_message', 'Claim rejected');
            redirect(base_url() . 'index.php?burial/claims/view/' . $claim_id, 'refresh');
        }

        // UPLOAD DOCUMENT
        if ($param1 == 'upload_document') {
            $claim_id = $this->input->post('claim_id');
            $description = $this->input->post('description');
            
            // Validate claim exists
            $claim = $this->db->get_where('claims', ['id' => $claim_id])->row_array();
            if (!$claim) {
                $this->session->set_flashdata('flash_message_error', 'Claim not found');
                redirect(base_url() . 'index.php?burial/claims', 'refresh');
            }

            // Handle file upload
            $config['upload_path'] = FCPATH . 'uploads/claim_documents/';
            $config['allowed_types'] = 'pdf|jpg|jpeg|png|doc|docx';
            $config['max_size'] = 5120; // 5MB
            $config['file_name'] = 'claim_' . $claim_id . '_' . time();

            // Create directory if it doesn't exist
            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0755, true);
            }

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('document_file')) {
                $this->session->set_flashdata('flash_message_error', $this->upload->display_errors());
            } else {
                $upload_data = $this->upload->data();
                
                $doc_data['claim_id'] = $claim_id;
                $doc_data['description'] = $description;
                $doc_data['path'] = 'uploads/claim_documents/' . $upload_data['file_name'];
                $doc_data['timestamp'] = date('Y-m-d H:i:s');

                $this->db->insert('claims_documents', $doc_data);
                $this->session->set_flashdata('flash_message', 'Document uploaded successfully');
            }

            redirect(base_url() . 'index.php?burial/claims', 'refresh');
        }

        // FETCH ALL CLAIMS
        $page_data['claims'] = $this->Claims_model->get_all_claims();
        
        // FETCH ALL DOCUMENTS
        $page_data['claims_documents'] = $this->db->get('claims_documents')->result_array();
        $page_data['enum_banks'] = $this->Enum_model->get_enum_values('claims', 'bank');
        $page_data['page_name']  = 'claims';
        $page_data['page_title'] = "Claims";
        $this->load->view('backend/index', $page_data);
    }

    /********** MANAGE APPROVED Claims ********************/
    function approved_claims($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('user_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');

        // PAY CLAIM (mark as PAID)
        if ($param1 == 'pay' && !empty($param2)) {
            $claim_id = intval($param2);

            // Get claim so we can update related beneficiary if needed
            $claim = $this->db->get_where('claims', ['id' => $claim_id])->row_array();
            if (!$claim) {
                $this->session->set_flashdata('flash_message_error', 'Claim not found');
                redirect(base_url() . 'index.php?burial/approved_claims', 'refresh');
            }

            $update = [
                'status'       => 'PAID',
                'payment_date' => date('Y-m-d'),
                'paid_by'      => $this->session->userdata('user_id'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ];

            $this->db->where('id', $claim_id)->update('claims', $update);

            // If it's a beneficiary claim, ensure beneficiary is marked as BENEFITTED
            if (!empty($claim['beneficiary_id'])) {
                $this->db->where('id', $claim['beneficiary_id'])->update('beneficiaries', ['status' => 'BENEFITTED']);
            }else{
                // If it's a member claim, mark the member as INACTIVE (deceased)
                $this->db->where('id', $claim['member_id'])->update('members', ['is_alive' => 0]);
            }

            $this->session->set_flashdata('flash_message', 'Claim marked as PAID');
            redirect(base_url() . 'index.php?burial/claims/view/' . $claim_id, 'refresh');
        }

        // FETCH ONLY APPROVED CLAIMS
        $this->db->where('status', 'APPROVED');
        $page_data['claims'] = $this->db->get('claims')->result_array();

        $page_data['page_name']  = 'approved_claims';
        $page_data['page_title'] = "Approved Claims";
        $this->load->view('backend/index', $page_data);
    }
    /********** Print Claim details ********************/
    function print_claims_details($claim_id = '')
    {
        if ($this->session->userdata('user_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');

        
        // FETCH ONLY APPROVED CLAIMS
        $page_data['claim'] = $this->db->get_where('claims', ['id' => $claim_id])->row_array();
        $page_data['documents'] = $this->db->get_where('claims_documents', ['claim_id' => $claim_id])->result_array();
        $page_data['page_name']  = 'print_claims_details';
        $page_data['page_title'] = "Claim Details : ".$claim_id;
        $this->load->view('backend/print_claim_details.php', $page_data);
    }
    /********** MANAGE PENDING MEMBER APPLICATIONS ********************/
    function pending_members($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('user_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');

        // APPROVE PENDING MEMBER APPLICATION
        if ($param1 === 'approve' && !empty($param2)) {
            $pending_id = intval($param2);

            // Start transaction
            $this->db->trans_begin();

            // 1. Get pending member (must be still pending)
            $pending = $this->db
                ->where('id', $pending_id)
                ->where('application_status', 'pending')
                ->get('pending_members')
                ->row_array();

            if (!$pending) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('flash_message_error', 'Pending application not found or already processed.');
                redirect(base_url() . 'index.php?burial/pending_members', 'refresh');
            }

            // 2. Insert into members
            // Map gender from full word to single-letter code expected in members table
            $gender = null;
            if (strcasecmp($pending['gender'], 'Male') === 0) {
                $gender = 'M';
            } elseif (strcasecmp($pending['gender'], 'Female') === 0) {
                $gender = 'F';
            } else {
                $gender = null;
            }

            $member_data = [
                'idnumber'      => $pending['idnumber'],
                'passbook_no'   => $pending['passbook_no'],
                'employeeno'    => $pending['employeeno'],
                'tscno'         => $pending['tscno'],
                'surname'       => $pending['surname'],
                'name'          => $pending['name'],
                'cellnumber'    => $pending['cellnumber'],
                'dob'           => $pending['dob'],
                'gender'        => $gender,
                'schoolcode'    => $pending['schoolcode'],
                'resident'      => $pending['resident'],
                'createdate'    => date('Y-m-d H:i:s'),
                'timestamp'     => date('Y-m-d H:i:s'),
                'user'          => $this->session->userdata('user_id'),
                'password'      => '',          // no login from members table here
                'last_login'    => null,
                'login_attempts'=> 0,
                'is_alive'      => 1,
            ];

            $this->db->insert('members', $member_data);
            $member_id = $this->db->insert_id();

            // 3. Copy documents from application_documents -> member_documents
            $docs = $this->db
                ->where('pending_member_id', $pending_id)
                ->get('application_documents')
                ->result_array();

            foreach ($docs as $doc) {
                $member_doc = [
                    'member_id'     => $member_id,
                    'document_type' => $doc['document_type'],
                    'file_name'     => $doc['file_name'],
                    'file_path'     => $doc['file_path'],
                    'mime_type'     => $doc['mime_type'],
                    'file_size'     => $doc['file_size'],
                    'uploaded_at'   => $doc['uploaded_at'],
                ];
                $this->db->insert('member_documents', $member_doc);
            }

            // 4. Mark application as approved
            $this->db->where('id', $pending_id)
                     ->update('pending_members', [
                         'application_status' => 'approved',
                         'reviewed_at'        => date('Y-m-d H:i:s'),
                         'reviewed_by'        => $this->session->userdata('user_id'),
                     ]);

            // Commit or rollback
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('flash_message_error', 'Error approving member application. No changes were saved.');
            } else {
                $this->db->trans_commit();
                $this->session->set_flashdata('flash_message', 'Member application approved and created in Members.');
            }

            redirect(base_url() . 'index.php?burial/pending_members', 'refresh');
        }

        // Default: load pending members view, DataTables will fetch data via AJAX
        $page_data['page_name']  = 'pending_members';
        $page_data['page_title'] = 'Pending Member Applications';
        $this->load->view('backend/index', $page_data);
    }

    /**
     * Server-side provider for pending members DataTable
     */
    public function get_pending_members()
    {
        if ($this->session->userdata('user_login') != 1) {
            show_error('Not authorized', 401);
            return;
        }

        $draw   = intval($this->input->post('draw'));
        $start  = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $search = $this->input->post('search')['value'] ?? '';

        // Base query: only pending applications
        $this->db->from('pending_members');
        $this->db->where('application_status', 'pending');
        $recordsTotal = $this->db->count_all_results();

        // Filtered query
        $this->db->from('pending_members');
        $this->db->where('application_status', 'pending');

        if (!empty($search)) {
            $this->db->group_start()
                     ->like('surname', $search)
                     ->or_like('name', $search)
                     ->or_like('idnumber', $search)
                     ->or_like('passbook_no', $search)
                     ->or_like('employeeno', $search)
                     ->or_like('cellnumber', $search)
                     ->group_end();
        }

        $recordsFiltered = $this->db->count_all_results('', FALSE);

        // Ordering
        $order_column_index = $this->input->post('order')[0]['column'] ?? 0;
        $order_direction    = $this->input->post('order')[0]['dir'] ?? 'asc';

        $columns = [
            0 => 'id',
            1 => 'idnumber',
            2 => 'employeeno',
            3 => 'surname',
            4 => 'name',
            5 => 'passbook_no',
            6 => 'cellnumber',
            7 => 'gender',
            8 => 'schoolcode',
        ];

        $order_column = $columns[$order_column_index] ?? 'id';
        $this->db->order_by($order_column, $order_direction);

        if ($length != -1) {
            $this->db->limit($length, $start);
        }

        $query = $this->db->get();
        $pending_members = $query->result_array();

        $data = [];
        $i = $start + 1;

        foreach ($pending_members as $row) {
            // Option buttons: approve + view docs (simple count)
            $doc_count = $this->db
                ->where('pending_member_id', $row['id'])
                ->count_all_results('application_documents');

            $options = '<a href="' . base_url('index.php?burial/pending_members/approve/' . $row['id']) . '" ' .
                       'class="btn btn-xs btn-success" ' .
                       'onclick="return confirm(\'Approve this member application?\');">' .
                       '<i class="fa fa-check"></i> Approve</a>';

            if ($doc_count > 0) {
                $options .= ' <span class="label label-info">' . $doc_count . ' docs</span>';
            } else {
                $options .= ' <span class="label label-default">No docs</span>';
            }

            $data[] = [
                $i++,
                htmlspecialchars($row['idnumber']),
                htmlspecialchars($row['employeeno']),
                htmlspecialchars($row['surname']),
                htmlspecialchars($row['name']),
                htmlspecialchars($row['passbook_no']),
                htmlspecialchars($row['cellnumber']),
                htmlspecialchars($row['gender']),
                htmlspecialchars($row['schoolcode']),
                $options,
            ];
        }

        $response = [
            'draw'            => $draw,
            'recordsTotal'    => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data'            => $data,
        ];

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }
    /********** LANGUAGE SETTINGS ********************/
    function manage_language($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('user_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');

        // ... (your existing language logic – unchanged except session check)
        $page_data['page_name']  = 'manage_language';
        $page_data['page_title'] = get_phrase('manage_language');
        $this->load->view('backend/index', $page_data);
    }

    /********** BACKUP & RESTORE ********************/
    function backup_restore($operation = '', $type = '')
    {
        if ($this->session->userdata('user_login') != 1)
            redirect(base_url(), 'refresh');

        if ($operation == 'create') {
            $this->crud_model->create_backup($type);
        }
        if ($operation == 'restore') {
            $this->crud_model->restore_backup();
            $this->session->set_flashdata('backup_message', 'Backup Restored');
            redirect(base_url() . 'index.php?burial/backup_restore/', 'refresh');
        }
        if ($operation == 'delete') {
            $this->crud_model->truncate($type);
            $this->session->set_flashdata('backup_message', 'Data removed');
            redirect(base_url() . 'index.php?burial/backup_restore/', 'refresh');
        }

        $page_data['page_name']  = 'backup_restore';
        $page_data['page_title'] = get_phrase('manage_backup_restore');
        $this->load->view('backend/index', $page_data);
    }

    /********** MANAGE PROFILE & SECURITY ********************/

    function security_settings($param1 = '')
    {
        if ($this->session->userdata('user_login') != 1)
            redirect(base_url(), 'refresh');

        if ($param1 == 'update') {
            $old_password = sha1($this->input->post('old_password'));
            $new_password = sha1($this->input->post('new_password'));
            $user_id = $this->session->userdata('user_id');

            $stored_pass = $this->db->get_where('user', array('id' => $user_id))->row()->password;

            if ($stored_pass == $old_password) {
                $this->db->where('id', $user_id);
                $this->db->update('user', array('password' => $new_password));
                $this->session->set_flashdata('flash_message', get_phrase('password_updated'));
            } else {
                $this->session->set_flashdata('flash_message_error', get_phrase('old_password_incorrect'));
            }
            redirect(base_url() . 'index.php?burial/security_settings', 'refresh');
        }

        $page_data['page_name']  = 'security_settings';
        $page_data['page_title'] = get_phrase('change_password');
        $this->load->view('backend/index', $page_data);
    }

    /********** PAYMENTS MANAGEMENT ********************/
    
    function payments()
    {
        if ($this->session->userdata('user_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');

       $page_data['status_enum'] = $this->Enum_model->get_enum_values('statements', 'status');
       $page_data['source_enum'] = $this->Enum_model->get_enum_values('statements', 'source');
        $page_data['page_name']  = 'payments';
        $page_data['page_title'] = 'Add Subscription Payment';
        $this->load->view('backend/index', $page_data);
    }

    /**
     * Search members - AJAX endpoint
     */
    public function search_members()
    {
        if ($this->session->userdata('user_login') != 1) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'members' => []]));
        }

        $search = $this->input->post('search');
        if (!$search || strlen($search) < 2) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'members' => []]));
        }

        // Search in idnumber, name, surname, passbook_no, employeeno
        $this->db->group_start();
        $this->db->like('idnumber', $search);
        $this->db->or_like('name', $search);
        $this->db->or_like('surname', $search);
        $this->db->or_like('passbook_no', $search);
        $this->db->or_like('employeeno', $search);
        $this->db->group_end();
        $this->db->limit(10);
        $query = $this->db->get('members');
        $members = $query->result_array();

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['success' => true, 'members' => $members]));
    }

    /**
     * Get nominees for a member
     */
    public function get_nominees()
    {
        if ($this->session->userdata('user_login') != 1) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'nominees' => []]));
        }

        $member_id = $this->input->post('member_id');
        if (!$member_id) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'nominees' => []]));
        }

        // Get nominees for this member
        $nominees = $this->db->get_where('nominee', ['member_id' => $member_id])->result_array();

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['success' => true, 'nominees' => $nominees]));
    }

    /**
     * Get matured, payable beneficiaries for a member (AJAX)
     */
    public function get_matured_beneficiaries()
    {
        if ($this->session->userdata('user_login') != 1) {
            return $this->output->set_content_type('application/json')->set_output(json_encode(['success' => false, 'beneficiaries' => []]));
        }

        $member_id = $this->input->post('member_id');
        if (empty($member_id)) {
            return $this->output->set_content_type('application/json')->set_output(json_encode(['success' => false, 'beneficiaries' => []]));
        }

        $all = $this->Beneficiary_model->get_by_member($member_id);
        $out = [];
        foreach ($all as $b) {
            $status = trim($b['status']);
            // Exclude deleted or already replaced beneficiaries
            if (in_array($status, ['DELETED', 'DECEASED - REPLACED', 'BENEFITTED - REPLACED'], true)) continue;

            // Parse submission_date similar to beneficiaries.php view
            $submission_ts = $this->_parse_date_to_ts($b['submission_date'] ?? '');
            $today = strtotime(date('Y-m-d'));
            $one_year_ago = strtotime('-1 year', $today);
            $is_matured = ($submission_ts && $submission_ts <= $one_year_ago);

            // Include if matured by submission date OR explicitly a REPLACEE
            if ($is_matured || $status === 'REPLACEE') {
                $out[] = [
                    'id' => $b['id'],
                    'fullname' => $b['fullname'],
                    'idnumber' => isset($b['idnumber']) ? $b['idnumber'] : ''
                ];
            }
        }

        return $this->output->set_content_type('application/json')->set_output(json_encode(['success' => true, 'beneficiaries' => $out]));
    }

    /**
     * Get calculated monthly payment amount for a member
     */
    public function get_member_payment_amount()
    {
        if ($this->session->userdata('user_login') != 1) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'amount' => 0]));
        }

        $member_id = $this->input->post('member_id');
        if (!$member_id) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'amount' => 0]));
        }

        $this->load->model('Beneficiary_model');

        // Get beneficiaries
        $beneficiaries = $this->Beneficiary_model->get_by_member($member_id);
        
        // Get payable summary
        $summary = $this->Beneficiary_model->get_payable_summary($member_id);
        $payable_beneficiaries = $summary['payable_beneficiaries'];

        // Get fees from settings
        $principal_fee = (float) $this->db
            ->get_where('settings', ['type' => 'principal_fee'])
            ->row()->description;

        $member_fee = (float) $this->db
            ->get_where('settings', ['type' => 'member_fee'])
            ->row()->description;

        // Calculate total monthly
        $beneficiary_fee = $member_fee * $payable_beneficiaries;
        $total_monthly = $principal_fee + $beneficiary_fee;

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'success' => true,
                'amount' => $total_monthly,
                'principal_fee' => $principal_fee,
                'member_fee' => $member_fee,
                'payable_beneficiaries' => $payable_beneficiaries,
                'beneficiary_fee' => $beneficiary_fee
            ]));
    }

    /**
     * Get available months (months not yet subscribed for) for a member
     */
    public function get_available_months()
    {
        if ($this->session->userdata('user_login') != 1) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'months' => []]));
        }

        $member_id = $this->input->post('member_id');
        if (!$member_id) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'months' => []]));
        }

        // Generate all possible months (36 months back + 12 months forward)
        $all_months = [];
        $today = new DateTime();
        $start_date = clone $today;
        $start_date->modify('-36 months');
        $end_date = clone $today;
        $end_date->modify('+12 months');
        
        $current = clone $start_date;
        while ($current <= $end_date) {
            $month_value = $current->format('Y-m');
            $month_label = $current->format('F Y');
            
            $all_months[$month_value] = [
                'value' => $month_value,
                'label' => $month_label
            ];
            
            $current->modify('+1 month');
        }

        // Get subscribed months for this member
        $subscribed_months = $this->db
            ->select('DATE_FORMAT(date, "%Y-%m") as month')
            ->where('memberid', $member_id)
            ->where('type', 'Subscription')
            ->group_by('month')
            ->get('statements')
            ->result_array();

        $subscribed_month_values = [];
        foreach ($subscribed_months as $row) {
            $subscribed_month_values[$row['month']] = true;
        }

        // Filter out subscribed months
        $available_months = [];
        foreach ($all_months as $month_value => $month_data) {
            if (!isset($subscribed_month_values[$month_value])) {
                $available_months[] = $month_data;
            }
        }

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'success' => true,
                'months' => $available_months
            ]));
    }

    /**
     * Add subscription payment - Form submission
     */
    public function add_subscription()
    {
        if ($this->session->userdata('user_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');

        // Get user_id from session
        $user_id = $this->session->userdata('user_id');
        if (!$user_id) {
            $this->session->set_flashdata('flash_message_error', 'User not logged in');
            redirect(base_url() . 'index.php?burial/payments', 'refresh');
        }

        // Validate input
        $member_id = $this->input->post('selected_member_id');
        $months = $this->input->post('months');
        $amount_per_month = floatval($this->input->post('amount_per_month'));
        $description = $this->input->post('description') ?? 'Subscription payment - Burial Scheme';
        $source = $this->input->post('source');
        $status = $this->input->post('status') ?? 'pending';

        if (empty($member_id)) {
            $this->session->set_flashdata('flash_message_error', 'Please select a member');
            redirect(base_url() . 'index.php?burial/payments', 'refresh');
        }

        if (empty($months) || !is_array($months)) {
            $this->session->set_flashdata('flash_message_error', 'Please select at least one month');
            redirect(base_url() . 'index.php?burial/payments', 'refresh');
        }

        if ($amount_per_month <= 0) {
            $this->session->set_flashdata('flash_message_error', 'Please enter a valid amount');
            redirect(base_url() . 'index.php?burial/payments', 'refresh');
        }

        if (empty($source)) {
            $this->session->set_flashdata('flash_message_error', 'Please select a source');
            redirect(base_url() . 'index.php?burial/payments', 'refresh');
        }

        // Validate source value
        $valid_sources = ['Stop Order', 'EFT', 'Deposit', 'Cash', 'Treasure', 'SNAT Employee', 'Momo'];
        if (!in_array($source, $valid_sources)) {
            $this->session->set_flashdata('flash_message_error', 'Invalid source selected');
            redirect(base_url() . 'index.php?burial/payments', 'refresh');
        }

        // Verify member exists
        $member = $this->db->get_where('members', ['id' => $member_id])->row();
        if (!$member) {
            $this->session->set_flashdata('flash_message_error', 'Member not found');
            redirect(base_url() . 'index.php?burial/payments', 'refresh');
        }

        // FIRST: Check ALL months for duplicates before adding any
        $duplicate_months = [];

        foreach ($months as $month) {
            // Validate month format (YYYY-MM)
            if (!preg_match('/^\d{4}-\d{2}$/', $month)) {
                continue;
            }

            // Parse month to create date (first day of month)
            $month_date = $month . '-01'; // First day of month

            // Check if subscription already exists for this member and month
            $existing_subscription = $this->db
                ->where('memberid', $member_id)
                ->where('date >=', $month . '-01')
                ->where('date <', date('Y-m-d', strtotime($month . '-01 +1 month')))
                ->where('type', 'Subscription')
                ->get('statements')
                ->result_array();

            if (!empty($existing_subscription)) {
                // Duplicate found - add to duplicate list
                $duplicate_months[] = date('F Y', strtotime($month_date));
            }
        }

        // If ANY duplicates found, reject entire operation
        if (!empty($duplicate_months)) {
            $this->session->set_flashdata('flash_message_error', 'Subscription payment cannot be processed. Duplicate subscription(s) found for: ' . implode(', ', $duplicate_months) . '. Please remove these months and try again.');
            redirect(base_url() . 'index.php?burial/payments', 'refresh');
        }

        // SECOND: All months are unique - now add all subscriptions
        $subscription_count = 0;
        $successful_months = [];

        foreach ($months as $month) {
            // Validate month format (YYYY-MM)
            if (!preg_match('/^\d{4}-\d{2}$/', $month)) {
                continue;
            }

            // Parse month to create date (first day of month)
            $month_date = $month . '-01'; // First day of month

            // Create statement record for subscription payment
            $statement_data = [
                'memberid' => $member_id,
                'date' => $month_date,  // Use first day of subscribed month
                'description' => $description . ' - ' . date('F Y', strtotime($month_date)),
                'amount' => $amount_per_month,
                'type' => 'Subscription',
                'status' => "Paid",
                'source' => $source,
                'user' => $user_id,
                'created_at' => date('Y-m-d')
            ];

            $this->db->insert('statements', $statement_data);
            $subscription_count++;
            $successful_months[] = date('F Y', strtotime($month_date));
        }

        // Build success message
        if ($subscription_count > 0) {
            $message = 'Subscription payment(s) added successfully for: ' . implode(', ', $successful_months);
            $this->session->set_flashdata('flash_message', $message);
        } else {
            $this->session->set_flashdata('flash_message_error', 'No subscriptions were added');
        }

        redirect(base_url() . 'index.php?burial/payments', 'refresh');
    }
  
}