<?php
$member = $this->db->get_where('members', array('id' => $memberid))->row_array();
if (!$member) {
    echo '<div class="alert alert-danger">Member not found.</div>';
    return;
}

$branch_name = '';
if (!empty($member['branch'])) {
    $branch_name = $this->db->select('name')->get_where('branches', array('id' => $member['branch']))->row('name');
}

$status_name = '';
if (!empty($member['employment_status'])) {
    $status_name = $this->db->select('description')->get_where('employment_status', array('id' => $member['employment_status']))->row('description');
}

$nominee = $this->db
    ->order_by('id', 'ASC')
    ->get_where('nominee', array('member_id' => $member['id']))
    ->row_array();

$statements = $this->db
    ->where('memberid', $member['id'])
    ->order_by('date', 'DESC')
    ->limit(12)
    ->get('statements')
    ->result_array();

$beneficiaries = $this->Beneficiary_model->get_by_member($member['id']);
$summary = $this->Beneficiary_model->get_payable_summary($member['id']);
$total_beneficiaries = $summary['total_beneficiaries'];
$payable_beneficiaries = $summary['payable_beneficiaries'];
$beneficiary_fee = $summary['payable_beneficiary_fee'];
$total_monthly = $this->Beneficiary_model->get_total_monthly_fee($member['id']);
$fees = $this->Beneficiary_model->get_fee_settings();
$principal_fee = $fees['principal_fee'];
$member_fee = $fees['member_fee'];

$non_payable_statuses = array(
    'BENEFITTED - REPLACED',
    'DECEASED - REPLACED',
    'DELETED'
);

$payable_list = array_filter($beneficiaries, function ($b) use ($non_payable_statuses) {
    $status = trim($b['status'] ?? '');
    return !in_array($status, $non_payable_statuses, true);
});

$payable_members_count = count(array_filter($payable_list, function ($b) {
    return (int)($b['is_spouse'] ?? 0) === 0;
}));

$payable_spouses_count = count(array_filter($payable_list, function ($b) {
    return (int)($b['is_spouse'] ?? 0) === 1;
}));
?>

<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">
                <div class="pull-right">
                    <a href="#"
                       class="btn btn-xs btn-primary"
                       onclick="showAjaxModal('<?php echo base_url('index.php?modal/popup/modal_edit_member/' . $member['id']); ?>')">
                        <i class="fa fa-edit"></i> Edit Member
                    </a>
                    <a href="<?php echo base_url('index.php?burial/member_profile_print/' . $member['id']); ?>"
                       target="_blank"
                       class="btn btn-xs btn-default">
                        <i class="fa fa-print"></i> Print Profile
                    </a>
                </div>
                <h2 class="panel-title">
                    <i class="fa fa-user"></i> Member Profile
                </h2>
            </header>

            <div class="panel-body">
                <div class="row" style="margin-bottom: 15px;">
                    <div class="col-md-2 col-sm-3 text-center">
                        <img src="<?php echo base_url('uploads/logo.png'); ?>" alt="SNAT Logo" class="img-responsive center-block" style="max-height: 70px;">
                    </div>
                    <div class="col-md-10 col-sm-9">
                        <h3 style="margin-top: 0; margin-bottom: 5px;">SNAT Burial Member Profile</h3>
                        <p class="text-muted" style="margin-bottom: 0;">
                            Account: <strong><?php echo '058-' . $member['id']; ?></strong>
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr><th style="width: 35%;">Full Name</th><td><?php echo htmlspecialchars(trim(($member['surname'] ?? '') . ' ' . ($member['name'] ?? ''))); ?></td></tr>
                                <tr><th>National ID</th><td><?php echo !empty($member['idnumber']) ? htmlspecialchars($member['idnumber']) : 'N/A'; ?></td></tr>
                                <tr><th>Employee No</th><td><?php echo !empty($member['employeeno']) ? htmlspecialchars($member['employeeno']) : 'N/A'; ?></td></tr>
                                <tr><th>TSC No</th><td><?php echo !empty($member['tscno']) ? htmlspecialchars($member['tscno']) : 'N/A'; ?></td></tr>
                                <tr><th>Date of Birth</th><td><?php echo !empty($member['dob']) ? htmlspecialchars($member['dob']) : 'N/A'; ?></td></tr>
                                <tr><th>Gender</th><td><?php echo !empty($member['gender']) ? htmlspecialchars($member['gender']) : 'N/A'; ?></td></tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-6">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr><th style="width: 35%;">Cell Number</th><td><?php echo !empty($member['cellnumber']) ? htmlspecialchars($member['cellnumber']) : 'N/A'; ?></td></tr>
                                <tr><th>School Code</th><td><?php echo !empty($member['schoolcode']) ? htmlspecialchars($member['schoolcode']) : 'N/A'; ?></td></tr>
                                <tr><th>Institution</th><td><?php echo !empty($member['institution']) ? htmlspecialchars($member['institution']) : 'N/A'; ?></td></tr>
                                <tr><th>Branch</th><td><?php echo !empty($branch_name) ? htmlspecialchars($branch_name) : 'N/A'; ?></td></tr>
                                <tr><th>Employment Status</th><td><?php echo !empty($status_name) ? htmlspecialchars($status_name) : 'N/A'; ?></td></tr>
                                <tr><th>Nominee</th><td><?php echo !empty($nominee['fullname']) ? htmlspecialchars($nominee['fullname']) : 'N/A'; ?></td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>

        <section class="panel">
            <header class="panel-heading">
                <h2 class="panel-title"><i class="fa fa-list"></i> Last 12 Statements</h2>
            </header>
            <div class="panel-body">
                <?php if (!empty($statements)): ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Source</th>
                                    <th class="text-right">Amount (E)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; foreach ($statements as $sub): ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo !empty($sub['date']) ? date('Y-m-d', strtotime($sub['date'])) : 'N/A'; ?></td>
                                        <td><?php echo !empty($sub['description']) ? htmlspecialchars($sub['description']) : 'N/A'; ?></td>
                                        <td><?php echo !empty($sub['type']) ? htmlspecialchars($sub['type']) : 'N/A'; ?></td>
                                        <td><?php echo !empty($sub['status']) ? htmlspecialchars($sub['status']) : 'N/A'; ?></td>
                                        <td><?php echo !empty($sub['source']) ? htmlspecialchars($sub['source']) : 'N/A'; ?></td>
                                        <td class="text-right"><?php echo number_format((float)($sub['amount'] ?? 0), 2); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning" style="margin-bottom: 0;">
                        No statements found for this member.
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <section class="panel">
            <header class="panel-heading">
                <h2 class="panel-title"><i class="fa fa-calculator"></i> Monthly Amount To Pay</h2>
            </header>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr><th style="width: 45%;">Principal Fee</th><td>E <?php echo number_format((float)$principal_fee, 2); ?></td></tr>
                        <tr><th>Total Registered Beneficiaries</th><td><?php echo (int)$total_beneficiaries; ?></td></tr>
                        <tr><th>Payable Beneficiaries</th><td><?php echo (int)$payable_beneficiaries; ?></td></tr>
                        <tr><th>Payable Members</th><td><?php echo (int)$payable_members_count; ?></td></tr>
                        <tr><th>Payable Spouses</th><td><?php echo (int)$payable_spouses_count; ?></td></tr>
                        <tr><th>Beneficiary Fee (<?php echo (int)$payable_beneficiaries; ?> x E <?php echo number_format((float)$member_fee, 2); ?>)</th><td>E <?php echo number_format((float)$beneficiary_fee, 2); ?></td></tr>
                        <tr><th>Total Monthly Contribution</th><td><strong>E <?php echo number_format((float)$total_monthly, 2); ?></strong></td></tr>
                    </tbody>
                </table>
            </div>
        </section>

        <section class="panel">
            <header class="panel-heading">
                <h2 class="panel-title"><i class="fa fa-users"></i> Beneficiaries (<?php echo (int)$total_beneficiaries; ?>)</h2>
            </header>
            <div class="panel-body">
                <?php if (!empty($beneficiaries)): ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
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
                                <?php $k = 1; foreach ($beneficiaries as $b): ?>
                                    <tr>
                                        <td><?php echo $k++; ?></td>
                                        <td><?php echo htmlspecialchars($b['fullname'] ?? 'N/A'); ?></td>
                                        <td><?php echo !empty($b['is_spouse']) ? 'Spouse' : 'Member/Child'; ?></td>
                                        <td><?php echo !empty($b['gender']) ? htmlspecialchars($b['gender']) : 'N/A'; ?></td>
                                        <td><?php echo !empty($b['dob']) ? htmlspecialchars($b['dob']) : 'N/A'; ?></td>
                                        <td><?php echo !empty($b['submission_date']) ? htmlspecialchars($b['submission_date']) : 'N/A'; ?></td>
                                        <td><?php echo !empty($b['status']) ? htmlspecialchars($b['status']) : 'N/A'; ?></td>
                                        <td><?php echo !empty($b['status_date']) ? htmlspecialchars($b['status_date']) : 'N/A'; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning" style="margin-bottom: 0;">
                        No beneficiaries registered yet.
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </div>
</div>