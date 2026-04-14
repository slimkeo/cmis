<?php
$start_date = isset($start_date) ? $start_date : '';
$end_date = isset($end_date) ? $end_date : '';
$new_members = isset($new_members) && is_array($new_members) ? $new_members : array();
$modified_members = isset($modified_members) && is_array($modified_members) ? $modified_members : array();
?>

<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">
                <h2 class="panel-title">
                    Modified Members Report
                    <small style="display:block; margin-top:6px; color:#666;">
                        <?php echo htmlspecialchars($start_date, ENT_QUOTES, 'UTF-8'); ?> to <?php echo htmlspecialchars($end_date, ENT_QUOTES, 'UTF-8'); ?>
                    </small>
                </h2>
            </header>
            <div class="panel-body">
                <div class="row" style="margin-bottom: 15px;">
                    <div class="col-md-12 text-right">
                        <a href="<?php echo base_url(); ?>index.php?burial/modified_members" class="btn btn-default btn-sm">
                            <i class="fa fa-calendar"></i> Change Date Range
                        </a>
                    </div>
                </div>

                <div class="alert alert-info">
                    New members found: <strong><?php echo count($new_members); ?></strong> |
                    Members with beneficiary changes found: <strong><?php echo count($modified_members); ?></strong>
                </div>

                <h4>Members Who Joined In Date Range</h4>
                <table class="table table-bordered table-striped mb-none" id="datatable-new-members">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Member ID</th>
                            <th>ID Number</th>
                            <th>Passbook No</th>
                            <th>Employee No</th>
                            <th>TSC No</th>
                            <th>Surname</th>
                            <th>Name</th>
                            <th>Cell Number</th>
                            <th>DOB</th>
                            <th>Gender</th>
                            <th>School Code</th>
                            <th>Resident</th>
                            <th>Create Date</th>
                            <th>Payable Beneficiaries</th>
                            <th>Monthly Fee (E)</th>
                            <th>Timestamp</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($new_members)): ?>
                            <tr><td colspan="17">No new members found in selected date range.</td></tr>
                        <?php else: ?>
                            <?php $i = 1; foreach ($new_members as $member): ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo (int)($member['id'] ?? 0); ?></td>
                                    <td><?php echo htmlspecialchars($member['idnumber'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($member['passbook_no'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($member['employeeno'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($member['tscno'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($member['surname'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($member['name'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($member['cellnumber'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($member['dob'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($member['gender'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($member['schoolcode'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($member['resident'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($member['createdate'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo (int)($member['payable_beneficiaries'] ?? 0); ?></td>
                                    <td><?php echo number_format((float)($member['monthly_fee'] ?? 0), 2); ?></td>
                                    <td><?php echo htmlspecialchars($member['timestamp'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>

                <h4 style="margin-top:20px;">Members With Beneficiary Modifications</h4>
                <table class="table table-bordered table-striped mb-none" id="datatable-modified-members">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Member ID</th>
                            <th>ID Number</th>
                            <th>Passbook No</th>
                            <th>Employee No</th>
                            <th>TSC No</th>
                            <th>Surname</th>
                            <th>Name</th>
                            <th>Cell Number</th>
                            <th>Gender</th>
                            <th>DOB</th>
                            <th>School Code</th>
                            <th>Resident</th>
                            <th>Last Beneficiary Change</th>
                            <th>Payable Beneficiaries</th>
                            <th>Monthly Fee (E)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($modified_members)): ?>
                            <tr><td colspan="16">No beneficiary modifications found in selected date range.</td></tr>
                        <?php else: ?>
                            <?php $j = 1; foreach ($modified_members as $member): ?>
                                <tr>
                                    <td><?php echo $j++; ?></td>
                                    <td><?php echo (int)($member['id'] ?? 0); ?></td>
                                    <td><?php echo htmlspecialchars($member['idnumber'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($member['passbook_no'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($member['employeeno'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($member['tscno'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($member['surname'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($member['name'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($member['cellnumber'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($member['gender'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($member['dob'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($member['schoolcode'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($member['resident'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($member['last_beneficiary_change'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo (int)($member['payable_beneficiaries'] ?? 0); ?></td>
                                    <td><?php echo number_format((float)($member['monthly_fee'] ?? 0), 2); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>

<script>
$(document).ready(function () {
    $('#datatable-new-members').DataTable({
        pageLength: 25
    });

    $('#datatable-modified-members').DataTable({
        pageLength: 25
    });
});
</script>
