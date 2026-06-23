<div class="row">
    <div class="col-md-12">
        <div class="tabs">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#list" data-toggle="tab"><i class="fa fa-list"></i> Fraud Recoveries</a>
                </li>
                <li>
                    <a href="#add" data-toggle="tab"><i class="fa fa-plus-circle"></i> Add Fraud Arrangement</a>
                </li>
            </ul>

            <div class="tab-content">
                <br>
                <div class="tab-pane box active" id="list">
                    <table class="table table-bordered table-striped mb-none" id="datatable-fraudsters">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ID Number</th>
                                <th>Emp No</th>
                                <th>Member Name</th>
                                <th>Passbook</th>
                                <th>Amount Owed</th>
                                <th>Total Paid</th>
                                <th>Balance</th>
                                <th>Status</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

                <div class="tab-pane box" id="add" style="padding: 10px;">
                    <?php echo form_open(base_url('index.php?burial/create_fraud_recovery'), array('class' => 'form-horizontal form-bordered validate')); ?>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Member</label>
                        <div class="col-md-7">
                            <select class="form-control" name="member_id" required>
                                <option value="">Select member</option>
                                <?php foreach (($members ?? []) as $m): ?>
                                    <option value="<?php echo (int) $m->id; ?>">
                                        <?php echo htmlspecialchars(trim($m->surname . ' ' . $m->name) . ' | ID: ' . ($m->idnumber ?? '') . ' | Emp: ' . ($m->employeeno ?? '') . ' | Passbook: ' . ($m->passbook_no ?? '')); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Amount Owed</label>
                        <div class="col-md-7">
                            <input type="number" step="0.01" min="0.01" class="form-control" name="amount_owed" required placeholder="0.00">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Arrangement Date</label>
                        <div class="col-md-7">
                            <input type="date" class="form-control" name="arrangement_date" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Status</label>
                        <div class="col-md-7">
                            <select class="form-control" name="status">
                                <option value="Active">Active</option>
                                <option value="Paid">Paid</option>
                                <option value="Written Off">Written Off</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Case Description</label>
                        <div class="col-md-7">
                            <textarea class="form-control" name="case_description" rows="4" placeholder="Describe the fraudulent claim/case"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-7 col-md-offset-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Save Arrangement
                            </button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#datatable-fraudsters').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "<?php echo base_url('index.php?burial/get_fraudsters'); ?>",
            type: "POST"
        },
        order: [[0, 'desc']],
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