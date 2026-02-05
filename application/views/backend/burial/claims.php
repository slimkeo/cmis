<div class="row">
	<div class="col-md-12">

		<!---CONTROL TABS START-->
		<div class="tabs">
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#list" data-toggle="tab"><i class="fa fa-list"></i> 
					<?php echo get_phrase('all_claims');?>
						</a></li>
			<li>
				<a href="#add" data-toggle="tab"><i class="fa fa-plus-circle"></i>
					<?php echo get_phrase('new_claim'); ?>
						</a></li>
			<li>
				<a href="#documents" data-toggle="tab"><i class="fa fa-file-o"></i> 
					<?php echo get_phrase('claim_documents');?>
						</a></li>
		</ul>
		<!---CONTROL TABS END-->

		<div class="tab-content">
		<br>
			<!--TABLE LISTING STARTS-->
			<div class="tab-pane box active" id="list">
				<table class="table table-bordered table-striped mb-none" id="datatable-tabletools" >
			<thead>
				<tr>
                                        <th>
						<div>
							<?php echo get_phrase('#');?>
						</div>
					</th>
					<th>
						<div>
							<?php echo get_phrase('member');?>
						</div>
					</th>
					<th>
						<div>
							<?php echo get_phrase('beneficiary');?>
						</div>
					</th>
					<th>
						<div>
							Claim Type
						</div>
					</th>
					<th>
						<div>
							<?php echo get_phrase('amount');?>
						</div>
					</th>
					<th>
						<div>
							<?php echo get_phrase('claim_date');?>
						</div>
					</th>
					<th>
						<div>
							<?php echo get_phrase('status');?>
						</div>
					</th>

					<th>
						<div>
							<?php echo get_phrase('options');?>
						</div>
					</th>
				</tr>
			</thead>
			<tbody>
			
				<?php
				
				$i=1;
				if(!empty($claims)):
				foreach ( $claims as $row ): 
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
                    <td>
						<?php echo $i++;?>
					</td>
					<td>
						<?php echo htmlspecialchars($member_name);?>
					</td>
					<td>
						<?php echo htmlspecialchars($claimant_name);?>
					</td>
					<td>
						<span class="label label-<?php 
							if($row['claim_type'] == 'BENEFICIARY') echo 'primary';
							else echo 'success';
						?>">
							<?php echo $row['claim_type'];?>
						</span>
					</td>
					<td>
						<?php echo number_format($row['amount'], 2);?>
					</td>
					<td>
						<?php echo date('d-m-Y', strtotime($row['claim_date']));?>
					</td>
					<td>
						<span class="label label-<?php 
							if($row['status'] == 'PENDING') echo 'warning';
							elseif($row['status'] == 'APPROVED') echo 'success';
							elseif($row['status'] == 'REJECTED') echo 'danger';
							elseif($row['status'] == 'PAID') echo 'info';
						?>">
							<?php echo $row['status'];?>
						</span>
					</td>
					<td>

						<!-- VIEW CLAIM DETAILS LINK -->
						<a href="<?php echo base_url(); ?>index.php?burial/claims/view/<?php echo $row['isd'];?>" class="btn btn-xs btn-info" data-placement="top" data-toggle="tooltip" 
						data-original-title="<?php echo get_phrase('view_claim');?>" target="_blank">
                        <i class="fa fa-eye"></i>
                        </a>

						<!-- VIEW CLAIM DETAILS LINK -->
						<a href="<?php echo base_url(); ?>index.php?burial/print_claims_details/<?php echo $row['id'];?>" class="btn btn-xs btn-info" data-placement="top" data-toggle="tooltip" 
						data-original-title="Print Claim" target="_blank">
                        <i class="fa fa-print"></i>
                        </a>
						<!-- CLAIM EDITING LINK -->

						<a href="#" class="btn btn-xs btn-success" data-placement="top" data-toggle="tooltip" 
						data-original-title="<?php echo get_phrase('edit');?>" onClick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_claim_edit/<?php echo $row['id'];?>');">
                        <i class="fa fa-pencil"></i>
                        </a>
						

						<!-- CLAIM DELETION LINK -->
						<a href="#" class="btn btn-xs btn-danger" data-placement="top" data-toggle="tooltip"
						 data-original-title="<?php echo get_phrase('delete');?>" onClick="confirm_modal('<?php echo base_url();?>index.php?burial/claims/delete/<?php echo $row['id'];?>');">
                        <i class="fa fa-trash"></i>
                        </a>			

					</td>
				</tr>
				<?php endforeach;
				else: ?>
				<tr>
					<td colspan="8" class="text-center">
						<?php echo get_phrase('no_claims_found'); ?>
					</td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>
			</div>
			<!--CREATION FORM STARTS-->
			<div class="tab-pane box" id="add" style="padding: 5px">
				<div class="box-content">
					<?php echo form_open(base_url() . 'index.php?burial/claims/create' , array('class' => 'form-horizontal form-bordered validate','enctype'=>'multipart/form-data'));?>
					

					<!-- SEARCH MEMBER -->
					<div class="form-group">
						<label class="col-md-3 control-label">Search Member <span class="required">*</span></label>
						<div class="col-md-7">
							<div style="position: relative;">
								<input type="text" class="form-control" id="member_search" placeholder="Search by ID, Name, Passbook, Employee No" required>
								<small class="form-text text-muted">Start typing to search for member</small>
								<div id="member_search_results" style="position: absolute; top: 100%; left: 0; right: 0; background: white; border: 1px solid #ddd; border-top: none; border-radius: 0 0 4px 4px; max-height: 300px; overflow-y: auto; z-index: 1000; display: none; box-shadow: 0 4px 6px rgba(0,0,0,0.1);"></div>
							</div>
						</div>
					</div>

					<!-- SELECTED MEMBER INFO -->
					<div class="form-group">
						<label class="col-md-3 control-label">Selected Member</label>
						<div class="col-md-7">
							<div class="alert alert-info" id="member_info" style="display: none;">
								<strong>ID Number:</strong> <span id="member_idnumber"></span> <br>
								<strong>Name:</strong> <span id="member_name"></span> <br>
								<strong>Passbook No:</strong> <span id="member_passbook"></span> <br>
								<strong>Cell Number:</strong> <span id="member_cell"></span>
							</div>
							<input type="hidden" id="selected_member_id" name="member_id" value="">
						</div>
					</div>

					<!-- CLAIM TYPE SELECTION -->
					<div class="form-group">
						<label class="col-md-3 control-label">Claim Type <span class="required">*</span></label>
						<div class="col-md-7">
							<div class="radio">
								<label>
									<input type="radio" name="claim_type" id="claim_type_beneficiary" value="BENEFICIARY" checked required> 
									Beneficiary Claim
								</label>
							</div>
							<div class="radio">
								<label>
									<input type="radio" name="claim_type" id="claim_type_member" value="MEMBER" required> 
									Member/Policy Holder Claim (Nominee)
								</label>
							</div>
						</div>
					</div>

					<!-- NOMINEE SELECTION (hidden by default) -->
					<div class="form-group" id="nominee_group" style="display: none;">
						<label class="col-md-3 control-label">Nominee <span class="required">*</span></label>
						<div class="col-md-7">
							<select class="form-control" id="nominee_select" name="nominee_id">
								<option value="">-- Select Nominee --</option>
							</select>
							<small class="form-text text-muted">Select a nominee for this member claim</small>
						</div>
					</div>

					<!-- BENEFICIARY SEARCHABLE DROPDOWN -->
					<div class="form-group">
						<label class="col-md-3 control-label">Beneficiary <span class="required">*</span></label>
						<div class="col-md-7">
							<select class="form-control" id="beneficiary_select" name="beneficiary_id" required disabled>
								<option value="">-- Select Beneficiary --</option>
							</select>
							<small class="form-text text-muted">Only matured, payable beneficiaries are shown</small>
						</div>
					</div>
				<div class="form-group">
					<label class="col-md-3 control-label">
						National ID <span class="required">*</span>
					</label>

					<div class="col-md-7">
						<input type="text" class="form-control" name="national_id" required title="<?php echo get_phrase('value_required');?>" value="" step="0.01" min="0">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label">Mortuary <span class="required">*</span>
					</label>

					<div class="col-md-7">
						<input type="text" class="form-control" name="mortuary" required title="<?php echo get_phrase('value_required');?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label">Date of Entry <span class="required">*</span>
					</label>

					<div class="col-md-7">
						<input type="text" class="form-control" name="date_of_entry" required title="<?php echo get_phrase('value_required');?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label">
						<?php echo get_phrase('place_of_burial');?> <span class="required">*</span>
					</label>

					<div class="col-md-7">
						<input type="text" class="form-control" name="place_of_burial" required title="<?php echo get_phrase('value_required');?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label">
						<?php echo get_phrase('date_of_burial');?> <span class="required">*</span>
					</label>

					<div class="col-md-7">
													<div class="input-daterange input-group" data-plugin-datepicker>
														<span class="input-group-addon">
															<i class="fa fa-calendar"></i>
														</span>
														<input type="text" class="form-control" name="date_of_burial">
													</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label">
						<?php echo get_phrase('bank');?> <span class="required">*</span>
					</label>

					<div class="col-md-7">
					<select name="bank" id="bank_select" class="form-control" required>
								<option value="">-- Select Bank --</option>
								<?php foreach ($enum_banks as $value): ?>
									<option value="<?= $value ?>">
										<?= ucfirst($value) ?>
									</option>
								<?php endforeach; ?>
							</select>
					</div>
				</div>	
				<div class="form-group">
					<label class="col-md-3 control-label">
						<?php echo get_phrase('account_number');?> <span class="required">*</span>
					</label>

					<div class="col-md-7">
						<input type="number" class="form-control" name="account" required title="<?php echo get_phrase('value_required');?>" value="" step="0.01" min="0">
					</div>
				</div>	
				<div class="form-group">
					<label class="col-md-3 control-label">
						<?php echo get_phrase('amount');?> <span class="required">*</span>
					</label>

					<div class="col-md-7">
						<input type="number" class="form-control" name="amount" required title="<?php echo get_phrase('value_required');?>" value="" step="0.01" min="0">
					</div>
				</div>	
				
				<div class="form-group">
					<label class="col-md-3 control-label">
						<?php echo get_phrase('claim_date');?>
					</label>

					<div class="col-md-7">
													<div class="input-daterange input-group" data-plugin-datepicker>
														<span class="input-group-addon">
															<i class="fa fa-calendar"></i>
														</span>
														<input type="text" class="form-control" name="claim_date" value="<?php echo date('Y-m-d') ?>">
													</div>
					</div>
				</div>

				<!-- DYNAMIC DOCUMENT UPLOADS (inline with claim creation) -->
				<div class="form-group">
					<label class="col-md-3 control-label">Claim Documents</label>
					<div class="col-md-7">
						<div id="documents_container">
							<div class="document-upload-row">
								<select class="form-control" name="document_description[]" required>
									<option value="">-- Select Document Type --</option>
									<option value="ID OF Policy Holder">ID OF Policy Holder</option>
									<option value="ID OF Deceased">ID OF Deceased</option>
									<option value="Passport">Passport</option>
									<option value="Death Certificate">Death Certificate</option>
									<option value="Payslip">Payslip</option>
									<option value="Passbook">Passbook</option>
								</select>
								<input type="file" class="form-control" name="document_file[]" required style="margin-top:5px;">
								<button type="button" class="btn btn-danger btn-xs remove-document" style="margin-top:5px; display:none;"><i class="fa fa-trash"></i></button>
							</div>
						</div>
						<button type="button" class="btn btn-info btn-xs" id="add_document_btn" style="margin-top:10px;"><i class="fa fa-plus"></i> Add Document</button>
						<small class="form-text text-muted">You can add multiple documents</small>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-3 control-label">
						<?php echo get_phrase('notes');?>
					</label>

					<div class="col-md-7">
				<textarea class="form-control" name="notes" rows="4"></textarea>
					</div>
				</div>
				
				<div class="form-group">
					  <div class="col-sm-offset-3 col-sm-5">
						  <button type="submit" class="btn btn-primary"><?php echo get_phrase('add_claim');?></button>
					  </div>
				</div>
				</form>                
				</div>                
			</div>
			<!--CREATION FORM ENDS-->

			<!--DOCUMENTS TAB STARTS-->
			<div class="tab-pane box" id="documents">
				<table class="table table-bordered table-striped mb-none" id="datatable-documents">
					<thead>
						<tr>
							<th>
								<div>
									<?php echo get_phrase('#');?>
								</div>
							</th>
							<th>
								<div>
									<?php echo get_phrase('claim_id');?>
								</div>
							</th>
							<th>
								<div>
									<?php echo get_phrase('description');?>
								</div>
							</th>
							<th>
								<div>
									<?php echo get_phrase('document_path');?>
								</div>
							</th>
							<th>
								<div>
									<?php echo get_phrase('uploaded_date');?>
								</div>
							</th>
							<th>
								<div>
									<?php echo get_phrase('options');?>
								</div>
							</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i = 1;
						if(isset($claims_documents) && !empty($claims_documents)):
							foreach($claims_documents as $doc): ?>
							<tr>
								<td><?php echo $i++; ?></td>
								<td><?php echo $doc['claim_id']; ?></td>
								<td>
									<span class="label label-primary">
										<?php echo $doc['description']; ?>
									</span>
								</td>
								<td>
									<a href="<?php echo base_url(); ?><?php echo $doc['path']; ?>" target="_blank" class="btn btn-xs btn-info">
										<i class="fa fa-download"></i> Download
									</a>
								</td>
								<td>
									<?php echo date('d-m-Y H:i', strtotime($doc['timestamp'])); ?>
								</td>
								<td>
									<a href="#" class="btn btn-xs btn-danger" data-placement="top" data-toggle="tooltip"
									 data-original-title="<?php echo get_phrase('delete');?>" onClick="confirm_modal('<?php echo base_url();?>index.php?burial/claims/delete_document/<?php echo $doc['id'];?>');">
										<i class="fa fa-trash"></i>
									</a>
								</td>
							</tr>
							<?php endforeach;
						else: ?>
							<tr>
								<td colspan="6" class="text-center">
									<?php echo get_phrase('no_documents_found'); ?>
								</td>
							</tr>
						<?php endif; ?>
					</tbody>
				</table>

				<!-- UPLOAD DOCUMENT FORM -->
				<div style="margin-top: 20px; padding: 15px; background-color: #f5f5f5; border-radius: 4px;">
					<h4><?php echo get_phrase('upload_claim_document'); ?></h4>
					<?php echo form_open(base_url() . 'index.php?burial/claims/upload_document', array('class' => 'form-horizontal form-bordered validate', 'enctype' => 'multipart/form-data')); ?>
					
					<div class="form-group">
						<label class="col-md-3 control-label">
							<?php echo get_phrase('claim_id'); ?> <span class="required">*</span>
						</label>
						<div class="col-md-7">
							<input type="number" class="form-control" name="claim_id" required title="<?php echo get_phrase('value_required'); ?>" value="">
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label">
							<?php echo get_phrase('document_type'); ?> <span class="required">*</span>
						</label>
						<div class="col-md-7">
							<select class="form-control" name="description" required>
								<option value="">-- Select Document Type --</option>
								<option value="ID OF Policy Holder">ID OF Policy Holder</option>
								<option value="ID OF Deceased">ID OF Deceased</option>
								<option value="Passport">Passport</option>
								<option value="Death Certificate">Death Certificate</option>
								<option value="Payslip">Payslip</option>
								<option value="Passbook">Passbook</option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label">
							<?php echo get_phrase('document_file'); ?> <span class="required">*</span>
						</label>
						<div class="col-md-7">
							<input type="file" class="form-control" name="document_file" required>
							<small class="form-text text-muted">Accepted formats: PDF, JPG, PNG, DOC, DOCX (Max 5MB)</small>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-primary"><?php echo get_phrase('upload_document'); ?></button>
						</div>
					</div>
					</form>
				</div>
			</div>
			<!--DOCUMENTS TAB ENDS-->

		</div>
	</div>
   </div>
</div>

		<script>
		$(document).ready(function() {
			// Member search (reuses endpoint from payments)
			$('#member_search').keyup(function() {
				var search = $(this).val();
				if (search.length < 2) {
					$('#member_search_results').hide();
					$('#member_info').hide();
					$('#beneficiary_select').prop('disabled', true).html('<option value="">-- Select Beneficiary --</option>');
					$('#selected_member_id').val('');
					return;
				}
				$.ajax({
					url: '<?php echo base_url('index.php?burial/search_members');?>',
					method: 'POST',
					data: {search: search},
					dataType: 'json',
					success: function(response) {
						if (response.success && response.members.length > 0) {
							var resultsHtml = '';
							$.each(response.members, function(index, member) {
								var displayName = member.surname + ' ' + member.name;
								var displayId = member.idnumber;
								var displayPassbook = member.passbook_no || 'N/A';
								var displayEmployee = member.employeeno || 'N/A';
								resultsHtml += '<div class="member-search-result" style="padding: 10px 15px; border-bottom: 1px solid #f0f0f0; cursor: pointer;" ' +
									'data-member-id="' + member.id + '" ' +
									'data-member-idnumber="' + member.idnumber + '" ' +
									'data-member-surname="' + member.surname + '" ' +
									'data-member-name="' + member.name + '" ' +
									'data-member-passbook="' + member.passbook_no + '" ' +
									'data-member-cell="' + member.cellnumber + '">' +
									'<strong>' + displayName + '</strong> <small style="color: #666;">ID: ' + displayId + ' | Passbook: ' + displayPassbook + ' | Employee: ' + displayEmployee + '</small>' +
									'</div>';
							});
							$('#member_search_results').html(resultsHtml).show();
							$('.member-search-result').click(function() {
								var member = {
									id: $(this).data('member-id'),
									idnumber: $(this).data('member-idnumber'),
									surname: $(this).data('member-surname'),
									name: $(this).data('member-name'),
									passbook_no: $(this).data('member-passbook'),
									cellnumber: $(this).data('member-cell')
								};
								$('#member_search').val(member.surname + ' ' + member.name);
								$('#member_idnumber').text(member.idnumber);
								$('#member_name').text(member.surname + ' ' + member.name);
								$('#member_passbook').text(member.passbook_no);
								$('#member_cell').text(member.cellnumber);
								$('#selected_member_id').val(member.id);
								$('#member_info').show();
								
								// Load nominees if member claim type is selected
								if ($('#claim_type_member').is(':checked')) {
									loadNominees(member.id);
								}
								
								// Fetch matured beneficiaries
								$.ajax({
									url: '<?php echo base_url('index.php?burial/get_matured_beneficiaries');?>',
									method: 'POST',
									data: {member_id: member.id},
									dataType: 'json',
									success: function(resp) {
										var options = '<option value="">-- Select Beneficiary --</option>';
										if (resp.success && resp.beneficiaries.length > 0) {
											$.each(resp.beneficiaries, function(i, ben) {
												options += '<option value="' + ben.id + '">' + ben.fullname + ' (' + ben.idnumber + ')</option>';
											});
											$('#beneficiary_select').prop('disabled', false).html(options);
										} else {
											$('#beneficiary_select').prop('disabled', true).html(options);
										}
									}
								});
								$('#member_search_results').hide();
							});
						} else {
							$('#member_search_results').html('<div style="padding: 10px; text-align: center; color: #999;">No members found</div>').show();
							$('#member_info').hide();
							$('#beneficiary_select').prop('disabled', true).html('<option value="">-- Select Beneficiary --</option>');
							$('#selected_member_id').val('');
						}
					}
				});
			});

			// Claim type change handler
			$('input[name="claim_type"]').on('change', function() {
				var claimType = $(this).val();
				var memberId = $('#selected_member_id').val();
				
				if (claimType === 'MEMBER' && memberId) {
					// Show nominee selection and hide beneficiary requirements
					$('#nominee_group').show();
					$('#beneficiary_select').closest('.form-group').hide();
					$('[name="beneficiary_id"]').closest('.form-group').hide();
					$('[name="place_of_burial"]').closest('.form-group').hide();
					$('[name="date_of_burial"]').closest('.form-group').hide();
					
					// Load nominees
					loadNominees(memberId);
				} else {
					// Show beneficiary selection and hide nominee selection
					$('#nominee_group').hide();
					$('#beneficiary_select').closest('.form-group').show();
					$('[name="beneficiary_id"]').closest('.form-group').show();
					$('[name="place_of_burial"]').closest('.form-group').show();
					$('[name="date_of_burial"]').closest('.form-group').show();
				}
			});

			// Function to load nominees for a member
			function loadNominees(memberId) {
				$.ajax({
					url: '<?php echo base_url('index.php?burial/get_nominees');?>',
					method: 'POST',
					data: {member_id: memberId},
					dataType: 'json',
					success: function(response) {
						var options = '<option value="">-- Select Nominee --</option>';
						if (response.success && response.nominees.length > 0) {
							$.each(response.nominees, function(i, nominee) {
								options += '<option value="' + nominee.id + '">' + nominee.fullname + '</option>';
							});
						}
						$('#nominee_select').html(options);
					},
					error: function() {
						$('#nominee_select').html('<option value="">-- Error loading nominees --</option>');
					}
				});
			}

			// Dynamic document upload fields
			$('#add_document_btn').click(function() {
				var row = $("<div class='document-upload-row'></div>");
				row.append('<select class="form-control" name="document_description[]" required>' +
					'<option value="">-- Select Document Type --</option>' +
					'<option value="ID OF Policy Holder">ID OF Policy Holder</option>' +
					'<option value="ID OF Deceased">ID OF Deceased</option>' +
					'<option value="Passport">Passport</option>' +
					'<option value="Death Certificate">Death Certificate</option>' +
					'<option value="Payslip">Payslip</option>' +
					'<option value="Passbook">Passbook</option>' +
					'</select>');
				row.append('<input type="file" class="form-control" name="document_file[]" required style="margin-top:5px;">');
				row.append('<button type="button" class="btn btn-danger btn-xs remove-document" style="margin-top:5px;"><i class="fa fa-trash"></i></button>');
				$('#documents_container').append(row);
				$('.remove-document').show();
			});
			$(document).on('click', '.remove-document', function() {
				$(this).closest('.document-upload-row').remove();
				if ($('#documents_container .document-upload-row').length === 1) {
					$('.remove-document').hide();
				}
			});
			if ($('#documents_container .document-upload-row').length === 1) {
				$('.remove-document').hide();
			}

			// Close search results when clicking outside
			$(document).click(function(e) {
				if (!$(e.target).closest('#member_search, #member_search_results').length) {
					$('#member_search_results').hide();
				}
			});
		});
		</script>
