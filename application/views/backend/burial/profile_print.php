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

$subscriptions = $this->db
    ->where('memberid', $member['id'])
    ->order_by('date', 'DESC')
    ->limit(12)
    ->get('subscriptions')
    ->result_array();
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Burial Member Profile Print</title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/vendor/bootstrap/css/bootstrap.css"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/vendor/font-awesome/css/font-awesome.css"/>
    <style>
        body { padding: 20px; }
        .header { border-bottom: 2px solid #333; margin-bottom: 20px; padding-bottom: 10px; }
        .logo { max-height: 60px; }
        .table th { width: 35%; }
        @media print {
            .no-print { display: none !important; }
            body { padding: 0; }
        }
    </style>
</head>
<body>
    <div class="no-print text-right" style="margin-bottom: 10px;">
        <button class="btn btn-primary" onclick="window.print()">
            <i class="fa fa-print"></i> Print
        </button>
    </div>

    <div class="header row">
        <div class="col-xs-2">
            <img src="<?php echo base_url('uploads/logo.png'); ?>" alt="SNAT Logo" class="logo">
        </div>
        <div class="col-xs-10">
            <h3 style="margin: 0;">SNAT Burial Member Profile</h3>
            <small>Generated on <?php echo date('d-m-Y H:i:s'); ?></small>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-6">
            <table class="table table-bordered">
                <tr><th>SNAT Account</th><td><?php echo '058-' . $member['id']; ?></td></tr>
                <tr><th>Full Name</th><td><?php echo htmlspecialchars(trim(($member['surname'] ?? '') . ' ' . ($member['name'] ?? ''))); ?></td></tr>
                <tr><th>National ID</th><td><?php echo !empty($member['idnumber']) ? htmlspecialchars($member['idnumber']) : 'N/A'; ?></td></tr>
                <tr><th>Employee No</th><td><?php echo !empty($member['employeeno']) ? htmlspecialchars($member['employeeno']) : 'N/A'; ?></td></tr>
                <tr><th>TSC No</th><td><?php echo !empty($member['tscno']) ? htmlspecialchars($member['tscno']) : 'N/A'; ?></td></tr>
                <tr><th>Date of Birth</th><td><?php echo !empty($member['dob']) ? htmlspecialchars($member['dob']) : 'N/A'; ?></td></tr>
            </table>
        </div>
        <div class="col-xs-6">
            <table class="table table-bordered">
                <tr><th>Gender</th><td><?php echo !empty($member['gender']) ? htmlspecialchars($member['gender']) : 'N/A'; ?></td></tr>
                <tr><th>Cell Number</th><td><?php echo !empty($member['cellnumber']) ? htmlspecialchars($member['cellnumber']) : 'N/A'; ?></td></tr>
                <tr><th>School Code</th><td><?php echo !empty($member['schoolcode']) ? htmlspecialchars($member['schoolcode']) : 'N/A'; ?></td></tr>
                <tr><th>Institution</th><td><?php echo !empty($member['institution']) ? htmlspecialchars($member['institution']) : 'N/A'; ?></td></tr>
                <tr><th>Branch</th><td><?php echo !empty($branch_name) ? htmlspecialchars($branch_name) : 'N/A'; ?></td></tr>
                <tr><th>Employment Status</th><td><?php echo !empty($status_name) ? htmlspecialchars($status_name) : 'N/A'; ?></td></tr>
                <tr><th>Nominee</th><td><?php echo !empty($nominee['fullname']) ? htmlspecialchars($nominee['fullname']) : 'N/A'; ?></td></tr>
            </table>
        </div>
    </div>

    <h4>Last 12 Subscriptions</h4>
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
            <?php if (!empty($subscriptions)): ?>
                <?php $i = 1; foreach ($subscriptions as $sub): ?>
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
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center text-muted">No subscriptions found for this member.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
