<?php
$member_data = $this->db->get_where('members', array('id' => $memberid))->result_array();
foreach ($member_data as $member_row):

		$beneficiaries = $this->Beneficiary_model->get_by_member($member_row['id']);

		$summary = $this->Beneficiary_model->get_payable_summary($member_row['id']);

		$total_beneficiaries     = $summary['total_beneficiaries'];
		$payable_beneficiaries   = $summary['payable_beneficiaries'];
		$beneficiary_fee         = $summary['payable_beneficiary_fee'];

		$total_monthly           = $this->Beneficiary_model->get_total_monthly_fee($member_row['id']);

		$fees = $this->Beneficiary_model->get_fee_settings();

		$principal_fee = $fees['principal_fee'];
		$member_fee    = $fees['member_fee'];
		$spouse_fee    = $fees['spouse_fee'];

		// For display breakdown only (members vs spouses among payable beneficiaries)
		$non_payable_statuses = [
			'BENEFITTED - REPLACED',
			'DECEASED - REPLACED',
			'DELETED'
		];

		$payable_list = array_filter($beneficiaries, function($b) use ($non_payable_statuses) {
			$status = trim($b['status'] ?? '');
			return !in_array($status, $non_payable_statuses, true);
		});

		$payable_members_count = count(array_filter($payable_list, function($b) {
			return $b['is_spouse'] == 0;
		}));

		$payable_spouses_count = count(array_filter($payable_list, function($b) {
			return $b['is_spouse'] == 1;
		}));

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
			<li>
				<a href="#batch_add" data-toggle="tab"><i class="fa fa-plus-circle"></i>
					Batch Add Beneficiaries
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

			<div class="summary-box" style="margin-top: 25px; padding: 20px; background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 6px;">
				<div class="info-row" style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #eee;">
					<span class="info-label"><strong>Principal Fee:</strong></span>
					<span>E <?php echo number_format($principal_fee, 2); ?></span>
				</div>

				<div class="info-row" style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #eee;">
					<span class="info-label"><strong>Total Beneficiaries:</strong></span>
					<span><?php echo $total_beneficiaries; ?></span>
				</div>

				<div class="info-row" style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #eee;">
					<span class="info-label"><strong>Payable Beneficiaries:</strong></span>
					<span><?php echo $payable_beneficiaries; ?></span>
				</div>

				<div class="info-row" style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #eee;">
					<span class="info-label"><strong>Beneficiary Fee:</strong></span>
					<div>
						<span>E <?php echo number_format($beneficiary_fee, 2); ?></span>
						<small style="display: block; color: #6c757d; margin-top: 4px;">
							(<?php echo $payable_members_count; ?> members × E<?php echo number_format($member_fee, 2); ?> + 
							<?php echo $payable_spouses_count; ?> spouses × E<?php echo number_format($spouse_fee, 2); ?>)
						</small>
					</div>
				</div>

				<div class="info-row total" style="display: flex; justify-content: space-between; padding: 16px 0 8px 0; font-size: 18px; font-weight: bold; border-top: 2px solid #343a40; margin-top: 12px;">
					<span>Total Monthly Contribution:</span>
					<span>E <?php echo number_format($total_monthly, 2); ?></span>
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
						<!-- Spouse? -->
						<div class="form-group">
							<label class="col-sm-3 control-label">Is Spouse?</label>
							<div class="col-sm-7">
								<div>
									<label style="display: inline; margin-right: 20px;">
										<input type="radio" name="is_spouse" value="0" checked> No
									</label>
									<label style="display: inline;">
										<input type="radio" name="is_spouse" value="1"> Yes
									</label>
								</div>
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

			<!--BATCH CREATION FORM STARTS-->
			<div class="tab-pane box" id="batch_add" style="padding: 15px">
				<div class="box-content">
					<?php echo form_open(base_url() . 'index.php?burial/beneficiaries/'.$member_row['id'].'/add_batch_beneficiaries',
			        array('class' => 'form-horizontal form-bordered','enctype'=>'multipart/form-data'));?>

						<!-- Submission Date -->
						<div class="form-group">
							<label class="col-sm-3 control-label">Date of Submission</label>
							<div class="col-sm-3">
								<input type="text" name="batch_submission_date" class="form-control datepicker" placeholder="dd-mm-yyyy" required>
							</div>
						</div>

						<!-- Beneficiaries Table -->
						<div style="overflow-x: auto; margin-top: 20px;">
							<table class="table table-bordered table-striped table-condensed" id="batch-beneficiaries-table">
								<thead>
									<tr style="background-color: #f5f5f5;">
										<th style="width: 3%;">#</th>
										<th style="width: 25%;">Full Name <span style="color:red;">*</span></th>
										<th style="width: 8%;">Gender <span style="color:red;">*</span></th>
										<th style="width: 12%;">DOB (Optional)</th>
										<th style="width: 12%;">Spouse?</th>
										<th style="width: 12%;">Status <span style="color:red;">*</span></th>
										<th style="width: 12%;">Status Date</th>
										<th style="width: 8%; text-align: center;">Action</th>
									</tr>
								</thead>
								<tbody id="beneficiaries-container">
									<!-- Rows will be added here -->
								</tbody>
							</table>
						</div>

						<!-- Add More Button -->
						<div style="margin-top: 15px;">
							<button type="button" class="btn btn-info" id="add-beneficiary-row">
								<i class="fa fa-plus"></i> Add Row
							</button>
						</div>

						<!-- Submit -->
						<div style="margin-top: 20px;">
							<button type="submit" class="btn btn-primary">
								<i class="fa fa-save"></i> Add Batch Beneficiaries
							</button>
							<button type="reset" class="btn btn-default">
								<i class="fa fa-refresh"></i> Clear
							</button>
						</div>
				</form>                
				</div>                
			</div>
			<!--BATCH CREATION FORM ENDS-->

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

    // Batch Add Beneficiaries - Dynamic Row Management (Table Format)
    (function() {
        let rowCount = 0;

        function createBeneficiaryRow(index) {
            const rowHTML = `
                <tr id="batch-row-${index}" class="batch-beneficiary-row">
                    <td style="text-align: center; vertical-align: middle;">
                        <span class="row-number">${index + 1}</span>
                    </td>
                    <td>
                        <input type="text" name="batch_fullname[]" class="form-control" placeholder="Full name" required style="width: 100%; margin: 0;">
                    </td>
                    <td>
                        <select name="batch_gender[]" class="form-control" required style="width: 100%; margin: 0;">
                            <option value="">Select</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" name="batch_dob[]" class="form-control datepicker" placeholder="dd-mm-yyyy" style="width: 100%; margin: 0;">
                    </td>
                    <td style="text-align: center;">
                        <select name="batch_is_spouse[]" class="form-control" style="width: 100%; margin: 0;">
                            <option value="0" selected>No</option>
                            <option value="1">Yes</option>
                        </select>
                    </td>
                    <td>
                        <select name="batch_status[]" class="batch-status-select form-control" data-index="${index}" required style="width: 100%; margin: 0;">
                            <option value="ACTIVE">ACTIVE</option>
                            <option value="BENEFITTED">BENEFITTED</option>
                            <option value="DELETED">DELETED</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" name="batch_status_date[]" class="form-control batch-status-date datepicker" data-index="${index}" placeholder="dd-mm-yyyy" style="width: 100%; margin: 0; display: none;">
                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                        ${index > 0 ? `<button type="button" class="btn btn-danger btn-xs remove-row" data-index="${index}" title="Remove row"><i class="fa fa-trash"></i></button>` : `<span style="color: #999;">---</span>`}
                    </td>
                </tr>
            `;
            return rowHTML;
        }

        function updateRowNumbers() {
            document.querySelectorAll('.batch-beneficiary-row').forEach((row, idx) => {
                row.querySelector('.row-number').textContent = idx + 1;
            });
        }

        function initializeRow(index) {
            const statusSelect = document.querySelector(`select[data-index="${index}"].batch-status-select`);
            if (!statusSelect) return;

            const row = statusSelect.closest('tr');
            const statusDateInput = row.querySelector(`input[data-index="${index}"].batch-status-date`);

            statusSelect.addEventListener('change', function() {
                const status = this.value;

                if (statusDateInput) {
                    if (status === 'BENEFITTED' || status === 'DELETED') {
                        statusDateInput.style.display = 'block';
                        statusDateInput.required = true;
                    } else {
                        statusDateInput.style.display = 'none';
                        statusDateInput.required = false;
                        statusDateInput.value = '';
                    }
                }
            });
        }

        // Add initial 5 rows
        const container = document.getElementById('beneficiaries-container');
        if (container) {
            for (let i = 0; i < 5; i++) {
                container.insertAdjacentHTML('beforeend', createBeneficiaryRow(i));
                initializeRow(i);
                rowCount++;
            }
        }

        // Add More Button
        const addBtn = document.getElementById('add-beneficiary-row');
        if (addBtn) {
            addBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const newRow = createBeneficiaryRow(rowCount);
                container.insertAdjacentHTML('beforeend', newRow);
                initializeRow(rowCount);
                rowCount++;
                updateRowNumbers();

                // Reinitialize datepickers for new rows
                if (typeof jQuery !== 'undefined' && jQuery.fn.datepicker) {
                    jQuery('.datepicker').datepicker();
                }

                // Remove button functionality for new rows
                attachRemoveListener(rowCount - 1);
            });
        }

        function attachRemoveListener(index) {
            const removeBtn = document.querySelector(`button[data-index="${index}"].remove-row`);
            if (removeBtn) {
                removeBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const row = document.getElementById(`batch-row-${index}`);
                    if (row) {
                        row.remove();
                        updateRowNumbers();
                    }
                });
            }
        }

        // Attach remove listeners to initial rows
        document.querySelectorAll('.remove-row').forEach(btn => {
            const idx = btn.getAttribute('data-index');
            attachRemoveListener(idx);
        });
    })();
</script>

<?php
endforeach;
?>
