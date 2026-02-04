<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Claims_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get all claims
     * @return array
     */
    public function get_all_claims()
    {
        $columns = [
            'id', 'member_id', 'claim_type','beneficiary_id', 'national_id', 'amount', 
            'claim_date', 'place_of_burial', 'date_of_burial', 'approved_date', 
            'status', 'bank', 'account', 'payment_date', 'processed_by', 
            'approved_by', 'notes', 'created_at', 'updated_at'
        ];
        $this->db->select(implode(',', $columns));
        return $this->db->get('claims')->result_array();
    }

    /**
     * Get single claim by ID
     * @param int $claim_id
     * @return array
     */
    public function get_claim($claim_id)
    {
        $columns = [
            'id', 'member_id', 'beneficiary_id', 'national_id', 'amount', 
            'claim_date', 'place_of_burial', 'date_of_burial', 'approved_date', 
            'status', 'bank', 'account', 'payment_date', 'processed_by', 
            'approved_by', 'notes', 'created_at', 'updated_at'
        ];
        $this->db->select(implode(',', $columns));
        return $this->db->where('id', $claim_id)->get('claims')->row_array();
    }

    /**
     * Get claims by member ID
     * @param int $member_id
     * @return array
     */
    public function get_claims_by_member($member_id)
    {
        return $this->db->where('member_id', $member_id)->get('claims')->result_array();
    }

    /**
     * Get claims by status
     * @param string $status
     * @return array
     */
    public function get_claims_by_status($status)
    {
        return $this->db->where('status', $status)->get('claims')->result_array();
    }

    /**
     * Create claim
     * @param array $data
     * @return int last insert id
     */
    public function create_claim($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        $this->db->insert('claims', $data);
        return $this->db->insert_id();
    }

    /**
     * Update claim
     * @param int $claim_id
     * @param array $data
     * @return bool
     */
    public function update_claim($claim_id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        $this->db->where('id', $claim_id);
        return $this->db->update('claims', $data);
    }

    /**
     * Delete claim
     * @param int $claim_id
     * @return bool
     */
    public function delete_claim($claim_id)
    {
        // Delete associated documents first
        $this->db->where('claim_id', $claim_id);
        $this->db->delete('claims_documents');
        
        // Delete claim
        $this->db->where('id', $claim_id);
        return $this->db->delete('claims');
    }

    /**
     * Get all claim documents
     * @return array
     */
    public function get_all_documents()
    {
        return $this->db->get('claims_documents')->result_array();
    }

    /**
     * Get documents by claim ID
     * @param int $claim_id
     * @return array
     */
    public function get_documents_by_claim($claim_id)
    {
        return $this->db->where('claim_id', $claim_id)->get('claims_documents')->result_array();
    }

    /**
     * Get document by ID
     * @param int $document_id
     * @return array
     */
    public function get_document($document_id)
    {
        return $this->db->where('id', $document_id)->get('claims_documents')->row_array();
    }

    /**
     * Upload claim document
     * @param array $data
     * @return int last insert id
     */
    public function upload_document($data)
    {
        $data['timestamp'] = date('Y-m-d H:i:s');
        
        $this->db->insert('claims_documents', $data);
        return $this->db->insert_id();
    }

    /**
     * Delete claim document
     * @param int $document_id
     * @return bool
     */
    public function delete_document($document_id)
    {
        $this->db->where('id', $document_id);
        return $this->db->delete('claims_documents');
    }

    /**
     * Check if claim exists for member and beneficiary on date
     * @param int $member_id
     * @param int $beneficiary_id
     * @param string $claim_date
     * @return bool
     */
    public function claim_exists($member_id, $beneficiary_id, $claim_date)
    {
        $this->db->where('member_id', $member_id)
                 ->where('beneficiary_id', $beneficiary_id)
                 ->where('claim_date', $claim_date);
        
        return $this->db->get('claims')->num_rows() > 0;
    }

    /**
     * Get claim statistics
     * @return array
     */
    public function get_claim_statistics()
    {
        $stats = [];
        
        // Count by status
        $statuses = ['PENDING', 'APPROVED', 'REJECTED', 'PAID'];
        foreach ($statuses as $status) {
            $stats[$status] = $this->db->where('status', $status)->get('claims')->num_rows();
        }
        
        // Total claims
        $stats['total'] = $this->db->get('claims')->num_rows();
        
        // Total amount claimed
        $this->db->select('SUM(amount) as total_amount');
        $result = $this->db->get('claims')->row_array();
        $stats['total_amount'] = $result['total_amount'] ?? 0;
        
        return $stats;
    }

    /**
     * Get valid claim document types (enums)
     * @return array
     */
    public function get_document_types()
    {
        return [
            'ID OF Policy Holder',
            'ID OF Deceased',
            'Passport',
            'Death Certificate',
            'Payslip',
            'Passbook'
        ];
    }

    /**
     * Get valid claim statuses (enums)
     * @return array
     */
    public function get_claim_statuses()
    {
        return [
            'PENDING',
            'APPROVED',
            'REJECTED',
            'PAID'
        ];
    }

}
