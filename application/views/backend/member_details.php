<?php
/* =========================
   MEMBER
========================= */
$member_data = $this->db
    ->get_where('members', ['id' => $memberid])
    ->result_array();

/* =========================
   LOAD MODEL
========================= */
$this->load->model('Beneficiary_model');

foreach ($member_data as $row):

    /* =========================
       BENEFICIARIES (FROM MODEL)
    ========================= */
    $beneficiaries = $this->Beneficiary_model->get_by_member($row['id']);

    $summary = $this->Beneficiary_model->get_payable_summary($row['id']);

    $beneficiary_count     = $summary['total_beneficiaries'];
    $payable_beneficiaries = $summary['payable_beneficiaries'];

    /* =========================
       FEES
    ========================= */
    $principal_fee = (float) $this->db
        ->get_where('settings', ['type' => 'principal_fee'])
        ->row()->description;

    $member_fee = (float) $this->db
        ->get_where('settings', ['type' => 'member_fee'])
        ->row()->description;

    $beneficiary_fee = $member_fee * $payable_beneficiaries;
    $total_monthly   = $principal_fee + $beneficiary_fee;
?>

<style>
@media print {
    body { margin: 0; padding: 0; }
    .no-print { display: none !important; }
    .print-page { page-break-after: always; }
    .print-page:last-child { page-break-after: auto; }
}
.member-profile { background: #fff; padding: 30px; }
.profile-header { text-align: center; border-bottom: 3px solid #333; padding-bottom: 20px; margin-bottom: 30px; }
.section-title { font-size: 18px; font-weight: bold; border-bottom: 2px solid #333; margin-bottom: 15px; }
.info-row { padding: 6px 0; border-bottom: 1px dotted #ccc; }
.info-label { font-weight: bold; width: 220px; display: inline-block; }
.summary-box { background: #f9f9f9; padding: 15px; border: 1px solid #ddd; }
table { width: 100%; border-collapse: collapse; }
th, td { border: 1px solid #000; padding: 8px; }
th { background: #eee; }
</style>

<div class="no-print text-end mb-3">
    <button onclick="window.print()" class="btn btn-primary">
        <i class="fa fa-print"></i> Print Profile
    </button>
</div>

<!-- PAGE 1 -->

<!-- PAGE 1 -->
<div class="member-profile print-page">
    <div class="profile-header">
        <h2>SNAT BURIAL SCHEME</h2>
        <p>Member Profile</p>
        <p>Generated on: <?php echo date('d-m-Y H:i:s'); ?></p>
    </div>

    <div class="section-title">Member Information</div>
    <div class="info-row"><span class="info-label">Account:</span> <?php echo $row['id']; ?></div>
    <div class="info-row"><span class="info-label">Full Name:</span> <?php echo $row['surname'].' '.$row['name']; ?></div>
    <div class="info-row"><span class="info-label">ID Number:</span> <?php echo $row['idnumber']; ?></div>
    <div class="info-row"><span class="info-label">Passbook No:</span> <?php echo $row['passbook_no']; ?></div>
    <div class="info-row"><span class="info-label">Cell:</span> <?php echo $row['cellnumber']; ?></div>

    <div class="section-title mt-4">Monthly Contribution Summary</div>

    <div class="summary-box">
        <div class="info-row">
            <span class="info-label">Principal Fee:</span>
            E <?php echo number_format($principal_fee, 2); ?>
        </div>

        <div class="info-row">
            <span class="info-label">Total Beneficiaries:</span>
            <?php echo $beneficiary_count; ?>
        </div>

        <div class="info-row">
            <span class="info-label">Payable Beneficiaries:</span>
            <?php echo $payable_beneficiaries; ?>
        </div>

        <div class="info-row">
            <span class="info-label">
                Beneficiary Fee
                (<?php echo $payable_beneficiaries; ?> ×
                E <?php echo number_format($member_fee, 2); ?>):
            </span>
            E <?php echo number_format($beneficiary_fee, 2); ?>
        </div>

        <div class="info-row" style="font-size:16px;font-weight:bold;border-top:2px solid #333;">
            Total Monthly Contribution:
            E <?php echo number_format($total_monthly, 2); ?>
        </div>
    </div>
</div>

<!-- PAGE 2 -->
<div class="member-profile print-page">
    <div class="profile-header">
        <h2>SNAT BURIAL SCHEME</h2>
        <p>Beneficiaries List</p>
    </div>

    <?php if ($beneficiary_count > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Full Name</th>
                    <th>Submission Date</th>
                    <th>Maturity</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; foreach ($beneficiaries as $b): ?>
                <tr>
                    <td><?php echo $i++; ?></td>
                    <td><?php echo $b['fullname']; ?></td>
                    <td><?php echo $b['submission_date']; ?></td>
                    <td>
                        <?php
                            echo $this->Beneficiary_model
                                ->is_matured($b['id']);
                        ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No beneficiaries registered.</p>
    <?php endif; ?>
</div>

<?php endforeach; ?>