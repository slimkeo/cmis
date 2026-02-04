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
							<?php echo get_phrase('member_id');?>
						</div>
					</th>
					<th>
						<div>
							<?php echo get_phrase('beneficiary_id');?>
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
							<?php echo get_phrase('approved_date');?>
						</div>
					</th>
					<th>
						<div>
							<?php echo get_phrase('status');?>
						</div>
					</th>
					<th>
						<div>
							<?php echo get_phrase('payment_date');?>
						</div>
					</th>
					<th>
						<div>
							<?php echo get_phrase('processed_by');?>
						</div>
					</th>
					<th>
						<div>
							<?php echo get_phrase('approved_by');?>
						</div>
					</th>
					<th>
						<div>
							<?php echo get_phrase('notes');?>
						</div>
					</th>
					<th>
						<div>
							<?php echo get_phrase('created_at');?>
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
				foreach ( $claims as $row ): ?>
				<tr>
                    <td>
						<?php echo $i++;?>
					</td>
					<td>
						<?php echo $row['member_id'];?>
					</td>
					<td>
						<?php echo $row['beneficiary_id'];?>
					</td>
					<td>
						<?php echo number_format($row['amount'], 2);?>
					</td>
					<td>
						<?php echo date('d-m-Y', strtotime($row['claim_date']));?>
					</td>
					<td>
						<?php echo !empty($row['approved_date']) ? date('d-m-Y', strtotime($row['approved_date'])) : '-';?>
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
						<?php echo !empty($row['payment_date']) ? date('d-m-Y', strtotime($row['payment_date'])) : '-';?>
					</td>
					<td>
						<?php echo !empty($row['processed_by']) ? $row['processed_by'] : '-';?>
					</td>
					<td>
						<?php echo !empty($row['approved_by']) ? $row['approved_by'] : '-';?>
					</td>
					<td>
						<?php echo !empty($row['notes']) ? substr($row['notes'], 0, 50) . (strlen($row['notes']) > 50 ? '...' : '') : '-';?>
					</td>
					<td>
						<?php echo date('d-m-Y H:i', strtotime($row['created_at']));?>
					</td>
					<td>

						<!-- VIEW CLAIM DETAILS LINK -->
						<a href="<?php echo base_url(); ?>index.php?burial/claims/view/<?php echo $row['id'];?>" class="btn btn-xs btn-info" data-placement="top" data-toggle="tooltip" 
						data-original-title="<?php echo get_phrase('view_claim');?>" target="_blank">
                        <i class="fa fa-eye"></i>
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
				<?php endforeach;?>
			</tbody>
		</table>
			</div>
			<!--CREATION FORM STARTS-->
			<div class="tab-pane box" id="add" style="padding: 5px">
				<div class="box-content">
					<?php echo form_open(base_url() . 'index.php?burial/claims/create' , array('class' => 'form-horizontal form-bordered validate','enctype'=>'multipart/form-data'));?>
					
					<div class="form-group">
					<label class="col-md-3 control-label">
						<?php echo get_phrase('member_id');?> <span class="required">*</span>
					</label>

					<div class="col-md-7">
				<input type="number" class="form-control" name="member_id" required title="<?php echo get_phrase('value_required');?>" value="" autofocus>
					</div>
				</div>

					<div class="form-group">
					<label class="col-md-3 control-label">
						<?php echo get_phrase('beneficiary_id');?> <span class="required">*</span>
					</label>

					<div class="col-md-7">
				<input type="number" class="form-control" name="beneficiary_id" required title="<?php echo get_phrase('value_required');?>" value="">
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
						<?php echo get_phrase('claim_date');?> <span class="required">*</span>
					</label>

					<div class="col-md-7">
						<div class="input-group" data-plugin-datepicker>
							<span class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</span>
							<input type="text" class="form-control" name="claim_date" required>
						</div>	
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-3 control-label">
						<?php echo get_phrase('approved_date');?>
					</label>

					<div class="col-md-7">
						<div class="input-group" data-plugin-datepicker>
							<span class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</span>
							<input type="text" class="form-control" name="approved_date">
						</div>	
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-3 control-label">
						<?php echo get_phrase('status');?> <span class="required">*</span>
					</label>

					<div class="col-md-7">
						<select class="form-control" name="status" required>
							<option value="">-- Select Status --</option>
							<option value="PENDING">PENDING</option>
							<option value="APPROVED">APPROVED</option>
							<option value="REJECTED">REJECTED</option>
							<option value="PAID">PAID</option>
						</select>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-3 control-label">
						<?php echo get_phrase('payment_date');?>
					</label>

					<div class="col-md-7">
						<div class="input-group" data-plugin-datepicker>
							<span class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</span>
							<input type="text" class="form-control" name="payment_date">
						</div>	
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-3 control-label">
						<?php echo get_phrase('processed_by');?>
					</label>

					<div class="col-md-7">
				<input type="text" class="form-control" name="processed_by" value="">
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-3 control-label">
						<?php echo get_phrase('approved_by');?>
					</label>

					<div class="col-md-7">
				<input type="text" class="form-control" name="approved_by" value="">
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
