<?php
$claim = $claim ?? [];
$documents = $documents ?? [];

$member = $this->db->get_where('members', array('id' => $claim['member_id'] ?? 0))->row();
$member_name = $member ? trim($member->surname . ' ' . $member->name) : '-';

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

$paid_by_name = '-';
if (!empty($claim['paid_by'])) {
    $admin = $this->db->get_where('admin', array('id' => $claim['paid_by']))->row();
    $paid_by_name = $admin ? $admin->name : '-';
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
        body { padding: 20px; }
        .header { border-bottom: 2px solid #333; margin-bottom: 20px; padding-bottom: 10px; }
        .logo { max-height: 60px; }
        .table th { width: 40%; }
        .section-title { margin-top: 18px; margin-bottom: 8px; font-weight: 700; }
        .signatures { margin-top: 40px; page-break-inside: avoid; }
        .signature-block { margin-bottom: 28px; }
        .signature-line {
            border-bottom: 1px dotted #333;
            min-height: 32px;
            margin: 8px 0 6px;
        }
        .signature-label {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        .signature-date {
            font-size: 11px;
            color: #555;
            margin-top: 4px;
        }
        .approved-heading {
            margin: 30px 0 18px;
            font-weight: 700;
            font-size: 14px;
            text-transform: uppercase;
            border-top: 1px solid #ccc;
            padding-top: 16px;
        }
        @media print {
            .no-print { display: none !important; }
            body { padding: 0; }
            a[href]:after { content: none !important; }
        }
    </style>
</head>
<body>
    <div class="no-print text-right" style="margin-bottom: 10px;">
        <button class="btn btn-primary" onclick="window.print()">
            <i class="fa fa-print"></i> Print Claim Details
        </button>
        <a href="<?php echo base_url('index.php?burial/claims'); ?>" class="btn btn-default">Back to Claims</a>
    </div>

    <div class="header row">
        <div class="col-xs-2">
            <img src="<?php echo base_url('uploads/logo.png'); ?>" alt="SNAT Logo" class="logo">
        </div>
        <div class="col-xs-10">
            <h3 style="margin: 0;">SNAT Burial Claim Details</h3>
            <small>Claim #<?php echo htmlspecialchars($claim['id'] ?? '—'); ?> &mdash; Generated on <?php echo date('d-m-Y H:i:s'); ?></small>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-4">
            <h4 class="section-title">Member & Beneficiary</h4>
            <table class="table table-bordered">
                <tr><th>Claim ID</th><td><?php echo htmlspecialchars($claim['id'] ?? '-'); ?></td></tr>
                <tr><th>Member</th><td><?php echo htmlspecialchars($member_name); ?></td></tr>
                <tr><th>Beneficiary</th><td><?php echo htmlspecialchars($beneficiary_name); ?></td></tr>
                <tr><th>National ID</th><td><?php echo htmlspecialchars($claim['national_id'] ?? '-'); ?></td></tr>
            </table>
        </div>

        <div class="col-xs-4">
            <h4 class="section-title">Burial Information</h4>
            <table class="table table-bordered">
                <tr><th>Place of Burial</th><td><?php echo htmlspecialchars($claim['place_of_burial'] ?? '-'); ?></td></tr>
                <tr><th>Date of Burial</th><td><?php echo !empty($claim['date_of_burial']) ? date('d-m-Y', strtotime($claim['date_of_burial'])) : '-'; ?></td></tr>
                <tr><th>Nominee Name</th><td><?php echo htmlspecialchars($nominee_name); ?></td></tr>
                <tr><th>Claim Date</th><td><?php echo !empty($claim['claim_date']) ? date('d-m-Y', strtotime($claim['claim_date'])) : '-'; ?></td></tr>
            </table>
        </div>

        <div class="col-xs-4">
            <h4 class="section-title">Mortuary Information</h4>
            <table class="table table-bordered">
                <tr><th>Mortuary</th><td><?php echo htmlspecialchars($claim['mortuary'] ?? '-'); ?></td></tr>
                <tr><th>Date of Entry</th><td><?php echo !empty($claim['date_of_entry']) ? date('d-m-Y', strtotime($claim['date_of_entry'])) : '-'; ?></td></tr>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-6">
            <h4 class="section-title">Claim Status & Dates</h4>
            <table class="table table-bordered">
                <tr>
                    <th>Status</th>
                    <td>
                        <span class="label label-<?php echo $status_class; ?>">
                            <?php echo htmlspecialchars($claim['status'] ?? '-'); ?>
                        </span>
                    </td>
                </tr>
                <tr><th>Approved Date</th><td><?php echo !empty($claim['approved_date']) ? date('d-m-Y', strtotime($claim['approved_date'])) : '-'; ?></td></tr>
                <tr><th>Payment Date</th><td><?php echo !empty($claim['payment_date']) ? date('d-m-Y', strtotime($claim['payment_date'])) : '-'; ?></td></tr>
            </table>
        </div>

        <div class="col-xs-6">
            <h4 class="section-title">Payment Information</h4>
            <table class="table table-bordered">
                <tr><th>Amount</th><td><strong><?php echo isset($claim['amount']) ? number_format($claim['amount'], 2) : '-'; ?></strong></td></tr>
                <tr><th>Bank</th><td><?php echo htmlspecialchars($claim['bank'] ?? '-'); ?></td></tr>
                <tr><th>Account</th><td><?php echo htmlspecialchars($claim['account'] ?? '-'); ?></td></tr>
            </table>
        </div>
    </div>

    <h4 class="section-title">Processing Information</h4>
    <table class="table table-bordered">
        <tr><th>Processed By</th><td><?php echo htmlspecialchars($processed_by_name); ?></td></tr>
        <tr><th>Approved By</th><td><?php echo htmlspecialchars($approved_by_name); ?></td></tr>
        <tr><th>Paid By</th><td><?php echo htmlspecialchars($paid_by_name); ?></td></tr>
        <tr><th>Created At</th><td><?php echo !empty($claim['created_at']) ? date('d-m-Y H:i:s', strtotime($claim['created_at'])) : '-'; ?></td></tr>
        <tr><th>Updated At</th><td><?php echo !empty($claim['updated_at']) ? date('d-m-Y H:i:s', strtotime($claim['updated_at'])) : '-'; ?></td></tr>
        <tr><th>Notes</th><td><?php echo nl2br(htmlspecialchars($claim['notes'] ?? '-')); ?></td></tr>
    </table>

    <?php if (!empty($documents)): ?>
        <h4 class="section-title">Documents</h4>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; foreach ($documents as $doc): ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo htmlspecialchars($doc['description'] ?? 'N/A'); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <div class="signatures">
        <div class="row">
            <div class="col-xs-4">
                <div class="signature-block">
                    <div class="signature-line"></div>
                    <div class="signature-label">Claimant</div>
                    <div class="signature-date">Date: _______________________</div>
                </div>
            </div>
            <div class="col-xs-4">
                <div class="signature-block">
                    <div class="signature-line"></div>
                    <div class="signature-label">Prepared By</div>
                    <div class="signature-date">Date: _______________________</div>
                </div>
            </div>
            <div class="col-xs-4">
                <div class="signature-block">
                    <div class="signature-line"></div>
                    <div class="signature-label">Reviewed By</div>
                    <div class="signature-date">Date: _______________________</div>
                </div>
            </div>
        </div>

        <div class="approved-heading">Approved Signatures</div>

        <div class="row">
            <div class="col-xs-4">
                <div class="signature-block">
                    <div class="signature-line"></div>
                    <div class="signature-label">Chairperson</div>
                    <div class="signature-date">Date: _______________________</div>
                </div>
            </div>
            <div class="col-xs-4">
                <div class="signature-block">
                    <div class="signature-line"></div>
                    <div class="signature-label">Secretary</div>
                    <div class="signature-date">Date: _______________________</div>
                </div>
            </div>
            <div class="col-xs-4">
                <div class="signature-block">
                    <div class="signature-line"></div>
                    <div class="signature-label">Treasurer</div>
                    <div class="signature-date">Date: _______________________</div>
                </div>
            </div>
        </div>
    </div>

    <div class="no-print" style="margin-top: 25px;">
        <?php if (($claim['status'] ?? '') === 'PENDING'): ?>
            <a href="<?php echo base_url('index.php?burial/claims/approve/' . ($claim['id'] ?? '')); ?>" class="btn btn-success">Approve</a>
            <a href="<?php echo base_url('index.php?burial/claims/reject/' . ($claim['id'] ?? '')); ?>" class="btn btn-danger">Reject</a>
        <?php elseif (($claim['status'] ?? '') === 'APPROVED'): ?>
            <a href="<?php echo base_url('index.php?burial/approved_claims/pay/' . ($claim['id'] ?? '')); ?>" class="btn btn-primary">Pay</a>
            <span class="label label-success" style="margin-left:10px;">Status: APPROVED</span>
        <?php else: ?>
            <span class="label label-default">Status: <?php echo htmlspecialchars($claim['status'] ?? '-'); ?></span>
        <?php endif; ?>
    </div>
</body>
</html>
