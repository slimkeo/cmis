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
        <section class="panel">
            <header class="panel-heading">
                <h4 class="panel-title">Claim Details #<?php echo htmlspecialchars($claim['id'] ?? '-'); ?></h4>
            </header>
            <div class="panel-body">
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
                            <tr><th>Date of Entry</th><td><?php echo !empty($claim['date_of_entry']) ? date('d-m-Y', strtotime($claim['date_of_burial'])) : '-'; ?></td></tr>
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

                <h5 style="margin-top: 20px;">Documents</h5>
                <?php if (!empty($documents)): ?>
                    <ul class="list-group">
                        <?php foreach ($documents as $doc): ?>
                            <li class="list-group-item">
                                <strong><?php echo htmlspecialchars($doc['description']); ?></strong>
                                <div class="pull-right">
                                    <a href="<?php echo base_url($doc['path']); ?>" class="btn btn-xs btn-default" target="_blank"><i class="fa fa-eye"></i> View</a>
                                    <a href="<?php echo base_url($doc['path']); ?>" class="btn btn-xs btn-info" download><i class="fa fa-download"></i> Download</a>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>No documents uploaded.</p>
                <?php endif; ?>

                <div style="margin-top:20px;">
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
                    <a href="<?php echo base_url('index.php?burial/print_claims_details/'.$claim['id']); ?>"><i class="fa fa-print">Print Claim</i></a>
                </div>
            </div>
        </section>
    </div>
</div>

<script>
$(function(){
    $('#approve_btn').click(function(e){
        if(!confirm('Approve this claim?')){ e.preventDefault(); }
    });
    $('#reject_btn').click(function(e){
        if(!confirm('Reject this claim?')){ e.preventDefault(); }
    });
    $('#pay_btn').click(function(e){
        if(!confirm('Mark this claim as PAID?')){ e.preventDefault(); }
    });
});
</script>
