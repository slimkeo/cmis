<?php
$start_date = isset($start_date) ? $start_date : '';
$end_date = isset($end_date) ? $end_date : '';
$new_members = isset($new_members) && is_array($new_members) ? $new_members : array();
$beneficiary_updates = isset($beneficiary_updates) && is_array($beneficiary_updates) ? $beneficiary_updates : array();
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
                    Beneficiary changes found: <strong><?php echo count($beneficiary_updates); ?></strong>
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
                            <th>Timestamp</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($new_members)): ?>
                            <tr><td colspan="15">No new members found in selected date range.</td></tr>
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
                                    <td><?php echo htmlspecialchars($member['timestamp'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>

                <h4 style="margin-top:20px;">Members With Beneficiary Modifications</h4>
                <table class="table table-bordered table-striped mb-none" id="datatable-beneficiary-updates">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Beneficiary ID</th>
                            <th>Member ID</th>
                            <th>Fullname</th>
                            <th>Gender</th>
                            <th>DOB</th>
                            <th>Spouse</th>
                            <th>Status</th>
                            <th>Submission Date</th>
                            <th>Status Date</th>
                            <th>Replaced</th>
                            <th>Replaced With</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($beneficiary_updates)): ?>
                            <tr><td colspan="14">No beneficiary modifications found in selected date range.</td></tr>
                        <?php else: ?>
                            <?php $j = 1; foreach ($beneficiary_updates as $beneficiary): ?>
                                <tr>
                                    <td><?php echo $j++; ?></td>
                                    <td><?php echo (int)($beneficiary['id'] ?? 0); ?></td>
                                    <td><?php echo htmlspecialchars($beneficiary['memberid'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($beneficiary['fullname'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($beneficiary['gender'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($beneficiary['dob'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($beneficiary['is_spouse'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($beneficiary['status'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($beneficiary['submission_date'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($beneficiary['status_date'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($beneficiary['replaced'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($beneficiary['replaced_with'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($beneficiary['created_at'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($beneficiary['updated_at'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>
