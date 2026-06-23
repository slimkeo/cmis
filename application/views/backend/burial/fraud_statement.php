<?php
$memberName = trim(($recovery->surname ?? '') . ' ' . ($recovery->name ?? ''));
?>
<div class="row">
    <div class="col-md-12">
        <h4>Fraud Recovery Statement</h4>
        <p>
            <strong>Member:</strong> <?php echo htmlspecialchars($memberName); ?> |
            <strong>ID:</strong> <?php echo htmlspecialchars($recovery->idnumber ?? ''); ?> |
            <strong>Employee No:</strong> <?php echo htmlspecialchars($recovery->employeeno ?? ''); ?> |
            <strong>Passbook:</strong> <?php echo htmlspecialchars($recovery->passbook_no ?? ''); ?>
        </p>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading"><strong>Amount Owed</strong></div>
            <div class="panel-body"><?php echo number_format((float) ($recovery->amount_owed ?? 0), 2); ?></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading"><strong>Total Paid</strong></div>
            <div class="panel-body"><?php echo number_format((float) ($total_paid ?? 0), 2); ?></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading"><strong>Balance</strong></div>
            <div class="panel-body"><?php echo number_format((float) ($balance ?? 0), 2); ?></div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">Add Payment</div>
            <div class="panel-body">
                <?php echo form_open(base_url('index.php?burial/add_fraud_recovery_payment/' . (int) $recovery->recovery_id), array('class' => 'form-horizontal form-bordered validate')); ?>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Payment Date</label>
                        <div class="col-md-4">
                            <input type="date" class="form-control" name="payment_date" required>
                        </div>

                        <label class="col-md-2 control-label">Amount Paid</label>
                        <div class="col-md-4">
                            <input type="number" step="0.01" min="0.01" class="form-control" name="amount_paid" required placeholder="0.00">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Payment Method</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="payment_method" placeholder="Cash, Bank, Mobile Money">
                        </div>

                        <label class="col-md-2 control-label">Reference No</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="reference_no" placeholder="Reference / Receipt number">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Remarks</label>
                        <div class="col-md-10">
                            <textarea class="form-control" rows="3" name="remarks" placeholder="Optional notes"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-10 col-md-offset-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-save"></i> Save Payment
                            </button>
                            <a href="<?php echo base_url('index.php?burial/fraudsters'); ?>" class="btn btn-default">Back to Fraud Recoveries</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered table-striped mb-none" id="datatable-fraud-payments">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Payment Date</th>
                    <th>Amount Paid</th>
                    <th>Method</th>
                    <th>Reference</th>
                    <th>Remarks</th>
                    <th>Captured At</th>
                    <th>Receipt</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<script>
$(document).ready(function() {
    var recoveryId = "<?php echo (int) $recovery->recovery_id; ?>";

    $('#datatable-fraud-payments').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "<?php echo base_url('index.php?burial/get_fraud_recovery_payments'); ?>",
            type: "POST",
            data: function(d) {
                d.recovery_id = recoveryId;
            }
        },
        order: [[1, 'desc']],
        dom: 'Bfrtip',
        buttons: [
            { extend: 'copy', text: 'Copy' },
            { extend: 'excel', text: 'Excel' },
            { extend: 'pdf', text: 'PDF' },
            { extend: 'print', text: 'Print' }
        ]
    });
});
</script>
