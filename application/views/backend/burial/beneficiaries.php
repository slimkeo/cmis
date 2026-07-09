<?php
$status_enum = $this->Enum_model->get_enum_values('beneficiaries', 'status');
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
			'DELETED',
			'LATE NOT BENEFITTED',
			'LATE NOT BENEFITTED - REPLACED'
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
			<li>
				<a href="#replacing" data-toggle="tab"><i class="fa fa-recycle"></i>
					Replacing
				</a>
			</li>
			<li>
				<a href="<?php echo base_url('index.php?burial/member_details/'.$member_row['id']); ?>" 
						class="btn btn-xs btn-info">
							<i class="fa fa-user"></i>  Return to Profile
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
							if ($b['status'] == 'BENEFITTED' || $b['status'] == 'BENEFITTED - REPLACED'| $b['status'] == 'DECEASED - REPLACED'| $b['status'] == 'DELETED' | $b['status'] == 'LATE NOT BENEFITTED'| $b['status'] == 'LATE NOT BENEFITTED - REPLACED') {
								$maturity_status = $b['status'];
								$maturity_badge = 'label-danger';
								$row_class = 'danger';
							}// elseif ($b['status'] == 'REPLACEE') {
							//	$maturity_status = 'Matured';
							//	$maturity_badge = 'label-success';
							//	$row_class = 'success';
							//} 
							elseif ($is_matured) {
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
										<option value="M">Male</option>
										<option value="F">Female</option>
									</select>
								</div>
							</div>

							<!-- Date of Birth -->
							<div class="form-group">
								<label class="col-sm-3 control-label">Date of Birth</label>
								<div class="col-sm-7">
									<div class="input-group date" data-provide="datepicker"data-date-format="yyyy-mm-dd">
										<input type="text"
											class="form-control"
											name="dob"
											pattern="\d{4}-(?:0?[1-9]|1[0-2])-(?:0?[1-9]|[12]\d|3[01])"
											placeholder="yyyy-mm-dd"
											title="Format: yyyy-mm-dd (e.g. 2026-02-17)"
											>
										<span class="input-group-addon">
											<i class="glyphicon glyphicon-calendar"></i>   <!-- or font-awesome etc. -->
										</span>
									</div>
								</div>
							</div>

							<!-- Submission Date -->
							<div class="form-group">
								<label class="col-sm-3 control-label">Submission Date</label>
								<div class="col-sm-7">
									<div class="input-group date" data-provide="datepicker"data-date-format="yyyy-mm-dd">
										<input type="text"
											class="form-control"
											name="submission_date"
											pattern="\d{4}-(?:0?[1-9]|1[0-2])-(?:0?[1-9]|[12]\d|3[01])"
											placeholder="yyyy-mm-dd"
											title="Format: yyyy-mm-dd (e.g. 2026-02-17)"
											required>
										<span class="input-group-addon">
											<i class="glyphicon glyphicon-calendar"></i>   <!-- or font-awesome etc. -->
										</span>
									</div>
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
										<?php foreach ($status_enum as $value): ?>
											<option value="<?= $value ?>">
												<?= ucfirst($value) ?>
											</option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>



							<!-- Replace With Dropdown - shown only when status is REPLACEE -->
							<div class="form-group" id="replace-with-group" style="display: none;">
								<label class="col-sm-3 control-label">Replace</label>
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
												$status_date = isset($eb['status_date']) ? $eb['status_date'] : '';
										?>
											<option
												value="<?php echo $eb['id']; ?>"
												data-status-date="<?php echo htmlspecialchars($status_date, ENT_QUOTES, 'UTF-8'); ?>"
												data-status="<?php echo htmlspecialchars($eb['status'], ENT_QUOTES, 'UTF-8'); ?>">
												<?php
													$displayDate = ($eb['status'] === 'ACTIVE')
														? $eb['submission_date']
														: $eb['status_date'];
													echo $eb['fullname'] . ' (' . $eb['status'] . ' | ' . $displayDate . ')';
												?>
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
							
							<!-- Status Date (status_date in DB) - BENEFITTED date or Death Certificate date -->
							<div class="form-group" id="status-date-group" style="display: none;">
								<label class="col-sm-3 control-label" id="status-date-label">Status Date</label>
								<div class="col-sm-7">
									<div class="input-group date" data-provide="datepicker"data-date-format="yyyy-mm-dd">
										<input type="text"
											class="form-control"
											name="status_date"
											pattern="\d{4}-(?:0?[1-9]|1[0-2])-(?:0?[1-9]|[12]\d|3[01])"
											placeholder="yyyy-mm-dd"
											title="Format: yyyy-mm-dd (e.g. 2026-02-17)"
											required>
										<span class="input-group-addon">
											<i class="glyphicon glyphicon-calendar"></i>   <!-- or font-awesome etc. -->
										</span>
									</div>
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
							<div class="input-group date" data-provide="datepicker"data-date-format="yyyy-mm-dd">
										<input type="text"
											class="form-control"
											name="batch_submission_date"
											id="batch-submission-date"
											pattern="\d{4}-(?:0?[1-9]|1[0-2])-(?:0?[1-9]|[12]\d|3[01])"
											placeholder="yyyy-mm-dd"
											title="Format: yyyy-mm-dd (e.g. 2026-02-17)"
											>
										<span class="input-group-addon">
											<i class="glyphicon glyphicon-calendar"></i>   <!-- or font-awesome etc. -->
										</span>
									</div>
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

			<!-- REPLACING  TAB-->
			<div class="tab-pane box" id="replacing" style="padding: 15px">
			<div class="box-content">
					<?php echo form_open(base_url() . 'index.php?burial/beneficiaries/'.$member_row['id'].'/beneficiary_replacement',
			        array('class' => 'form-horizontal form-bordered validate','enctype'=>'multipart/form-data'));?>

							<!-- Replacement Reason -->
							<div class="form-group">
								<label class="col-sm-3 control-label">Reason for Replacing</label>
								<div class="col-sm-7">
									<select name="replacement_reason" id="replacement-reason" class="form-control" required>
										<option value="">-- Select Reason --</option>
										<option value="10 years benefitted">10 years benefitted</option>
										<option value="Not Matured">Not Matured</option>
										<option value="Passbook Replacement">Passbook Replacement</option>
									</select>
								</div>
							</div>

							<!-- Replace With Dropdown -->
							<div class="form-group" id="replacing-replace-with-group" style="display: none;">
								<label class="col-sm-3 control-label">Replace</label>
								<div class="col-sm-7">
									<select name="replaced_with" id="replacing-replaced-with-select" class="form-control" required disabled>
										<option value="">-- Select Beneficiary to Replace --</option>
										<?php
										$this->db->where('memberid', $member_row['id']);
										$this->db->where('status !=', 'DELETED');
										$this->db->where('status !=', 'BENEFITTED - REPLACED');
										$this->db->where('status !=', 'LATE NOT BENEFITTED - REPLACED');
										$this->db->group_start();
										$this->db->where('replaced', 0);
										$this->db->or_where('replaced IS NULL', null, false);
										$this->db->or_where('status', 'REPLACEE');
										$this->db->group_end();
										$existing_beneficiaries = $this->db->get('beneficiaries')->result_array();

										if (!empty($existing_beneficiaries)):
											foreach ($existing_beneficiaries as $eb):
												$status = $eb['status'] ?? '';
												$status_date = isset($eb['status_date']) ? $eb['status_date'] : '';
												$submission_date = $eb['submission_date'] ?? '';
												$is_benefitted = ($status === 'BENEFITTED');
												$submission_timestamp = false;
												if (!empty($submission_date) && strpos($submission_date, '-') !== false) {
													$date_parts = explode('-', $submission_date);
													if (count($date_parts) == 3 && intval($date_parts[0]) > 12) {
														$submission_timestamp = strtotime($submission_date);
													} else {
														$submission_timestamp = strtotime($date_parts[2] . '-' . $date_parts[1] . '-' . $date_parts[0]);
													}
												} elseif (!empty($submission_date)) {
													$submission_timestamp = strtotime($submission_date);
												}
												$is_not_matured = ($submission_timestamp && time() < strtotime('+1 year', $submission_timestamp));
												$ten_years_eligible = false;
												if ($is_benefitted && !empty($status_date)) {
													$benefitted_ts = strtotime($status_date);
													if ($benefitted_ts && time() >= strtotime('+10 years', $benefitted_ts)) {
														$ten_years_eligible = true;
													}
												}
												$displayDate = ($status === 'ACTIVE') ? $eb['submission_date'] : $status_date;
										?>
											<option
												value="<?php echo $eb['id']; ?>"
												data-status="<?php echo htmlspecialchars($status, ENT_QUOTES, 'UTF-8'); ?>"
												data-status-date="<?php echo htmlspecialchars($status_date, ENT_QUOTES, 'UTF-8'); ?>"
												data-ten-years="<?php echo $ten_years_eligible ? '1' : '0'; ?>"
												data-not-matured="<?php echo $is_not_matured ? '1' : '0'; ?>"
												data-passbook-eligible="1"
												hidden>
												<?php echo $eb['fullname'] . ' (' . $status . ' | ' . $displayDate . ')'; ?>
											</option>
										<?php
											endforeach;
										endif;
										?>
									</select>
									<small class="form-text text-muted" id="replacing-beneficiary-hint"></small>
								</div>
							</div>


							<div id="passbook-replacement-group" style="display: none;">
								<div class="form-group">
									<label class="col-sm-3 control-label">Member 1</label>
									<div class="col-sm-7">
										<div style="position: relative;">
											<input type="text" class="form-control" id="replacement-member-search-1"
												placeholder="Search by ID Number, Name, Passbook No, or Employee No">
											<small class="form-text text-muted">Select first member reference</small>
											<div id="replacement-member-search-results-1" style="position: absolute; top: 100%; left: 0; right: 0; background: white; border: 1px solid #ddd; border-top: none; border-radius: 0 0 4px 4px; max-height: 250px; overflow-y: auto; z-index: 1000; display: none; box-shadow: 0 4px 6px rgba(0,0,0,0.1);"></div>
										</div>
										<input type="hidden" name="memberid1" id="replacement-memberid1">
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-3 control-label">Member 2</label>
									<div class="col-sm-7">
										<div style="position: relative;">
											<input type="text" class="form-control" id="replacement-member-search-2"
												placeholder="Search by ID Number, Name, Passbook No, or Employee No">
											<small class="form-text text-muted">Select second member reference</small>
											<div id="replacement-member-search-results-2" style="position: absolute; top: 100%; left: 0; right: 0; background: white; border: 1px solid #ddd; border-top: none; border-radius: 0 0 4px 4px; max-height: 250px; overflow-y: auto; z-index: 1000; display: none; box-shadow: 0 4px 6px rgba(0,0,0,0.1);"></div>
										</div>
										<input type="hidden" name="memberid2" id="replacement-memberid2">
									</div>
								</div>
							</div>

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
										<option value="M">Male</option>
										<option value="F">Female</option>
									</select>
								</div>
							</div>

							<!-- Date of Birth -->
							<div class="form-group">
								<label class="col-sm-3 control-label">Date of Birth(optionak)</label>
								<div class="col-sm-7">
									<div class="input-group date" data-provide="datepicker"data-date-format="yyyy-mm-dd">
										<input type="text"
											class="form-control"
											name="dob"
											pattern="\d{4}-(?:0?[1-9]|1[0-2])-(?:0?[1-9]|[12]\d|3[01])"
											placeholder="yyyy-mm-dd"
											title="Format: yyyy-mm-dd (e.g. 2026-02-17)"
											>
										<span class="input-group-addon">
											<i class="glyphicon glyphicon-calendar"></i>   <!-- or font-awesome etc. -->
										</span>
									</div>
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
							<!-- Death Certificate Date (for Not Matured) -->
							<div class="form-group" id="replacement-death-cert-group" style="display: none;">
								<label class="col-sm-3 control-label">Death Certificate Date</label>
								<div class="col-sm-7">
									<div class="input-group date" data-provide="datepicker"data-date-format="yyyy-mm-dd">
										<input type="text"
											class="form-control"
											name="death_certificate_date"
											id="replacement-death-certificate-date"
											pattern="\d{4}-(?:0?[1-9]|1[0-2])-(?:0?[1-9]|[12]\d|3[01])"
											placeholder="yyyy-mm-dd"
											title="Format: yyyy-mm-dd (e.g. 2026-02-17)">
										<span class="input-group-addon">
											<i class="glyphicon glyphicon-calendar"></i>
										</span>
									</div>
									<small class="form-text text-muted">Replacement must be done within 2 months from date of death</small>
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
			<!--BATCH CREATION FORM ENDS-->

		</div>
	</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script>
// Status field toggle logic for single Add Beneficiary form
(function() {
    var statusSelect = document.getElementById('beneficiary-status');
    var statusDateGroup = document.getElementById('status-date-group');
    var statusDateLabel = document.getElementById('status-date-label');
    var statusDateInput = statusDateGroup ? statusDateGroup.querySelector('input[name="status_date"]') : null;
    var submissionDateInput = document.querySelector('input[name="submission_date"]');
    var replaceWithGroup = document.getElementById('replace-with-group');
    var replacedWithSelect = document.getElementById('replaced-with-select');

    if (!statusSelect) return;

    function syncStatusDateFromReplacedBeneficiary() {
        if (!replacedWithSelect || !statusDateInput) return;

        // Only auto-fill when adding a REPLACEE
        if (statusSelect.value !== 'REPLACEE') return;

        var selectedOption = replacedWithSelect.options[replacedWithSelect.selectedIndex];
        if (!selectedOption) return;

        var selectedStatus = (selectedOption.getAttribute('data-status') || '').trim().toUpperCase();
        var benefittedStatusDate = selectedOption.getAttribute('data-status-date') || '';

        // Auto-fill ONLY when the selected beneficiary being replaced is BENEFITTED
        // For ACTIVE or REPLACEE (or anything else), leave it for the user to type (death certificate date)
        if (selectedStatus === 'BENEFITTED' && benefittedStatusDate) {
            statusDateInput.value = benefittedStatusDate;
        } else {
            // Do not overwrite whatever the user may have typed; only clear if currently empty
            if (!statusDateInput.value) {
                statusDateInput.value = '';
            }
        }
    }

    function syncStatusDateFromSubmissionForActive() {
        if (!statusDateInput || !submissionDateInput) return;
        if (statusSelect.value !== 'ACTIVE') return;
        statusDateInput.value = submissionDateInput.value || '';
    }

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
                if (statusDateLabel) statusDateLabel.textContent = 'Death Certificate Date / Benefitted Date';
                statusDateInput.required = true;

                // If a benefitted beneficiary is already selected to be replaced, copy its status_date
                syncStatusDateFromReplacedBeneficiary();
            } else if (status === 'ACTIVE') {
                // Do not show the field, but keep status_date synced from submission_date
                statusDateGroup.style.display = 'none';
                statusDateInput.required = false;
                syncStatusDateFromSubmissionForActive();
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
                    // When status becomes REPLACEE, immediately try to sync status date
                    syncStatusDateFromReplacedBeneficiary();
                }
            } else {
                replaceWithGroup.style.display = 'none';
                if (replacedWithSelect) {
                    replacedWithSelect.required = false;
                    replacedWithSelect.value = '';
                }
            }
        }
    }

    statusSelect.addEventListener('change', toggleStatusFields);

    // Keep status_date synced to submission_date when status is ACTIVE
    if (submissionDateInput) {
        submissionDateInput.addEventListener('change', function () {
            syncStatusDateFromSubmissionForActive();
        });
    }

    // When the "Replace" dropdown changes, update the status date if applicable
    if (replacedWithSelect) {
        replacedWithSelect.addEventListener('change', function () {
            syncStatusDateFromReplacedBeneficiary();
        });
    }
    toggleStatusFields(); // Initialize on load
})();

// Replacement tab: reason-driven fields + searchable member references
(function() {
    var reasonSelect = document.getElementById('replacement-reason');
    var replaceWithGroup = document.getElementById('replacing-replace-with-group');
    var replacedWithSelect = document.getElementById('replacing-replaced-with-select');
    var beneficiaryHint = document.getElementById('replacing-beneficiary-hint');
    var deathCertGroup = document.getElementById('replacement-death-cert-group');
    var deathCertInput = document.getElementById('replacement-death-certificate-date');
    var passbookGroup = document.getElementById('passbook-replacement-group');
    var replacementForm = replaceWithGroup ? replaceWithGroup.closest('form') : null;

    function parseDateToTs(dateStr) {
        if (!dateStr) return null;
        var parts = dateStr.split('-');
        if (parts.length !== 3) return null;
        var d = new Date(parseInt(parts[0], 10), parseInt(parts[1], 10) - 1, parseInt(parts[2], 10));
        return isNaN(d.getTime()) ? null : d.getTime();
    }

    function isWithinTwoMonthsOfDeath(deathDateStr) {
        var deathTs = parseDateToTs(deathDateStr);
        if (!deathTs) return false;
        var twoMonthsAfter = new Date(deathTs);
        twoMonthsAfter.setMonth(twoMonthsAfter.getMonth() + 2);
        return Date.now() <= twoMonthsAfter.getTime();
    }

    function filterBeneficiaryOptions() {
        if (!reasonSelect || !replacedWithSelect) return;

        var reason = reasonSelect.value;
        var visibleCount = 0;
        var selectedStillVisible = false;

        Array.prototype.forEach.call(replacedWithSelect.options, function(option) {
            if (!option.value) return;

            var show = false;
            if (reason === '10 years benefitted') {
                show = option.getAttribute('data-ten-years') === '1';
            } else if (reason === 'Not Matured') {
                show = option.getAttribute('data-not-matured') === '1';
            } else if (reason === 'Passbook Replacement') {
                show = option.getAttribute('data-passbook-eligible') === '1';
            }

            option.hidden = !show;
            option.disabled = !show;
            if (show) {
                visibleCount++;
                if (replacedWithSelect.value === option.value) {
                    selectedStillVisible = true;
                }
            }
        });

        if (!selectedStillVisible) {
            replacedWithSelect.value = '';
        }

        if (beneficiaryHint) {
            if (!reason) {
                beneficiaryHint.textContent = '';
            } else if (reason === '10 years benefitted') {
                beneficiaryHint.textContent = 'Showing BENEFITTED beneficiaries whose benefitted date is at least 10 years ago.';
            } else if (reason === 'Not Matured') {
                beneficiaryHint.textContent = 'Showing beneficiaries whose submission date is less than 12 months old (not yet matured).';
            } else if (reason === 'Passbook Replacement') {
                beneficiaryHint.textContent = 'Select the beneficiary being replaced.';
            }

            if (reason && visibleCount === 0) {
                beneficiaryHint.textContent += ' No eligible beneficiaries found for this reason.';
            }
        }
    }

    function bindMemberSearch(inputId, resultsId, hiddenId) {
        var input = jQuery('#' + inputId);
        var results = jQuery('#' + resultsId);
        var hidden = jQuery('#' + hiddenId);

        input.on('keyup', function() {
            var search = jQuery(this).val();
            if (!search || search.length < 2) {
                results.hide().empty();
                hidden.val('');
                return;
            }

            jQuery.ajax({
                url: "<?php echo base_url('index.php?burial/search_members');?>",
                method: 'POST',
                data: {search: search},
                dataType: 'json',
                success: function(response) {
                    if (!(response && response.success && response.members && response.members.length > 0)) {
                        results.html('<div style="padding: 10px; text-align: center; color: #999;">No members found</div>').show();
                        hidden.val('');
                        return;
                    }

                    var resultsHtml = '';
                    jQuery.each(response.members, function(index, member) {
                        var fullName = (member.surname || '') + ' ' + (member.name || '');
                        var idNo = member.idnumber || 'N/A';
                        var passbook = member.passbook_no || 'N/A';
                        var employee = member.employeeno || 'N/A';
                        resultsHtml += '<div class="replacement-member-result" style="padding: 10px 15px; border-bottom: 1px solid #f0f0f0; cursor: pointer;" ' +
                            'data-member-id="' + member.id + '" ' +
                            'data-display="' + fullName.trim() + ' | ID: ' + idNo + ' | PB: ' + passbook + '">' +
                            '<strong style="display: block; margin-bottom: 3px;">' + fullName + '</strong>' +
                            '<small style="color: #666;">ID: ' + idNo + ' | Passbook: ' + passbook + ' | Employee: ' + employee + '</small>' +
                            '</div>';
                    });
                    results.html(resultsHtml).show();
                },
                error: function() {
                    results.html('<div style="padding: 10px; text-align: center; color: #d32f2f;">Error loading members</div>').show();
                }
            });
        });

        results.on('click', '.replacement-member-result', function() {
            var memberId = jQuery(this).data('member-id');
            var display = jQuery(this).data('display');
            hidden.val(memberId);
            input.val(display);
            results.hide();
        });
    }

    function toggleReplacementReasonFields() {
        if (!reasonSelect) return;
        var reason = reasonSelect.value;
        var isNotMatured = reason === 'Not Matured';
        var isPassbookReplacement = reason === 'Passbook Replacement';

        if (replaceWithGroup && replacedWithSelect) {
            replaceWithGroup.style.display = reason ? 'block' : 'none';
            replacedWithSelect.disabled = !reason;
            replacedWithSelect.required = !!reason;
            filterBeneficiaryOptions();
        }

        if (deathCertGroup && deathCertInput) {
            deathCertGroup.style.display = isNotMatured ? 'block' : 'none';
            deathCertInput.required = isNotMatured;
            if (!isNotMatured) {
                deathCertInput.value = '';
            }
        }

        if (passbookGroup) {
            passbookGroup.style.display = isPassbookReplacement ? 'block' : 'none';
            if (!isPassbookReplacement) {
                jQuery('#replacement-member-search-1, #replacement-member-search-2').val('');
                jQuery('#replacement-memberid1, #replacement-memberid2').val('');
                jQuery('#replacement-member-search-results-1, #replacement-member-search-results-2').hide().empty();
            }
        }
    }

    if (!reasonSelect) return;

    bindMemberSearch('replacement-member-search-1', 'replacement-member-search-results-1', 'replacement-memberid1');
    bindMemberSearch('replacement-member-search-2', 'replacement-member-search-results-2', 'replacement-memberid2');
    reasonSelect.addEventListener('change', toggleReplacementReasonFields);
    toggleReplacementReasonFields();

    if (replacementForm) {
        replacementForm.addEventListener('submit', function(e) {
            var reason = reasonSelect.value;

            if (reason === 'Not Matured' && deathCertInput) {
                if (!deathCertInput.value) {
                    e.preventDefault();
                    alert('Death Certificate Date is required for Not Matured replacement.');
                    return;
                }
                if (!isWithinTwoMonthsOfDeath(deathCertInput.value)) {
                    e.preventDefault();
                    alert('Replacement must be done within 2 months from date of death.');
                    return;
                }
            }

            if (reason === 'Passbook Replacement') {
                if (!jQuery('#replacement-memberid1').val() || !jQuery('#replacement-memberid2').val()) {
                    e.preventDefault();
                    alert('Please select both member references for Passbook Replacement.');
                }
            }
        });
    }
})();

// ────────────────────────────────────────────────
//   Batch Add Beneficiaries - Dynamic Rows + Datepickers
// ────────────────────────────────────────────────
(function() {
    let rowCount = 0;
    const batchSubmissionDateInput = document.getElementById('batch-submission-date');

    // Helper: Initialize / reinitialize Bootstrap datepickers
    function initDatepickers(container = document) {
        // First destroy any existing instances to prevent duplicates/memory issues
        jQuery(container).find('.datepicker').each(function() {
            if (jQuery(this).data('datepicker')) {
                jQuery(this).datepicker('destroy');
            }
        });

        // Then initialize
        jQuery(container).find('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            // You can add more options if needed:
            // orientation: "bottom auto",
            // startView: "years",
            // endDate: new Date()
        });
    }

    function createBeneficiaryRow(index) {
        return `
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
                        <option value="M">Male</option>
                        <option value="F">Female</option>
                    </select>
                </td>
                <td>
                    <input type="text" name="batch_dob[]" class="form-control datepicker" placeholder="yyyy-mm-dd" style="width: 100%; margin: 0;">
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
                        <option value="LATE NOT BENEFITTED">LATE NOT BENEFITTED</option>
                        <option value="LATE NOT BENEFITTED - REPLACED">LATE NOT BENEFITTED - REPLACED</option>
                    </select>
                </td>
                <td>
                    <input type="text" name="batch_status_date[]" class="form-control batch-status-date datepicker" data-index="${index}" placeholder="yyyy-mm-dd" style="width: 100%; margin: 0; display: none;">
                </td>
                <td style="text-align: center; vertical-align: middle;">
                    ${index > 0 ? `<button type="button" class="btn btn-danger btn-xs remove-row" data-index="${index}" title="Remove row"><i class="fa fa-trash"></i></button>` : `<span style="color: #999;">---</span>`}
                </td>
            </tr>
        `;
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
            syncBatchSubmissionDateRequired();
        });
    }

    function syncBatchSubmissionDateRequired() {
        if (!batchSubmissionDateInput) return;

        const hasBenefitted = Array.from(document.querySelectorAll('.batch-status-select')).some(function(select) {
            return select.value === 'BENEFITTED';
        });

        batchSubmissionDateInput.required = hasBenefitted;
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
                    syncBatchSubmissionDateRequired();
                }
            });
        }
    }

    // ─── Initialize ────────────────────────────────────────────────

    const container = document.getElementById('beneficiaries-container');
    if (container) {
        // Add initial 5 rows
        for (let i = 0; i < 5; i++) {
            container.insertAdjacentHTML('beforeend', createBeneficiaryRow(i));
            initializeRow(i);
            rowCount++;
        }

        // Initialize datepickers for the initial rows
        initDatepickers(container);

        // Attach remove listeners to any initial removable rows (though first row usually isn't)
        document.querySelectorAll('.remove-row').forEach(btn => {
            const idx = btn.getAttribute('data-index');
            attachRemoveListener(idx);
        });

        syncBatchSubmissionDateRequired();
    }

    // Add More Row Button
    const addBtn = document.getElementById('add-beneficiary-row');
    if (addBtn) {
        addBtn.addEventListener('click', function(e) {
            e.preventDefault();

            const newRowHTML = createBeneficiaryRow(rowCount);
            container.insertAdjacentHTML('beforeend', newRowHTML);

            initializeRow(rowCount);

            // Initialize datepicker ONLY on the newly added row
            const newRowElement = document.getElementById(`batch-row-${rowCount}`);
            initDatepickers(newRowElement);

            rowCount++;
            updateRowNumbers();

            attachRemoveListener(rowCount - 1);
            syncBatchSubmissionDateRequired();
        });
    }

})();
</script>

<?php
endforeach;
?>
