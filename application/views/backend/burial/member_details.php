<?php
$member_data = $this->db->get_where('members', array('id' => $memberid))->result_array();
foreach ($member_data as $row):
    
$beneficiaries = $this->db->get_where('beneficiaries', array('memberid' => $row['id']))->result_array();
$beneficiary_count = count($beneficiaries);

// Beneficiary status counts
$count_active = 0;
$count_waiting = 0;
$count_replacee = 0;
$count_benefitted_not_replaced = 0;

foreach ($beneficiaries as $bcount) {
    $status = isset($bcount['status']) ? trim($bcount['status']) : '';
    $replaced_flag = isset($bcount['replaced']) ? (int)$bcount['replaced'] : 0;

    if ($status === 'ACTIVE') $count_active++;
    if ($status === 'WAITING') $count_waiting++;
    if ($status === 'REPLACEE') $count_replacee++;

    // Benefitted but not replaced: status BENEFITTED and not marked replaced
    if ($status === 'BENEFITTED' && $replaced_flag !== 1) {
        $count_benefitted_not_replaced++;
    }
}

$principal_fee   = $this->db->get_where('settings' , array('type'=>'principal_fee'))->row()->description;
$beneficiary_fee = $this->db->get_where('settings' , array('type'=>'member_fee'))->row()->description * $beneficiary_count;
$total_monthly = $principal_fee + $beneficiary_fee;
?>

<style>
@media print {
    body { margin: 0; padding: 0; }
    .no-print { display: none !important; }
    .print-page { page-break-after: always; }
    .print-page:last-child { page-break-after: auto; }
    .member-profile { padding: 20px; }
    .profile-header { border-bottom: 2px solid #000; padding-bottom: 15px; margin-bottom: 20px; }
    .profile-section { margin-bottom: 25px; }
    .info-row { margin-bottom: 10px; padding: 5px 0; border-bottom: 1px dotted #ccc; }
    .info-label { font-weight: bold; display: inline-block; width: 200px; }
    .info-value { display: inline-block; }
    table { width: 100%; border-collapse: collapse; margin-top: 15px; }
    table th, table td { border: 1px solid #000; padding: 8px; text-align: left; }
    table th { background-color: #f0f0f0; font-weight: bold; }
    .page-break { page-break-before: always; }
}
.member-profile { background: #fff; padding: 30px; }
.profile-header { text-align: center; border-bottom: 3px solid #333; padding-bottom: 20px; margin-bottom: 30px; }
.profile-header h2 { margin: 0; font-size: 24px; }
.profile-header p { margin: 5px 0; color: #666; }
.profile-section { margin-bottom: 30px; }
.section-title { font-size: 18px; font-weight: bold; color: #333; border-bottom: 2px solid #333; padding-bottom: 8px; margin-bottom: 15px; }
.info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
.info-row { padding: 8px 0; border-bottom: 1px dotted #ddd; }
.info-label { font-weight: bold; color: #555; }
.info-value { color: #333; }
.beneficiaries-table { margin-top: 20px; }
.summary-box { background: #f9f9f9; padding: 15px; border: 1px solid #ddd; margin-top: 20px; }
</style>

<div class="row">
    <div class="col-md-12">
        <div class="no-print" style="margin-bottom: 20px; text-align: right;">
            <button onclick="window.print()" class="btn btn-primary">
                <i class="fa fa-print"></i> Print Profile
            </button>
            <a href="<?php echo base_url('index.php?burial/beneficiaries/'.$row['id']); ?>" class="btn btn-info">
                <i class="fa fa-users"></i> Manage Beneficiaries
            </a>
        </div>

        <!-- PAGE 1: MEMBER INFORMATION -->
        <div class="member-profile print-page">
            <div class="profile-header">
                <h2>SNAT BURIAL SCHEME</h2>
                <p>Member Profile</p>
                <p>Generated on: <?php echo date('d-m-Y H:i:s'); ?></p>
            </div>

            <div class="profile-section">
                <div class="section-title">Member Information</div>
                <div class="info-grid">
                    <div class="info-row">
                        <span class="info-label">SNAT Burial Account:</span>
                        <span class="info-value"><?php echo $row['id']; ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Full Name:</span>
                        <span class="info-value"><?php echo $row['surname'].' '.$row['name']; ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">National ID:</span>
                        <span class="info-value"><?php echo $row['idnumber']; ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Passbook No:</span>
                        <span class="info-value"><?php echo $row['passbook_no']; ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Employee No:</span>
                        <span class="info-value"><?php echo $row['employeeno'] ? $row['employeeno'] : 'N/A'; ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">TSC No:</span>
                        <span class="info-value"><?php echo $row['tscno'] ? $row['tscno'] : 'N/A'; ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Date of Birth:</span>
                        <span class="info-value"><?php echo $row['dob']; ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Gender:</span>
                        <span class="info-value"><?php echo $row['gender']; ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Cell Number:</span>
                        <span class="info-value"><?php echo $row['cellnumber']; ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">School Code:</span>
                        <span class="info-value"><?php echo $row['schoolcode'] ? $row['schoolcode'] : 'N/A'; ?></span>
                    </div>
                </div>
            </div>

            <div class="profile-section">
                <div class="section-title">Monthly Contribution Summary</div>
                <div class="summary-box">
                    <div class="info-row">
                        <span class="info-label">Principal Fee:</span>
                        <span class="info-value">E <?php echo number_format($principal_fee, 2); ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Number of Beneficiaries:</span>
                        <span class="info-value"><?php echo $beneficiary_count; ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Active Beneficiaries:</span>
                        <span class="info-value"><?php echo $count_active; ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Waiting Beneficiaries:</span>
                        <span class="info-value"><?php echo $count_waiting; ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Replacee Beneficiaries:</span>
                        <span class="info-value"><?php echo $count_replacee; ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Benefitted (Not Replaced):</span>
                        <span class="info-value"><?php echo $count_benefitted_not_replaced; ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Beneficiary Fee (<?php echo $beneficiary_count; ?> x E <?php echo number_format($this->db->get_where('settings' , array('type'=>'member_fee'))->row()->description, 2); ?>):</span>
                        <span class="info-value">E <?php echo number_format($beneficiary_fee, 2); ?></span>
                    </div>
                    <div class="info-row" style="border-bottom: 2px solid #333; padding-bottom: 10px; margin-bottom: 10px;">
                        <span class="info-label" style="font-size: 16px;">Total Monthly Contribution:</span>
                        <span class="info-value" style="font-size: 16px; font-weight: bold;">E <?php echo number_format($total_monthly, 2); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- PAGE 2: BENEFICIARIES -->
        <div class="member-profile print-page page-break">
            <div class="profile-header">
                <h2>SNAT BURIAL SCHEME</h2>
                <p>Beneficiaries List - <?php echo $row['surname'].' '.$row['name']; ?></p>
            </div>

            <div class="profile-section">
                <div class="section-title">Beneficiaries (<?php echo $beneficiary_count; ?>)</div>
                
                <?php if ($beneficiary_count > 0): ?>
                <table class="beneficiaries-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Full Name</th>
                            <th>Gender</th>
                            <th>Date of Birth</th>
                            <th>Submission Date</th>
                            <th>Status</th>
                            <th>Status Date</th>
                            <th>Maturity Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; foreach ($beneficiaries as $b): 
                            // Calculate maturity status
                            $submission_date = $b['submission_date'];
                            
                            // Handle different date formats (dd-mm-yyyy or yyyy-mm-dd)
                            $submission_timestamp = false;
                            if (strpos($submission_date, '-') !== false) {
                                $date_parts = explode('-', $submission_date);
                                if (count($date_parts) == 3 && intval($date_parts[0]) > 12) {
                                    $submission_timestamp = strtotime($submission_date);
                                } else {
                                    $submission_timestamp = strtotime($date_parts[2] . '-' . $date_parts[1] . '-' . $date_parts[0]);
                                }
                            } else {
                                $submission_timestamp = strtotime($submission_date);
                            }
                            
                            $today = strtotime(date('Y-m-d'));
                            $one_year_ago = strtotime('-1 year', $today);
                            $is_matured = ($submission_timestamp && $submission_timestamp <= $one_year_ago);
                            
                            // Determine maturity status
                            if ($b['status'] == 'BENEFITTED' || $b['status'] == 'BENEFITTED - REPLACED') {
                                $maturity_status = 'BENEFITTED';
                            } elseif ($b['status'] == 'REPLACEE') {
                                $maturity_status = 'Matured';
                            } elseif ($is_matured) {
                                $maturity_status = 'Matured';
                            } else {
                                $maturity_status = 'Waiting';
                            }
                        ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $b['fullname']; ?></td>
                            <td><?php echo $b['gender']; ?></td>
                            <td><?php echo $b['dob']; ?></td>
                            <td><?php echo $b['submission_date']; ?></td>
                            <td><?php echo $b['status']; ?></td>
                            <td><?php echo $b['status_date']; ?></td>
                            <td><?php echo $maturity_status; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <p style="text-align: center; padding: 20px; color: #999;">No beneficiaries registered yet.</p>
                <?php endif; ?>
            </div>

            <div style="margin-top: 40px; padding-top: 20px; border-top: 2px solid #333;">
                <p style="text-align: center; font-size: 12px; color: #666;">
                    This is a computer-generated document. For official records, please contact SNAT Burial Scheme office.
                </p>
            </div>
        </div>
    </div>
</div>

<?php
endforeach;
?>
