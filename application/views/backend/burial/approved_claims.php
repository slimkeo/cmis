<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">
                <h2 class="panel-title">Approved Claims</h2>
            </header>
            <div class="panel-body">
                <table class="table table-bordered table-striped mb-none" id="datatable-approved-claims">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Member</th>
                            <th>Beneficiary / Nominee</th>
                            <th>Claim Type</th>
                            <th>Amount</th>
                            <th>Claim Date</th>
                            <th>Status</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        if (!empty($claims)):
                            foreach ($claims as $row):
                                // Get member name
                                $member = $this->db->get_where('members', array('id' => $row['member_id']))->row();
                                $member_name = $member ? $member->surname . ' ' . $member->name : '-';

                                // Get beneficiary or nominee name based on claim type
                                if ($row['claim_type'] === 'BENEFICIARY') {
                                    $beneficiary = $this->db->get_where('beneficiaries', array('id' => $row['beneficiary_id']))->row();
                                    $claimant_name = $beneficiary ? $beneficiary->fullname : '-';
                                } else {
                                    // MEMBER claim - get nominee name if nominee_id exists
                                    if (!empty($row['nominee_id'])) {
                                        $nominee = $this->db->get_where('nominee', array('id' => $row['nominee_id']))->row();
                                        $claimant_name = $nominee ? $nominee->fullname : 'Member Claim';
                                    } else {
                                        $claimant_name = 'Member Claim';
                                    }
                                }
                        ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo htmlspecialchars($member_name); ?></td>
                            <td><?php echo htmlspecialchars($claimant_name); ?></td>
                            <td>
                                <span class="label label-<?php echo ($row['claim_type'] === 'BENEFICIARY') ? 'primary' : 'success'; ?>">
                                    <?php echo htmlspecialchars($row['claim_type']); ?>
                                </span>
                            </td>
                            <td><?php echo number_format($row['amount'], 2); ?></td>
                            <td><?php echo !empty($row['claim_date']) ? date('d-m-Y', strtotime($row['claim_date'])) : '-'; ?></td>
                            <td>
                                <span class="label label-<?php 
                                    if ($row['status'] == 'PENDING') echo 'warning';
                                    elseif ($row['status'] == 'APPROVED') echo 'success';
                                    elseif ($row['status'] == 'REJECTED') echo 'danger';
                                    elseif ($row['status'] == 'PAID') echo 'info';
                                ?>">
                                    <?php echo htmlspecialchars($row['status']); ?>
                                </span>
                            </td>
                            <td>
                                <a href="<?php echo base_url(); ?>index.php?burial/claims/view/<?php echo $row['id']; ?>" 
                                   class="btn btn-xs btn-info" target="_blank">
                                    <i class="fa fa-eye"></i> View
                                </a>
                            </td>
                        </tr>
                        <?php
                            endforeach;
                        else:
                        ?>
                        <tr>
                            <td colspan="8" class="text-center">No approved claims found.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#datatable-approved-claims').DataTable();
    });
</script>