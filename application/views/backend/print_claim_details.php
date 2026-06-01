<?php
$claim = $claim ?? [];

$member = $this->db->get_where('members', array('id' => $claim['member_id'] ?? 0))->row();
$member_name = $member ? trim($member->surname . ' ' . $member->name) : '-';
$member_cell = $member && !empty($member->cellnumber) ? $member->cellnumber : '-';
$member_school = $member && !empty($member->schoolcode) ? $member->schoolcode : '-';
$member_resident = $member && !empty($member->resident) ? $member->resident : '-';

$beneficiary = $this->db->get_where('beneficiaries', array('id' => $claim['beneficiary_id'] ?? 0))->row();
$beneficiary_name = $beneficiary ? $beneficiary->fullname : '-';

$nominee = $this->db->get_where('nominee', array('id' => $claim['nominee_id'] ?? 0))->row();
$nominee_name = $nominee ? $nominee->fullname : '-';

$processed_by_name = '-';
if (!empty($claim['processed_by'])) {
    $admin = $this->db->get_where('admin', array('id' => $claim['processed_by']))->row();
    $processed_by_name = $admin ? $admin->name : '-';
}

$approved_by_name = '-';
if (!empty($claim['approved_by'])) {
    $admin = $this->db->get_where('admin', array('id' => $claim['approved_by']))->row();
    $approved_by_name = $admin ? $admin->name : '-';
}

$status_class = 'default';
if (($claim['status'] ?? '') === 'PENDING') {
    $status_class = 'warning';
} elseif (($claim['status'] ?? '') === 'APPROVED') {
    $status_class = 'success';
} elseif (($claim['status'] ?? '') === 'REJECTED') {
    $status_class = 'danger';
} elseif (($claim['status'] ?? '') === 'PAID') {
    $status_class = 'info';
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Claim Details #<?php echo htmlspecialchars($claim['id'] ?? ''); ?> | Print</title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/vendor/bootstrap/css/bootstrap.css"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/vendor/font-awesome/css/font-awesome.css"/>
    <style>
        @page { size: A4 portrait; margin: 10mm; }
        html, body {
            font-size: 11px;
            line-height: 1.25;
            padding: 0;
            margin: 0;
        }
        .print-sheet {
            max-width: 190mm;
            margin: 0 auto;
            padding: 8px 10px;
        }
        .header {
            border-bottom: 1px solid #333;
            margin-bottom: 8px;
            padding-bottom: 6px;
        }
        .logo { max-height: 48px; }
        .header h3 { font-size: 16px; margin: 0 0 2px; }
        .header small { font-size: 10px; }
        .section-title {
            margin: 8px 0 4px;
            font-size: 11px;
            font-weight: 700;
        }
        .table {
            margin-bottom: 6px;
            font-size: 10.5px;
        }
        .table > thead > tr > th,
        .table > tbody > tr > th,
        .table > tbody > tr > td {
            padding: 3px 6px;
            vertical-align: middle;
        }
        .table > tbody > tr > th {
            width: 38%;
            font-weight: 600;
        }
        .table-processing > thead > tr > th {
            background: #f5f5f5;
            font-weight: 700;
            font-size: 10px;
        }
        .table-processing .col-details { width: 42%; }
        .table-processing .col-signature { width: 38%; }
        .signature-line {
            border-bottom: 1px dotted #333;
            min-height: 22px;
            margin: 2px 0;
        }
        .signatures-approved {
            margin-top: 10px;
            page-break-inside: avoid;
        }
        .approved-heading {
            margin: 0 0 6px;
            font-weight: 700;
            font-size: 11px;
            text-transform: uppercase;
            border-top: 1px solid #ccc;
            padding-top: 8px;
        }
        .signature-block { margin-bottom: 0; }
        .signature-label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            margin-top: 2px;
        }
        .notes-cell { font-size: 10px; max-height: 36px; overflow: hidden; }
        @media print {
            .no-print { display: none !important; }
            .print-sheet { padding: 0; max-width: none; }
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
    </style>
</head>
<body>
    <div class="print-sheet">
        <div class="no-print text-right" style="margin-bottom: 6px;">
            <button class="btn btn-primary btn-sm" onclick="window.print()">
                <i class="fa fa-print"></i> Print
            </button>
            <a href="<?php echo base_url('index.php?burial/claims'); ?>" class="btn btn-default btn-sm">Back</a>
        </div>

        <div class="header row">
            <div class="col-xs-2">
                <img src="<?php echo base_url('uploads/logo.png'); ?>" alt="SNAT Logo" class="logo">
            </div>
            <div class="col-xs-10">
                <h3>SNAT Burial Claim Details</h3>
                <small>Claim #<?php echo htmlspecialchars($claim['id'] ?? '—'); ?> &mdash; <?php echo date('d-m-Y H:i'); ?></small>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-4">
                <h4 class="section-title">Member & Beneficiary</h4>
                <table class="table table-bordered table-condensed">
                    <tr><th>Claim ID</th><td><?php echo htmlspecialchars($claim['id'] ?? '-'); ?></td></tr>
                    <tr><th>Member</th><td><?php echo htmlspecialchars($member_name); ?></td></tr>
                    <tr><th>Cell Number</th><td><?php echo htmlspecialchars($member_cell); ?></td></tr>
                    <tr><th>School Code</th><td><?php echo htmlspecialchars($member_school); ?></td></tr>
                    <tr><th>Residence</th><td><?php echo htmlspecialchars($member_resident); ?></td></tr>
                    <tr><th>Beneficiary</th><td><?php echo htmlspecialchars($beneficiary_name); ?></td></tr>
                    <tr><th>National ID</th><td><?php echo htmlspecialchars($claim['national_id'] ?? '-'); ?></td></tr>
                </table>
            </div>

            <div class="col-xs-4">
                <h4 class="section-title">Burial Information</h4>
                <table class="table table-bordered table-condensed">
                    <tr><th>Place of Burial</th><td><?php echo htmlspecialchars($claim['place_of_burial'] ?? '-'); ?></td></tr>
                    <tr><th>Date of Burial</th><td><?php echo !empty($claim['date_of_burial']) ? date('d-m-Y', strtotime($claim['date_of_burial'])) : '-'; ?></td></tr>
                    <tr><th>Nominee</th><td><?php echo htmlspecialchars($nominee_name); ?></td></tr>
                    <tr><th>Claim Date</th><td><?php echo !empty($claim['claim_date']) ? date('d-m-Y', strtotime($claim['claim_date'])) : '-'; ?></td></tr>
                </table>
            </div>

            <div class="col-xs-4">
                <h4 class="section-title">Mortuary</h4>
                <table class="table table-bordered table-condensed">
                    <tr><th>Mortuary</th><td><?php echo htmlspecialchars($claim['mortuary'] ?? '-'); ?></td></tr>
                    <tr><th>Date of Entry</th><td><?php echo !empty($claim['date_of_entry']) ? date('d-m-Y', strtotime($claim['date_of_entry'])) : '-'; ?></td></tr>
                </table>
                <h4 class="section-title">Payment</h4>
                <table class="table table-bordered table-condensed">
                    <tr><th>Amount</th><td><strong><?php echo isset($claim['amount']) ? number_format($claim['amount'], 2) : '-'; ?></strong></td></tr>
                    <tr><th>Bank</th><td><?php echo htmlspecialchars($claim['bank'] ?? '-'); ?></td></tr>
                    <tr><th>Account</th><td><?php echo htmlspecialchars($claim['account'] ?? '-'); ?></td></tr>
                    <tr>
                        <th>Status</th>
                        <td><span class="label label-<?php echo $status_class; ?>"><?php echo htmlspecialchars($claim['status'] ?? '-'); ?></span></td>
                    </tr>
                    <tr><th>Approved</th><td><?php echo !empty($claim['approved_date']) ? date('d-m-Y', strtotime($claim['approved_date'])) : '-'; ?></td></tr>
                    <tr><th>Paid</th><td><?php echo !empty($claim['payment_date']) ? date('d-m-Y', strtotime($claim['payment_date'])) : '-'; ?></td></tr>
                </table>
            </div>
        </div>

        <h4 class="section-title">Processing Information</h4>
        <table class="table table-bordered table-condensed table-processing">
            <thead>
                <tr>
                    <th>Role</th>
                    <th class="col-details">Details</th>
                    <th class="col-signature">Signature</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>Claimant</th>
                    <td><?php echo htmlspecialchars($beneficiary_name); ?></td>
                    <td><div class="signature-line"></div></td>
                </tr>
                <tr>
                    <th>Prepared By</th>
                    <td><?php echo htmlspecialchars($processed_by_name); ?></td>
                    <td><div class="signature-line"></div></td>
                </tr>
                <tr>
                    <th>Reviewed By</th>
                    <td><?php echo htmlspecialchars($approved_by_name); ?></td>
                    <td><div class="signature-line"></div></td>
                </tr>
                <tr>
                    <th>Notes</th>
                    <td colspan="2" class="notes-cell"><?php echo nl2br(htmlspecialchars($claim['notes'] ?? '-')); ?></td>
                </tr>
            </tbody>
        </table>

        <div class="signatures-approved">
            <div class="approved-heading">Approved Signatures</div>
            <div class="row">
                <div class="col-xs-4">
                    <div class="signature-block">
                        <div class="signature-line"></div>
                        <div class="signature-label">Chairperson</div>
                    </div>
                </div>
                <div class="col-xs-4">
                    <div class="signature-block">
                        <div class="signature-line"></div>
                        <div class="signature-label">Secretary</div>
                    </div>
                </div>
                <div class="col-xs-4">
                    <div class="signature-block">
                        <div class="signature-line"></div>
                        <div class="signature-label">Treasurer</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="no-print" style="margin-top: 12px;">
            <?php if (($claim['status'] ?? '') === 'PENDING'): ?>
                <a href="<?php echo base_url('index.php?burial/claims/approve/' . ($claim['id'] ?? '')); ?>" class="btn btn-success btn-sm">Approve</a>
                <a href="<?php echo base_url('index.php?burial/claims/reject/' . ($claim['id'] ?? '')); ?>" class="btn btn-danger btn-sm">Reject</a>
            <?php elseif (($claim['status'] ?? '') === 'APPROVED'): ?>
                <a href="<?php echo base_url('index.php?burial/approved_claims/pay/' . ($claim['id'] ?? '')); ?>" class="btn btn-primary btn-sm">Pay</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
