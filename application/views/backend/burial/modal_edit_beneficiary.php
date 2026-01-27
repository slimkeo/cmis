<?php
$edit_data = $this->db->get_where('beneficiaries', array('id' => $param3))->result_array();
foreach ($edit_data as $row):
?>
<div class="row">
    <div class="col-md-12">
        <section class="panel">
            
            <?php echo form_open(base_url() . 'index.php?burial/beneficiaries/'.$param2.'/edit_beneficiary/'.$row['id'], 
                array('class' => 'form-horizontal form-bordered','target'=>'_top', 'id' => 'form', 'enctype' => 'multipart/form-data'));?>
            
            <div class="panel-heading">
                <h4 class="panel-title">
                    <i class="fa fa-pencil-square"></i>
                    Edit Beneficiary: <?php echo $row['fullname']; ?>
                </h4>
            </div>

            <div class="panel-body">
                <!-- Full Name -->
                <div class="form-group">
                    <label class="col-md-3 control-label">Full Name</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" required name="fullname" value="<?php echo $row['fullname']; ?>"/>
                    </div>
                </div>

                <!-- Gender -->
                <div class="form-group">
                    <label class="col-md-3 control-label">Gender</label>
                    <div class="col-md-7">
                        <select name="gender" class="form-control" required>
                            <option value="">-- Select Gender --</option>
                            <option value="Male" <?php echo ($row['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                            <option value="Female" <?php echo ($row['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                        </select>
                    </div>
                </div>

                <!-- Date of Birth -->
                <div class="form-group">
                    <label class="col-md-3 control-label">Date of Birth</label>
                    <div class="col-md-7">
                        <input type="text" name="dob" class="form-control datepicker" placeholder="dd-mm-yyyy" value="<?php echo $row['dob']; ?>" required>
                    </div>
                </div>

                <!-- Submission Date -->
                <div class="form-group">
                    <label class="col-md-3 control-label">Submission Date</label>
                    <div class="col-md-7">
                        <input type="text" name="submission_date" class="form-control datepicker" placeholder="dd-mm-yyyy" value="<?php echo $row['submission_date']; ?>" required>
                    </div>
                </div>

                <!-- Status -->
                <div class="form-group">
                    <label class="col-md-3 control-label">Status</label>
                    <div class="col-md-7">
                        <select name="status" id="beneficiary-status-edit" class="form-control" required>
                            <option value="">-- Select Status --</option>
                            <option value="ACTIVE" <?php echo ($row['status'] == 'ACTIVE') ? 'selected' : ''; ?>>ACTIVE</option>
                            <option value="WAITING" <?php echo ($row['status'] == 'WAITING') ? 'selected' : ''; ?>>WAITING</option>
                            <option value="BENEFITTED" <?php echo ($row['status'] == 'BENEFITTED') ? 'selected' : ''; ?>>BENEFITTED</option>
                            <option value="REPLACED" <?php echo ($row['status'] == 'REPLACED') ? 'selected' : ''; ?>>REPLACED</option>
                            <option value="BENEFITTED - REPLACED" <?php echo ($row['status'] == 'BENEFITTED - REPLACED') ? 'selected' : ''; ?>>BENEFITTED - REPLACED</option>
                            <option value="DELETED" <?php echo ($row['status'] == 'DELETED') ? 'selected' : ''; ?>>DELETED</option>
                            <option value="REPLACEE" <?php echo ($row['status'] == 'REPLACEE') ? 'selected' : ''; ?>>REPLACEE</option>
                        </select>
                    </div>
                </div>

                <!-- Status Date (status_date in DB) -->
                <div class="form-group" id="status-date-group-edit" style="display: <?php echo ($row['status'] == 'BENEFITTED' || $row['status'] == 'BENEFITTED - REPLACED' || $row['status'] == 'REPLACEE') ? 'block' : 'none'; ?>;">
                    <label class="col-md-3 control-label" id="status-date-label-edit">
                        <?php echo ($row['status'] == 'REPLACEE') ? 'Death Certificate Date' : 'Benefitted Date'; ?>
                    </label>
                    <div class="col-md-7">
                        <input type="text" name="status_date" class="form-control datepicker" placeholder="dd-mm-yyyy" value="<?php echo $row['status_date']; ?>">
                    </div>
                </div>

                <!-- Replace With Dropdown - shown only when status is REPLACEE -->
                <div class="form-group" id="replace-with-group-edit" style="display: <?php echo ($row['status'] == 'REPLACEE') ? 'block' : 'none'; ?>;">
                    <label class="col-md-3 control-label">Replace With</label>
                    <div class="col-md-7">
                        <select name="replaced_with" id="replaced-with-select-edit" class="form-control">
                            <option value="">-- Select Beneficiary to Replace --</option>
                            <?php
                            // List replaceable beneficiaries for this member (exclude deleted and already replaced)
                            $this->db->where('memberid', $param2);
                            $this->db->where('id !=', $row['id']); // Exclude current beneficiary
                            $this->db->where('status !=', 'DELETED');
                            $this->db->where('status !=', 'BENEFITTED - REPLACED');
                            $this->db->group_start();
                            $this->db->where('replaced', 0);
                            $this->db->or_where('replaced IS NULL', null, false);
                            $this->db->group_end();
                            $eligible_beneficiaries = $this->db->get('beneficiaries')->result_array();
                            
                            if (!empty($eligible_beneficiaries)):
                                foreach ($eligible_beneficiaries as $eb):
                            ?>
                                <option value="<?php echo $eb['id']; ?>" <?php echo ($row['replaced_with'] == $eb['id']) ? 'selected' : ''; ?>>
                                    <?php echo $eb['fullname'] . ' (' . $eb['status'] . ' | ' . $eb['submission_date'] . ')'; ?>
                                </option>
                            <?php 
                                endforeach;
                            else:
                            ?>
                                <option value="" disabled>No beneficiaries available to replace</option>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>

            </div>
            <footer class="panel-footer">
                <div class="row">
                    <div class="col-sm-9 col-sm-offset-3">
                        <button type="submit" class="btn btn-primary">UPDATE BENEFICIARY</button>
                    </div>
                </div>
            </footer>
            <?php echo form_close(); ?>
        </section>
    </div>
</div>

<script>
    (function() {
        var statusSelect = document.getElementById('beneficiary-status-edit');
        var statusDateGroup = document.getElementById('status-date-group-edit');
        var statusDateLabel = document.getElementById('status-date-label-edit');
        var statusDateInput = statusDateGroup ? statusDateGroup.querySelector('input[name="status_date"]') : null;
        var replaceWithGroup = document.getElementById('replace-with-group-edit');
        var replacedWithSelect = document.getElementById('replaced-with-select-edit');

        if (!statusSelect) return;

        function toggleStatusFields() {
            var status = statusSelect.value;
            
            // Handle status_date field
            if (statusDateGroup && statusDateInput) {
                if (status === 'BENEFITTED' || status === 'BENEFITTED - REPLACED') {
                    statusDateGroup.style.display = 'block';
                    if (statusDateLabel) statusDateLabel.textContent = 'Benefitted Date';
                    statusDateInput.required = true;
                } else if (status === 'REPLACEE') {
                    statusDateGroup.style.display = 'block';
                    if (statusDateLabel) statusDateLabel.textContent = 'Death Certificate Date';
                    statusDateInput.required = true;
                } else {
                    statusDateGroup.style.display = 'none';
                    statusDateInput.required = false;
                }
            }
            
            // Handle Replace With dropdown
            if (replaceWithGroup) {
                if (status === 'REPLACEE') {
                    replaceWithGroup.style.display = 'block';
                    if (replacedWithSelect) {
                        replacedWithSelect.required = true;
                    }
                } else {
                    replaceWithGroup.style.display = 'none';
                    if (replacedWithSelect) {
                        replacedWithSelect.required = false;
                        replacedWithSelect.value = ''; // Clear selection
                    }
                }
            }
        }

        statusSelect.addEventListener('change', toggleStatusFields);
        // Initialize on page load
        toggleStatusFields();
    })();
</script>

<?php
endforeach;
?>
