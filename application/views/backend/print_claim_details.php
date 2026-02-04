<?php
    $system_name        = $this->db->get_where('settings' , array('type'=>'system_name'))->row()->description;
    $system_title       = $this->db->get_where('settings' , array('type'=>'system_title'))->row()->description;
    $account_type       = $this->session->userdata('login_type');
    $skin_colour        = $this->db->get_where('settings' , array('type'=>'skin_colour'))->row()->description;
    $borders_style      = $this->db->get_where('settings' , array('type'=>'borders_style'))->row()->description;
    $header_colour      = $this->db->get_where('settings' , array('type'=>'header_colour'))->row()->description;
    $sidebar_colour     = $this->db->get_where('settings' , array('type'=>'sidebar_colour'))->row()->description;
    $sidebar_size       = $this->db->get_where('settings' , array('type'=>'sidebar_size'))->row()->description;
    $active_sms_service = $this->db->get_where('settings' , array('type'=>'active_sms_service'))->row()->description;
    $running_year       = $this->db->get_where('settings' , array('type'=>'running_year'))->row()->description;
?>

<!doctype html>
<html class="fixed<?php if ($skin_colour == 'dark') {echo ' dark';} else {  if ($sidebar_colour == 'sidebar-light') echo ' sidebar-light'; if ($header_colour == 'header-dark') echo ' header-dark'; } if ($sidebar_size != 'sidebar-left-md') echo ' ' . $sidebar_size; if($page_name == 'dashboard' || $page_name == 'streetfeed' || $page_name == 'message' || $page_name == 'student_information') echo ' sidebar-left-collapsed';?>">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?php echo $page_title;?> | <?php echo $system_title;?></title>
    <meta name="keywords" content="SNAT BURIAL AGM Management System"/>
    <meta name="description" content="SNAT BURIAL AGM Management System Management System">
    <meta name="author" content="Sicelo Thabani Hlanze">
    <?php include 'includes/includes_top.php'; ?>

    <!-- Print-specific styles -->
    <style type="text/css" media="print">
        @media print {
            body * {
                visibility: hidden;
            }
            .print-area,
            .print-area * {
                visibility: visible;
            }
            .print-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
            .no-print {
                display: none !important;
            }
            .panel {
                border: none !important;
                box-shadow: none !important;
            }
            .panel-heading {
                border-bottom: 2px solid #ccc;
                margin-bottom: 20px;
            }
            table {
                width: 100% !important;
            }
            .label {
                padding: 4px 8px;
                border: 1px solid #777;
                font-size: 90%;
            }
            a[href]:after {
                content: " (" attr(href) ") ";
                font-size: 80%;
                color: #444;
            }
        }
    </style>
</head>

<body class="loading-overlay-showing" data-loading-overlay>

    <section class="body">
        
        <div class="inner-wrapper">

            <?php
            $claim = $claim ?? [];
            $documents = $documents ?? [];

            // Get member name
            $member = $this->db->get_where('members', array('id' => $claim['member_id'] ?? 0))->row();
            $member_name = $member ? $member->surname . ' ' . $member->name : '-';

            // Get beneficiary name
            $beneficiary = $this->db->get_where('beneficiaries', array('id' => $claim['beneficiary_id'] ?? 0))->row();
            $beneficiary_name = $beneficiary ? $beneficiary->fullname : '-';
            ?>

            <div class="row">
                <div class="col-md-10 col-md-offset-1">

                    <section class="panel print-area">
                        <header class="panel-heading no-print">
                            <h4 class="panel-title">Claim Details #<?php echo htmlspecialchars($claim['id'] ?? '-'); ?></h4>
                        </header>
                        <div class="panel-body">

                            <div class="row no-print" style="margin-bottom: 25px;">
                                <div class="col-xs-12 text-right">
                                    <button type="button" class="btn btn-primary" onclick="window.print()">
                                        <i class="fa fa-print"></i> Print Claim Details
                                    </button>
                                </div>
                            </div>

                            <h3 class="text-center" style="margin-bottom: 30px;">Claim Details #<?php echo htmlspecialchars($claim['id'] ?? '—'); ?></h3>

                            <div class="row">
                                <div class="col-md-4">
                                    <h5>Member & Beneficiary Information</h5>
                                    <table class="table table-striped">
                                        <tr><th>Claim ID</th><td><?php echo htmlspecialchars($claim['id'] ?? '-'); ?></td></tr>
                                        <tr><th>Member</th><td><?php echo htmlspecialchars($member_name); ?></td></tr>
                                        <tr><th>Beneficiary</th><td><?php echo htmlspecialchars($beneficiary_name); ?></td></tr>
                                        <tr><th>National ID</th><td><?php echo htmlspecialchars($claim['national_id'] ?? '-'); ?></td></tr>
                                    </table>
                                </div>

                                <div class="col-md-4">
                                    <h5>Burial Information</h5>
                                    <table class="table table-striped">
                                        <tr><th>Place of Burial</th><td><?php echo htmlspecialchars($claim['place_of_burial'] ?? '-'); ?></td></tr>
                                        <tr><th>Date of Burial</th><td><?php echo !empty($claim['date_of_burial']) ? date('d-m-Y', strtotime($claim['date_of_burial'])) : '-'; ?></td></tr>
                                        <tr><th>Claim Date</th><td><?php echo !empty($claim['claim_date']) ? date('d-m-Y', strtotime($claim['claim_date'])) : '-'; ?></td></tr>
                                    </table>
                                </div>

                                <div class="col-md-4">
                                    <h5>Mortuary Information</h5>
                                    <table class="table table-striped">
                                        <tr><th>Mortuary</th><td><?php echo htmlspecialchars($claim['mortuary'] ?? '-'); ?></td></tr>
                                        <tr><th>Date of Entry</th><td><?php echo !empty($claim['date_of_entry']) ? date('d-m-Y', strtotime($claim['date_of_entry'])) : '-'; ?></td></tr>
                                    </table>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <h5>Claim Status & Dates</h5>
                                    <table class="table table-striped">
                                        <tr>
                                            <th>Status</th>
                                            <td>
                                                <span class="label label-<?php 
                                                    if(($claim['status'] ?? '') == 'PENDING') echo 'warning';
                                                    elseif(($claim['status'] ?? '') == 'APPROVED') echo 'success';
                                                    elseif(($claim['status'] ?? '') == 'REJECTED') echo 'danger';
                                                    elseif(($claim['status'] ?? '') == 'PAID') echo 'info';
                                                ?>">
                                                    <?php echo htmlspecialchars($claim['status'] ?? '-'); ?>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr><th>Approved Date</th><td><?php echo !empty($claim['approved_date']) ? date('d-m-Y', strtotime($claim['approved_date'])) : '-'; ?></td></tr>
                                        <tr><th>Payment Date</th><td><?php echo !empty($claim['payment_date']) ? date('d-m-Y', strtotime($claim['payment_date'])) : '-'; ?></td></tr>
                                    </table>
                                </div>

                                <div class="col-md-6">
                                    <h5>Payment Information</h5>
                                    <table class="table table-striped">
                                        <tr><th>Amount</th><td><strong><?php echo isset($claim['amount']) ? number_format($claim['amount'],2) : '-'; ?></strong></td></tr>
                                        <tr><th>Bank</th><td><?php echo htmlspecialchars($claim['bank'] ?? '-'); ?></td></tr>
                                        <tr><th>Account</th><td><?php echo htmlspecialchars($claim['account'] ?? '-'); ?></td></tr>
                                    </table>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <h5>Processing Information</h5>
                                    <table class="table table-striped">
                                        <tr><th>Processed By</th><td><?php echo htmlspecialchars($this->db->get_where('admin', array('id' => $claim['processed_by']))->row()->name ?? '-'); ?></td></tr>
                                        <tr><th>Approved By</th><td><?php echo htmlspecialchars($this->db->get_where('admin', array('id' => $claim['approved_by']))->row()->name ?? '-'); ?></td></tr>
                                        <tr><th>Paid By</th><td><?php echo htmlspecialchars($this->db->get_where('admin', array('id' => $claim['paid_by']))->row()->name ?? '-'); ?></td></tr>
                                        <tr><th>Created At</th><td><?php echo !empty($claim['created_at']) ? date('d-m-Y H:i:s', strtotime($claim['created_at'])) : '-'; ?></td></tr>
                                        <tr><th>Updated At</th><td><?php echo !empty($claim['updated_at']) ? date('d-m-Y H:i:s', strtotime($claim['updated_at'])) : '-'; ?></td></tr>
                                        <tr><th>Notes</th><td><?php echo nl2br(htmlspecialchars($claim['notes'] ?? '-')); ?></td></tr>
                                    </table>
                                </div>
                            </div>

                            <h5 style="margin-top: 30px;">Documents</h5>
                            <?php if (!empty($documents)): ?>
                                <ul class="list-group">
                                    <?php foreach ($documents as $doc): ?>
                                        <li class="list-group-item">
                                            <strong><?php echo htmlspecialchars($doc['description']); ?></strong>
                                            <div class="pull-right no-print">
                                                <a href="<?php echo base_url($doc['path']); ?>" class="btn btn-xs btn-default" target="_blank"><i class="fa fa-eye"></i> View</a>
                                                <a href="<?php echo base_url($doc['path']); ?>" class="btn btn-xs btn-info" download><i class="fa fa-download"></i> Download</a>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <p>No documents uploaded.</p>
                            <?php endif; ?>

                            <div style="margin-top:40px;" class="no-print">
                                <?php if (($claim['status'] ?? '') == 'PENDING'): ?>
                                    <a href="<?php echo base_url('index.php?burial/claims/approve/' . ($claim['id'] ?? '')); ?>" class="btn btn-success" id="approve_btn">Approve</a>
                                    <a href="<?php echo base_url('index.php?burial/claims/reject/' . ($claim['id'] ?? '')); ?>" class="btn btn-danger" id="reject_btn">Reject</a>
                                <?php elseif (($claim['status'] ?? '') == 'APPROVED'): ?>
                                    <a href="<?php echo base_url('index.php?burial/approved_claims/pay/' . ($claim['id'] ?? '')); ?>" class="btn btn-primary" id="pay_btn">Pay</a>
                                    <span class="label label-success" style="margin-left:10px;">Status: APPROVED</span>
                                <?php else: ?>
                                    <span class="label label-default">Status: <?php echo htmlspecialchars($claim['status'] ?? '-'); ?></span>
                                <?php endif; ?>
                                <a href="<?php echo base_url('index.php?burial/claims'); ?>" class="btn btn-default">Back to Claims</a>
                            </div>

                        </div>
                    </section>

                </div>
            </div>

        </div>

    </section>

    <!-- Includes modal -->
    <?php include 'includes/modal.php'; ?>
    
    <!-- Includes bottom -->
    <?php include 'includes/includes_bottom.php'; ?>

</body>
</html>