<?php
$claim = $claim ?? [];

$member = $this->db->get_where('members', array('id' => $claim['member_id'] ?? 0))->row();
$member_name = $member ? trim($member->surname . ' ' . $member->name) : '-';
$member_id = $member ? trim($member->id) : '-';
$member_cell = $member && !empty($member->cellnumber) ? $member->cellnumber : '-';
$member_school = $member && !empty($member->schoolcode) ? $member->schoolcode : '-';
$member_resident = $member && !empty($member->resident) ? $member->resident : '-';

$beneficiary = $this->db->get_where('beneficiaries', array('id' => $claim['beneficiary_id'] ?? 0))->row();
$beneficiary_name = $beneficiary ? $beneficiary->fullname : '-';

$nominee = $this->db->get_where('nominee', array('id' => $claim['nominee_id'] ?? 0))->row();
$nominee_name = $nominee ? $nominee->fullname : '-';

// Claimant: member for beneficiary claims, nominee for member/policy-holder claims
$claim_type = strtoupper(trim((string)($claim['claim_type'] ?? 'BENEFICIARY')));
if ($claim_type === 'NOMINEE' || (!empty($claim['nominee_id']) && empty($claim['beneficiary_id']))) {
    $claimant_name = $nominee_name;
} else {
    $claimant_name = $member_name;
}

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
        @page { size: A4 portrait; margin: 12mm; }
        html, body {
            font-size: 13px;
            line-height: 1.45;
            padding: 0;
            margin: 0;
        }
        .print-sheet {
            width: 100%;
            max-width: 186mm;
            min-height: 273mm;
            margin: 0 auto;
            padding: 4mm 2mm;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
        }
        .print-page {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 265mm;
        }
        .print-top { flex: 0 0 auto; }
        .print-middle { flex: 1 1 auto; display: flex; flex-direction: column; justify-content: center; padding: 4mm 0; }
        .print-bottom { flex: 0 0 auto; margin-top: auto; }
        .header {
            border-bottom: 2px solid #333;
            margin-bottom: 10px;
            padding-bottom: 8px;
        }
        .logo { max-height: 60px; }
        .header h3 { font-size: 22px; margin: 0 0 6px; font-weight: 700; }
        .header small { font-size: 12px; }
        .section-title {
            margin: 14px 0 8px;
            font-size: 14px;
            font-weight: 700;
        }
        .details-row .section-title {
            margin: 8px 0 4px;
            font-size: 11px;
        }
        .details-row { margin-bottom: 4px; }
        .table {
            margin-bottom: 12px;
            font-size: 12.5px;
        }
        .table-details {
            margin-bottom: 6px;
            font-size: 10px;
            line-height: 1.3;
        }
        .table-details > tbody > tr > th,
        .table-details > tbody > tr > td {
            padding: 4px 6px;
            vertical-align: middle;
        }
        .table-details > tbody > tr > th {
            width: 42%;
            font-weight: 600;
            font-size: 9.5px;
        }
        .table > thead > tr > th,
        .table > tbody > tr > th,
        .table > tbody > tr > td {
            padding: 9px 10px;
            vertical-align: middle;
        }
        .table > tbody > tr > th {
            width: 38%;
            font-weight: 600;
        }
        .table-processing {
            margin-top: 6px;
        }
        .table-processing > thead > tr > th {
            background: #f0f0f0;
            font-weight: 700;
            font-size: 13px;
            padding: 12px 10px;
        }
        .table-processing > tbody > tr > th,
        .table-processing > tbody > tr > td {
            padding: 14px 10px;
        }
        .table-processing .col-details { width: 42%; }
        .table-processing .col-signature { width: 38%; }
        .table-processing .signature-line {
            min-height: 40px;
        }
        .signature-line {
            border-bottom: 2px dotted #333;
            min-height: 36px;
            margin: 6px 0;
        }
        .signatures-approved {
            page-break-inside: avoid;
            padding-top: 16px;
        }
        .approved-heading {
            margin: 0 0 20px;
            font-weight: 700;
            font-size: 14px;
            text-transform: uppercase;
            border-top: 2px solid #333;
            padding-top: 14px;
        }
        .signature-block { padding: 0 12px; }
        .signatures-approved .signature-line {
            min-height: 52px;
            margin-bottom: 10px;
        }
        .signature-label {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .notes-cell {
            font-size: 12px;
            min-height: 56px;
            vertical-align: top !important;
        }
        .table-processing tr.notes-row > th,
        .table-processing tr.notes-row > td {
            padding-top: 16px;
            padding-bottom: 16px;
        }
        @media print {
            .no-print { display: none !important; }
            .print-sheet {
                padding: 0;
                max-width: none;
                min-height: 273mm;
            }
            .print-page { min-height: 265mm; }
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

        <div class="print-page">
        <div class="print-top">
        <div class="header row">
            <div class="col-xs-2">
                <img src="<?php echo base_url('uploads/logo.png'); ?>" alt="SNAT Logo" class="logo">
            </div>
            <div class="col-xs-10">
                <h3>SNAT Burial Claim Details</h3>
                <small>Claim #<?php echo htmlspecialchars($claim['id'] ?? '—'); ?> &mdash; <?php echo date('d-m-Y H:i'); ?></small>
            </div>
        </div>

        <div class="row details-row">
            <div class="col-xs-4">
                <h4 class="section-title">Member & Beneficiary</h4>
                <table class="table table-bordered table-details">
                    <tr><th>Claim ID</th><td><?php echo htmlspecialchars($claim['id'] ?? '-'); ?></td></tr>
                    <tr><th>Member</th><td><?php echo htmlspecialchars($member_name.'- '.$member_id); ?></td></tr>
                    <tr><th>Cell Number</th><td><?php echo htmlspecialchars($member_cell); ?></td></tr>
                    <tr><th>School Code</th><td><?php echo htmlspecialchars($member_school); ?></td></tr>
                    <tr><th>Residence</th><td><?php echo htmlspecialchars($member_resident); ?></td></tr>
                    <tr><th>Beneficiary</th><td><?php echo htmlspecialchars($beneficiary_name); ?></td></tr>
                    <tr><th>National ID</th><td><?php echo htmlspecialchars($claim['national_id'] ?? '-'); ?></td></tr>
                </table>
            </div>

            <div class="col-xs-4">
                <h4 class="section-title">Burial Information</h4>
                <table class="table table-bordered table-details">
                    <tr><th>Place of Burial</th><td><?php echo htmlspecialchars($claim['place_of_burial'] ?? '-'); ?></td></tr>
                    <tr><th>Date of Burial</th><td><?php echo !empty($claim['date_of_burial']) ? date('d-m-Y', strtotime($claim['date_of_burial'])) : '-'; ?></td></tr>
                    <tr><th>Nominee</th><td><?php echo htmlspecialchars($nominee_name); ?></td></tr>
                    <tr><th>Claim Date</th><td><?php echo !empty($claim['claim_date']) ? date('d-m-Y', strtotime($claim['claim_date'])) : '-'; ?></td></tr>
                </table>
            </div>

            <div class="col-xs-4">
                <h4 class="section-title">Mortuary</h4>
                <table class="table table-bordered table-details">
                    <tr><th>Mortuary</th><td><?php echo htmlspecialchars($claim['mortuary'] ?? '-'); ?></td></tr>
                    <tr><th>Date of Entry</th><td><?php echo !empty($claim['date_of_entry']) ? date('d-m-Y', strtotime($claim['date_of_entry'])) : '-'; ?></td></tr>
                </table>
                <h4 class="section-title">Payment</h4>
                <table class="table table-bordered table-details">
                    <tr><th>Amount</th><td><strong><?php echo isset($claim['amount']) ? number_format($claim['amount'], 2) : '-'; ?></strong></td></tr>
                    <tr><th>Bank</th><td><?php echo htmlspecialchars($claim['bank'] ?? '-'); ?></td></tr>
                    <tr><th>Account</th><td><?php echo htmlspecialchars($claim['account'] ?? '-'); ?></td></tr>
                    <tr><th>Paid</th><td><?php echo !empty($claim['payment_date']) ? date('d-m-Y', strtotime($claim['payment_date'])) : '-'; ?></td></tr>
                </table>
            </div>
        </div>
        </div>

        <div class="print-middle">
        <h4 class="section-title">Processing Information</h4>
        <table class="table table-bordered table-processing">
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
                    <td><?php echo htmlspecialchars($claimant_name); ?></td>
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
                <tr class="notes-row">
                    <th>Notes</th>
                    <td colspan="2" class="notes-cell"><?php echo nl2br(htmlspecialchars($claim['notes'] ?? '-')); ?></td>
                </tr>
            </tbody>
        </table>
        </div>

        <div class="print-bottom">
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
        </div>
        </div>
    </div>
</body>
</html>
