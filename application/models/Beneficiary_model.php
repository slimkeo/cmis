<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Beneficiary_model extends CI_Model
{
    /**
     * Statuses that should NOT be counted as payable and do NOT generate fees
     */
    private $non_payable_statuses = [
        'BENEFITTED - REPLACED',
        'DECEASED - REPLACED',
        'DELETED'
    ];

    public function get_by_member($member_id)
    {
        return $this->db
            ->where('memberid', $member_id)
            ->get('beneficiaries')
            ->result_array();
    }

    /**
     * Returns counts and the calculated beneficiary fee for payable beneficiaries only
     */
    public function get_payable_summary($member_id)
    {
        $beneficiaries = $this->get_by_member($member_id);

        $payable_count = 0;
        $payable_fee   = 0.0;

        $fees = $this->get_fee_settings();

        foreach ($beneficiaries as $ben) {
            $status = trim($ben['status'] ?? '');

            if (in_array($status, $this->non_payable_statuses, true)) {
                continue;
            }

            $payable_count++;

            if ($ben['is_spouse'] == 1) {
                $payable_fee += $fees['spouse_fee'];
            } else {
                $payable_fee += $fees['member_fee'];
            }
        }

        return [
            'total_beneficiaries'     => count($beneficiaries),
            'payable_beneficiaries'   => $payable_count,
            'payable_beneficiary_fee' => $payable_fee,
        ];
    }

    /**
     * Returns the total monthly amount the member should pay
     * (principal + beneficiary fees + minimum rule)
     */
    public function get_total_monthly_fee($member_id)
    {
        $fees = $this->get_fee_settings();
        $summary = $this->get_payable_summary($member_id);

        $total = $fees['principal_fee'] + $summary['payable_beneficiary_fee'];

        // Minimum fee rule
        if ($total < 105) {
            $total = 105;
        }

        return $total;
    }

    /**
     * Load all fee settings in one query
     */
    public function get_fee_settings()
    {
        $rows = $this->db
            ->where_in('type', ['principal_fee', 'member_fee', 'spouse_fee'])
            ->get('settings')
            ->result_array();

        $fees = [
            'principal_fee' => 0.0,
            'member_fee'    => 0.0,
            'spouse_fee'    => 0.0,
        ];

        foreach ($rows as $row) {
            $fees[$row['type']] = (float) $row['description'];
        }

        return $fees;
    }

    /**
     * Determine maturity status for a single beneficiary
     */
    public function is_matured($beneficiary_id)
    {
        $b = $this->db
            ->where('id', $beneficiary_id)
            ->get('beneficiaries')
            ->row();

        if (!$b) {
            return '';
        }

        $status = strtoupper(trim($b->status));

        if (in_array($status, ['BENEFITTED', 'BENEFITTED-REPLACED'], true)) {
            return '';
        }

        if ($status === 'REPLACEE') {
            $has_replaced = $this->db
                ->where('memberid', $b->memberid)
                ->where('status', 'BENEFITTED-REPLACED')
                ->count_all_results('beneficiaries');

            return $has_replaced > 0 ? 'MATURED' : 'WAITING';
        }

        if (empty($b->submission_date)) {
            return 'WAITING';
        }

        $submitted = strtotime($b->submission_date);
        $maturity  = strtotime('+1 year', $submitted);

        return (time() >= $maturity) ? 'MATURED' : 'WAITING';
    }
}