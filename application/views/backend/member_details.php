<?php
// Assuming $member_row is passed from controller or fetched here
$member_row = $this->db->get_where('members', ['id' => $memberid])->row_array();

// Using model methods (preferred)
$beneficiaries = $this->Beneficiary_model->get_by_member($member_row['id']);

$summary = $this->Beneficiary_model->get_payable_summary($member_row['id']);

$total_beneficiaries     = $summary['total_beneficiaries'];
$payable_beneficiaries   = $summary['payable_beneficiaries'];
$beneficiary_fee         = $summary['payable_beneficiary_fee'];

$total_monthly           = $this->Beneficiary_model->get_total_monthly_fee($member_row['id']);

$fees = $this->Beneficiary_model->get_fee_settings();

$principal_fee = $fees['principal_fee'];
$member_fee    = $fees['member_fee'];
$spouse_fee    = $fees['spouse_fee'];

// Payable breakdown
$non_payable_statuses = [
    'BENEFITTED - REPLACED',
    'DECEASED - REPLACED',
    'DELETED'
];

$payable_list = array_filter($beneficiaries, function($b) use ($non_payable_statuses) {
    $status = trim($b['status'] ?? '');
    return !in_array($status, $non_payable_statuses, true);
});

$payable_members_count = count(array_filter($payable_list, fn($b) => $b['is_spouse'] == 0));
$payable_spouses_count = count(array_filter($payable_list, fn($b) => $b['is_spouse'] == 1));
?>

<style>
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, Helvetica, sans-serif;
        color: #222;
    }

    .member-profile {
        background: #fff;
        padding: 30px;
        max-width: 1100px;
        margin: 0 auto;
    }

    .profile-header {
        text-align: center;
        border-bottom: 3px solid #333;
        padding-bottom: 20px;
        margin-bottom: 30px;
    }
    .profile-header h2 {
        margin: 0;
        font-size: 26px;
    }
    .profile-header p {
        margin: 6px 0;
        color: #555;
    }

    .actions {
        text-align: right;
        margin-bottom: 25px;
    }

    .section-title {
        font-size: 20px;
        font-weight: bold;
        color: #222;
        border-bottom: 2px solid #444;
        padding-bottom: 8px;
        margin: 35px 0 15px;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 16px 24px;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        padding: 9px 0;
        border-bottom: 1px solid #eee;
    }

    .info-label {
        font-weight: 600;
        color: #444;
        min-width: 180px;
    }

    .info-value {
        flex: 1;
        text-align: right;
    }

    .summary-box {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        padding: 20px;
        margin-top: 15px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #eee;
    }

    .summary-row.total {
        font-size: 1.15em;
        font-weight: bold;
        border-top: 2px solid #aaa;
        margin-top: 12px;
        padding-top: 14px;
    }

    table.beneficiaries-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    table th, table td {
        border: 1px solid #ccc;
        padding: 10px;
        text-align: left;
    }

    table th {
        background: #f1f3f5;
        font-weight: 600;
    }

    .footer-note {
        margin-top: 60px;
        text-align: center;
        color: #666;
        font-size: 13px;
        line-height: 1.5;
    }

    /* ────────────────────────────────────────────────
       PRINT STYLES
    ──────────────────────────────────────────────── */
    @media print {
        body {
            margin: 0;
            padding: 0;
        }

        .member-profile {
            padding: 20px;
            max-width: none;
            box-shadow: none;
        }

        .actions, .no-print {
            display: none !important;
        }

        .profile-header {
            border-bottom: 2px solid #000;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }

        .section-title {
            border-bottom: 1px solid #000;
            margin-top: 30px;
        }

        .info-row, .summary-row {
            border-bottom: 1px dotted #888;
        }

        table th, table td {
            border: 1px solid #000;
        }

        table th {
            background: #e8e8e8 !important;
        }

        .summary-box {
            border: 1px solid #000;
            background: none;
        }

        .footer-note {
            margin-top: 80px;
            font-size: 11px;
        }
    }
</style>

<div class="member-profile">

    <div class="actions no-print">
        <button onclick="window.print()" class="btn btn-primary">
            <i class="fa fa-print"></i> Print Profile
        </button>
        <a href="<?= base_url('index.php?burial/beneficiaries/'.$member_row['id']) ?>" 
           class="btn btn-info">
            <i class="fa fa-users"></i> Manage Beneficiaries
        </a>
    </div>

    <div class="profile-header">
        <h2>SNAT BURIAL SCHEME</h2>
        <p>Member Profile</p>
        <p>Generated on: <?= date('d M Y H:i') ?></p>
    </div>

    <!-- Member Information -->
    <div class="section-title">Member Information</div>
    <div class="info-grid">
        <div class="info-row">
            <span class="info-label">SNAT Burial Account:</span>
            <span class="info-value"><?= $member_row['id'] ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Full Name:</span>
            <span class="info-value"><?= $member_row['surname'] . ' ' . $member_row['name'] ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">National ID:</span>
            <span class="info-value"><?= $member_row['idnumber'] ?: '—' ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Passbook No:</span>
            <span class="info-value"><?= $member_row['passbook_no'] ?: '—' ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Employee No:</span>
            <span class="info-value"><?= $member_row['employeeno'] ?: 'N/A' ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">TSC No:</span>
            <span class="info-value"><?= $member_row['tscno'] ?: 'N/A' ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Date of Birth:</span>
            <span class="info-value"><?= $member_row['dob'] ?: '—' ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Gender:</span>
            <span class="info-value"><?= $member_row['gender'] ?: '—' ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Cell Number:</span>
            <span class="info-value"><?= $member_row['cellnumber'] ?: '—' ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">School Code:</span>
            <span class="info-value"><?= $member_row['schoolcode'] ?: 'N/A' ?></span>
        </div>
    </div>

    <!-- Financial Summary -->
    <div class="section-title">Monthly Contribution Summary</div>
    <div class="summary-box">
        <div class="summary-row">
            <span>Principal Fee:</span>
            <span>E <?= number_format($principal_fee, 2) ?></span>
        </div>
        <div class="summary-row">
            <span>Total Registered Beneficiaries:</span>
            <span><?= $total_beneficiaries ?></span>
        </div>
        <div class="summary-row">
            <span>Payable Beneficiaries:</span>
            <span><?= $payable_beneficiaries ?></span>
        </div>
        <?php if ($payable_members_count || $payable_spouses_count): ?>
        <div class="summary-row" style="font-size:0.95em; color:#555; padding-left: 20px;">
            <span>→ Members</span>
            <span><?= $payable_members_count ?></span>
        </div>
        <div class="summary-row" style="font-size:0.95em; color:#555; padding-left: 20px;">
            <span>→ Spouses</span>
            <span><?= $payable_spouses_count ?></span>
        </div>
        <?php endif; ?>
        <div class="summary-row">
            <span>Beneficiary Fee (<?= $payable_beneficiaries ?> × E <?= number_format($member_fee, 2) ?>):</span>
            <span>E <?= number_format($beneficiary_fee, 2) ?></span>
        </div>
        <div class="summary-row total">
            <span>Total Monthly Contribution:</span>
            <span>E <?= number_format($total_monthly, 2) ?></span>
        </div>
    </div>

    <!-- Beneficiaries List -->
    <div class="section-title">Beneficiaries (<?= $total_beneficiaries ?>)</div>

    <?php if (!empty($beneficiaries)): ?>
    <table class="beneficiaries-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Full Name</th>
                <th>Relationship</th>
                <th>Gender</th>
                <th>Date of Birth</th>
                <th>Submission Date</th>
                <th>Status</th>
                <th>Status Date</th>
            </tr>
        </thead>
        <tbody>
        <?php $i = 1; foreach ($beneficiaries as $b): ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= htmlspecialchars($b['fullname']) ?></td>
                <td><?= $b['is_spouse'] ? 'Spouse' : 'Member/Child' ?></td>
                <td><?= $b['gender'] ?: '—' ?></td>
                <td><?= $b['dob'] ?: '—' ?></td>
                <td><?= $b['submission_date'] ?: '—' ?></td>
                <td><?= $b['status'] ?: '—' ?></td>
                <td><?= $b['status_date'] ?: '—' ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
    <div style="text-align:center; padding:40px; color:#888; font-style:italic;">
        No beneficiaries registered yet.
    </div>
    <?php endif; ?>

    <div class="footer-note">
        This is a computer-generated document.<br>
        For official records or verification, please contact the SNAT Burial Scheme office.
    </div>

</div>