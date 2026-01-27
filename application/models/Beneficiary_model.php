<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Beneficiary_model extends CI_Model
{
    /* =========================
       GET BENEFICIARIES BY MEMBER
    ========================= */
    public function get_by_member($member_id)
    {
        return $this->db
            ->where('memberid', $member_id)
            ->get('beneficiaries')
            ->result_array();
    }
    /* =========================
       PAYABLE BENEFICIARY COUNT
    ========================= */
    public function get_payable_summary($member_id)
    {
        $beneficiaries = $this->get_by_member($member_id);

        $payable = 0;

        foreach ($beneficiaries as $b) {

            $status = trim($b['status'] ?? '');

            // ❗ Only exclude these
            if (!in_array($status, [
                'BENEFITTED - REPLACED','DECEASED - REPLACED',
                'DELETED'
            ], true)) {
                $payable++;
            }
        }

        return [
            'total_beneficiaries' => count($beneficiaries),
            'payable_beneficiaries' => $payable
        ];
    }

    /* =========================
       BENEFICIARY MATURITY
       1 YEAR RULE
    ========================= */
public function is_matured($beneficiary_id)
{
    $b = $this->db
        ->where('id', $beneficiary_id)
        ->get('beneficiaries')
        ->row();

    if (!$b) {
        return '';
    }

    $status   = strtoupper(trim($b->status));
    $memberid = $b->memberid;

    /* =========================
       NO MATURITY DISPLAY
    ========================= */
    if (in_array($status, [
        'BENEFITTED',
        'BENEFITTED-REPLACED'
    ], true)) {
        return '';
    }

    /* =========================
       REPLACEE LOGIC
    ========================= */
    if ($status === 'REPLACEE') {

        $has_benefitted_replaced = $this->db
            ->where('memberid', $memberid)
            ->where('status', 'BENEFITTED-REPLACED')
            ->count_all_results('beneficiaries');

        return ($has_benefitted_replaced > 0)
            ? 'MATURED'
            : 'WAITING';
    }

    /* =========================
       1 YEAR MATURITY RULE
    ========================= */
    if (empty($b->submission_date)) {
        return 'WAITING';
    }

    $submitted = strtotime($b->submission_date);
    $maturity  = strtotime('+1 year', $submitted);

    return (time() >= $maturity) ? 'MATURED' : 'WAITING';
}
}
