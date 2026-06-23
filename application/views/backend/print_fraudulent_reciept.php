<?php
$payment = $payment ?? null;
$total_paid = isset($total_paid) ? (float) $total_paid : 0.00;
$remaining_balance = isset($remaining_balance) ? (float) $remaining_balance : 0.00;
$member_name = $payment ? trim(($payment->surname ?? '') . ' ' . ($payment->name ?? '')) : '-';
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Fraud Recovery Receipt #<?php echo (int) ($payment->payment_id ?? 0); ?></title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/vendor/bootstrap/css/bootstrap.css"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/vendor/font-awesome/css/font-awesome.css"/>
    <style>
        @page { size: A4 portrait; margin: 12mm; }
        body { font-size: 13px; }
        .header { border-bottom: 2px solid #333; margin-bottom: 12px; padding-bottom: 10px; }
        .logo { max-height: 60px; }
        .no-print { margin-bottom: 10px; }
        .table > tbody > tr > th { width: 32%; }
        .amount { font-size: 20px; font-weight: 700; }
        @media print {
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="no-print text-right">
        <button class="btn btn-primary btn-sm" onclick="window.print()"><i class="fa fa-print"></i> Print</button>
        <a href="<?php echo base_url('index.php?burial/fraud_statement/' . (int) ($payment->recovery_id ?? 0)); ?>" class="btn btn-default btn-sm">Back</a>
    </div>

    <div class="header row">
        <div class="col-xs-2">
            <img src="<?php echo base_url('uploads/logo.png'); ?>" alt="Logo" class="logo">
        </div>
        <div class="col-xs-10">
            <h3 style="margin:0;">Fraud Recovery Payment Receipt</h3>
            <small>Receipt #<?php echo (int) ($payment->payment_id ?? 0); ?> | Printed: <?php echo date('d-m-Y H:i'); ?></small>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-6">
            <h4>Member Details</h4>
            <table class="table table-bordered">
                <tr><th>Member Name</th><td><?php echo htmlspecialchars($member_name); ?></td></tr>
                <tr><th>ID Number</th><td><?php echo htmlspecialchars($payment->idnumber ?? '-'); ?></td></tr>
                <tr><th>Employee No</th><td><?php echo htmlspecialchars($payment->employeeno ?? '-'); ?></td></tr>
                <tr><th>Passbook No</th><td><?php echo htmlspecialchars($payment->passbook_no ?? '-'); ?></td></tr>
                <tr><th>Cell Number</th><td><?php echo htmlspecialchars($payment->cellnumber ?? '-'); ?></td></tr>
            </table>
        </div>
        <div class="col-xs-6">
            <h4>Payment Details</h4>
            <table class="table table-bordered">
                <tr><th>Recovery ID</th><td><?php echo (int) ($payment->recovery_id ?? 0); ?></td></tr>
                <tr><th>Payment Date</th><td><?php echo htmlspecialchars($payment->payment_date ?? '-'); ?></td></tr>
                <tr><th>Amount Paid</th><td><span class="amount">E <?php echo number_format((float) ($payment->amount_paid ?? 0), 2); ?></span></td></tr>
                <tr><th>Payment Method</th><td><?php echo htmlspecialchars($payment->payment_method ?? '-'); ?></td></tr>
                <tr><th>Reference No</th><td><?php echo htmlspecialchars($payment->reference_no ?? '-'); ?></td></tr>
                <tr><th>Remarks</th><td><?php echo htmlspecialchars($payment->remarks ?? '-'); ?></td></tr>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <h4>Fraud Recovery Summary</h4>
            <table class="table table-bordered">
                <tr>
                    <th style="width:25%;">Amount Owed</th>
                    <th style="width:25%;">Total Paid To Date</th>
                    <th style="width:25%;">Remaining Balance</th>
                    <th style="width:25%;">Recovery Status</th>
                </tr>
                <tr>
                    <td>E <?php echo number_format((float) ($payment->amount_owed ?? 0), 2); ?></td>
                    <td>E <?php echo number_format($total_paid, 2); ?></td>
                    <td><strong>E <?php echo number_format($remaining_balance, 2); ?></strong></td>
                    <td><?php echo htmlspecialchars($payment->recovery_status ?? '-'); ?></td>
                </tr>
            </table>
            <p><strong>Case Description:</strong> <?php echo nl2br(htmlspecialchars($payment->case_description ?? '-')); ?></p>
        </div>
    </div>

    <div class="row" style="margin-top: 40px;">
        <div class="col-xs-6">
            <p>______________________________<br>Captured By</p>
        </div>
        <div class="col-xs-6 text-right">
            <p>______________________________<br>Member / Receiver Signature</p>
        </div>
    </div>
</div>
</body>
</html>
