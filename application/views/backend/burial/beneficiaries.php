<?php
$member_data = $this->db->get_where('members', array('id' => $memberid))->result_array();
foreach ($member_data as $member_row):

    $beneficiaries = $this->Beneficiary_model->get_by_member($member_row['id']);

    $summary = $this->Beneficiary_model->get_payable_summary($member_row['id']);

    $beneficiary_count     = $summary['total_beneficiaries'];
    $payable_beneficiaries = $summary['payable_beneficiaries'];

    /* =========================
       FEES
    ========================= */
    $principal_fee = (float) $this->db
        ->get_where('settings', ['type' => 'principal_fee'])
        ->row()->description;

    $member_fee = (float) $this->db
        ->get_where('settings', ['type' => 'member_fee'])
        ->row()->description;

    $beneficiary_fee = $member_fee * $payable_beneficiaries;
    $total_monthly   = $principal_fee + $beneficiary_fee;
?>

<div class="row">
	<div class="col-md-12">

		<!---CONTROL TABS START-->
		<div class="tabs">
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#list" data-toggle="tab"><i class="fa fa-list"></i> 
					<?php echo get_phrase('beneficiaries_list');?>
				</a>
			</li>
			<li>
				<a href="#add" data-toggle="tab"><i class="fa fa-plus-circle"></i>
					<?php echo get_phrase('add_beneficiary');?>
				</a>
			</li>
		</ul>
		<!---CONTROL TABS END-->

		<div class="tab-content">
		<br>
			<!--TABLE LISTING STARTS-->
			<div class="tab-pane box active" id="list">
				<table class="table table-bordered table-striped table-condensed mb-none" id="datatable-tabletools">
					<thead>
						<tr>
							<th><div>#</div></th>
							<th><div>Full Name</div></th>
							<th><div>Gender</div></th>
							<th><div>Date of Birth</div></th>
							<th><div>Date of Submission</div></th>
							<th><div>Status</div></th>
							<th><div>Status Changed</div></th>
							<th><div>Maturity Status</div></th>
							<th><div><?php echo get_phrase('options');?></div></th>
						</tr>
					</thead>
					<tbody>
						<?php 
						$beneficiaries = $this->db->get_where('beneficiaries', array('memberid' => $member_row['id']))->result_array();
						$count = 1;
						foreach($beneficiaries as $b): 
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
							
							// Determine maturity status text and badge class
							if ($b['status'] == 'BENEFITTED' || $b['status'] == 'BENEFITTED - REPLACED'| $b['status'] == 'DECEASED - REPLACED'| $b['status'] == 'DELETED') {
								$maturity_status = $b['status'];
								$maturity_badge = 'label-danger';
								$row_class = 'danger';
							} elseif ($b['status'] == 'REPLACEE') {
								$maturity_status = 'Matured';
								$maturity_badge = 'label-success';
								$row_class = 'success';
							} elseif ($is_matured) {
								$maturity_status = 'Matured';
								$maturity_badge = 'label-success';
								$row_class = 'success';
							} else {
								$maturity_status = 'Waiting';
								$maturity_badge = 'label-warning';
								$row_class = 'warning';
							}
						?>
						<tr class="<?php echo $row_class; ?>">
							<td><?php echo $count++; ?></td>
							<td><?php echo $b['fullname']; ?></td>
							<td><?php echo $b['gender']; ?></td>
							<td><?php echo $b['dob']; ?></td>
							<td><?php echo $b['submission_date']; ?></td>
							<td><?php echo $b['status']; ?></td>
							<td><?php echo $b['status_date']; ?></td>
							<td>
								<span class="label <?php echo $maturity_badge; ?>">
									<?php echo $maturity_status; ?>
								</span>
							</td>
							<td>
								<!-- EDITING LINK -->
								<a href="#" class="btn btn-primary btn-xs" data-placement="top" data-toggle="tooltip" data-original-title="<?php echo get_phrase('edit');?>" onClick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_edit_beneficiary/<?php echo $member_row['id']; ?>/<?php echo $b['id']; ?>');">
									<i class="fa fa-pencil"></i>
								</a>

								<!-- DELETION LINK -->
								<a href="#" class="btn btn-danger btn-xs" data-placement="top" data-toggle="tooltip" data-original-title="<?php echo get_phrase('delete');?>" onClick="confirm_modal('<?php echo base_url();?>index.php?burial/beneficiaries/<?php echo $member_row['id']; ?>/delete_beneficiary/<?php echo $b['id']; ?>');">
									<i class="fa fa-trash"></i>
								</a>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>

				<div class="summary-box">
					<div class="info-row">
						<span class="info-label">Principal Fee:</span>
						E <?php echo number_format($principal_fee, 2); ?>
					</div>

					<div class="info-row">
						<span class="info-label">Total Beneficiaries:</span>
						<?php echo $beneficiary_count; ?>
					</div>

					<div class="info-row">
						<span class="info-label">Payable Beneficiaries:</span>
						<?php echo $payable_beneficiaries; ?>
					</div>

					<div class="info-row">
						<span class="info-label">
							Beneficiary Fee
							(<?php echo $payable_beneficiaries; ?> ×
							E <?php echo number_format($member_fee, 2); ?>):
						</span>
						E <?php echo number_format($beneficiary_fee, 2); ?>
					</div>

					<div class="info-row" style="font-size:16px;font-weight:bold;border-top:2px solid #333;">
						Total Monthly Contribution:
						E <?php echo number_format($total_monthly, 2); ?>
					</div>
				</div>				
			</div>
			<!--TABLE LISTING ENDS-->

			<!--CREATION FORM STARTS-->
			<div class="tab-pane box" id="add" style="padding: 5px">
				<div class="box-content">
					<?php echo form_open(base_url() . 'index.php?burial/beneficiaries/'.$member_row['id'].'/add_beneficiary',
			        array('class' => 'form-horizontal form-bordered validate','enctype'=>'multipart/form-data'));?>

							<!-- Full Name -->
							<div class="form-group">
								<label class="col-sm-3 control-label">Full Name</label>
								<div class="col-sm-7">
									<input
										type="text"
										name="fullname"
										class="form-control"
										placeholder="Enter beneficiary full name"
										required>
								</div>
							</div>

							<!-- Gender -->
							<div class="form-group">
								<label class="col-sm-3 control-label">Gender</label>
								<div class="col-sm-7">
									<select name="gender" class="form-control" required>
										<option value="">-- Select Gender --</option>
										<option value="Male">Male</option>
										<option value="Female">Female</option>
									</select>
								</div>
							</div>

							<!-- Date of Birth -->
							<div class="form-group">
								<label class="col-sm-3 control-label">Date of Birth</label>
								<div class="col-sm-7">
									<input type="text" name="dob" class="form-control datepicker" placeholder="dd-mm-yyyy" required>
								</div>
							</div>

							<!-- Submission Date -->
							<div class="form-group">
								<label class="col-sm-3 control-label">Submission Date</label>
								<div class="col-sm-7">
									<input type="text" name="submission_date" class="form-control datepicker" placeholder="dd-mm-yyyy" required>
								</div>
							</div>

							<!-- Status -->
							<div class="form-group">
								<label class="col-sm-3 control-label">Status</label>
								<div class="col-sm-7">
									<select name="status" id="beneficiary-status" class="form-control" required>
										<option value="">-- Select Status --</option>
										<option value="ACTIVE">ACTIVE</option>
										<option value="WAITING">WAITING</option>
										<option value="BENEFITTED">BENEFITTED</option>
										<option value="REPLACED">REPLACED</option>
										<option value="BENEFITTED - REPLACED">BENEFITTED - REPLACED</option>
										<option value="DELETED">DELETED</option>
										<option value="REPLACEE">REPLACEE</option>
									</select>
								</div>
							</div>

							<!-- Status Date (status_date in DB) - BENEFITTED date or Death Certificate date -->
							<div class="form-group" id="status-date-group" style="display: none;">
								<label class="col-sm-3 control-label" id="status-date-label">Status Date</label>
								<div class="col-sm-7">
									<input type="text" name="status_date" class="form-control datepicker" placeholder="dd-mm-yyyy">
								</div>
							</div>

							<!-- Replace With Dropdown - shown only when status is REPLACEE -->
							<div class="form-group" id="replace-with-group" style="display: none;">
								<label class="col-sm-3 control-label">Replace With</label>
								<div class="col-sm-7">
									<select name="replaced_with" id="replaced-with-select" class="form-control">
										<option value="">-- Select Beneficiary to Replace --</option>
										<?php
										// List replaceable beneficiaries for this member (exclude deleted and already replaced)
										$this->db->where('memberid', $member_row['id']);
										// Exclude deleted; allow REPLACEE too
										$this->db->where('status !=', 'DELETED');
										// Do not allow already-replaced beneficiaries to be selected again
										$this->db->where('status !=', 'BENEFITTED - REPLACED');
										$this->db->group_start();
										// include unreplaced
										$this->db->where('replaced', 0);
										$this->db->or_where('replaced IS NULL', null, false);
										// also include REPLACEE even if marked replaced
										$this->db->or_where('status', 'REPLACEE');
										$this->db->group_end();
										$existing_beneficiaries = $this->db->get('beneficiaries')->result_array();

										if (!empty($existing_beneficiaries)):
											foreach ($existing_beneficiaries as $eb):
										?>
											<option value="<?php echo $eb['id']; ?>">
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
							
							<div class="form-group">
								<div class="col-sm-offset-3 col-sm-5">
									<button type="submit" class="btn btn-primary"><?php echo get_phrase('add_beneficiary');?></button>
								</div>
							</div>
					</form>                
				</div>                
			</div>
			<!--CREATION FORM ENDS-->

		</div>
	</div>
</div>

<script>
    // Status field toggle logic for Add Beneficiary form
    (function() {
        var statusSelect = document.getElementById('beneficiary-status');
        var statusDateGroup = document.getElementById('status-date-group');
        var statusDateLabel = document.getElementById('status-date-label');
        var statusDateInput = statusDateGroup ? statusDateGroup.querySelector('input[name="status_date"]') : null;
        var replaceWithGroup = document.getElementById('replace-with-group');
        var replacedWithSelect = document.getElementById('replaced-with-select');

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
                    // required for replacement (controller will validate window)
                    statusDateInput.required = true;
                } else {
                    statusDateGroup.style.display = 'none';
                    statusDateInput.required = false;
                    statusDateInput.value = '';
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
