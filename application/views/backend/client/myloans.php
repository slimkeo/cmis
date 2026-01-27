<div class="row">
	<div class="col-md-12">

		<!---CONTROL TABS START-->
		<div class="tabs">
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#list" data-toggle="tab"><i class="fa fa-list"></i> 
					<?php echo get_phrase('all_loans');?>
						</a></li>
			<li>
			<a href="#" class="fa fa-plus-circle" data-placement="top" data-toggle="tooltip" 
						data-original-title="<?php echo get_phrase('create_a_new_loan');?>" onClick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_new_loan/');">
                        <?php echo get_phrase('apply_for_loan');?>
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
							<?php echo get_phrase('loan_no');?>
						</div>
					</th>
                    <th>
						<div>
							<?php echo get_phrase('client');?>
						</div>
					</th>						
                    <th>
						<div>
							<?php echo get_phrase('amount');?>
						</div>
					</th>
					<th>
						<div>
							<?php echo get_phrase('plan');?>
						</div>
					</th>
<th>
						<div>
							<?php echo get_phrase('monthly_pay');?>
						</div>
					</th>
					<th>
						<div>
							<?php echo get_phrase('Effective_date');?>
						</div>
					</th>
	
						<th>
						<div>
							<?php echo get_phrase('total_balance');?>
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
				
				$status = "Pending";
				foreach ( $myloans as $row ): ?>
				<a href="">
				<tr>
                                       <td>
						<?php echo $row['id'];?>
					</td>
					<td>
						<?php echo $this->db->get_where('client' , array('id' =>$row['client_id']))->row()->fullname	." ".$this->db->get_where('client' , array('id' =>$row['client_id']))->row()->lastname;?>

					</td>
<td>
						<?php echo $row['amount'];?>
					</td>
					<td>
						<?php echo $row['plan'];?>
					</td>
					<td>
						<?php echo $row['monthly_pay'];?>
					</td>
					<td>
						<?php echo $row['effective_date'];?>
					</td>
					<td>
						<?php echo $row['total_balance'];?>
					</td>
					<td>
						<?php if($row['status']==1){ $status="Active";} else { $status="Paid"; }
						 echo $status;
						?>
					</td>
					<td>
						<?php if($row['status']==1){ ?>
						<!-- MARSHALOANL EDITING LINK -->

						<a href="<?php echo base_url(); ?>index.php?admin/loan_details/<?php echo $row['id']; ?>" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo get_phrase('view_loan');?>">
                        <i class="fa fa-eye"></i>
                        </a>

						<!-- TEACHER PASSWORD RESET LINK -->
						<a href="#" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo get_phrase('repay_loan');?>" onClick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_repay_loan/<?php echo $row['id'];?>');">
                        <i class="fa fa-dollar"></i>
                        </a>

						<!-- TEACHER DELETION LINK -->
						<a href="#" class="btn btn-xs btn-danger" data-placement="top" data-toggle="tooltip" data-original-title="<?php echo get_phrase('delete');?>" onClick="confirm_modal('<?php echo base_url();?>index.php?admin/loans/delete/<?php echo $row['id'];?>');">
                        <i class="fa fa-trash"></i>
                        </a>			
                        <?php } ?>
					</td>
				</tr>
				
				<?php endforeach;?>
			</tbody>
		</table>
			</div>
			<!--TABLE LISTING ENDS-->


			<!--CREATION FORM STARTS-->
			<div class="tab-pane box" id="add" style="padding: 5px">
			
				<div class="box-content">
					<?php echo form_open(base_url() . 'index.php?admin/loan/create' , array('class' => 'form-horizontal form-bordered validate'));?>

						<div class="form-group">
					<label class="col-md-3 control-label">
						<?php echo get_phrase('client_id');?> <span class="required">*</span>
					</label>

					<div class="col-md-7">
						<input type="text" class="form-control" name="nationalID" required title="<?php echo get_phrase('value_required');?>" value="" autofocus>
					</div>

				</div>
		
		<div class="form-group">
					<label class="col-md-3 control-label">
						<?php echo get_phrase('fullname');?>
					</label>

					<div class="col-md-7">
				<input type="text" class="form-control" name="emplo_no" required title="<?php echo get_phrase('value_required');?>" value="" autofocus>
					</div>
				</div>
				
				
				<div class="form-group">
					<label class="col-md-3 control-label">
						<?php echo get_phrase('position');?>
					</label>

					<div class="col-md-7">
				<input type="text" class="form-control" name="emplo_no" required title="<?php echo get_phrase('value_required');?>" value="" autofocus>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-3 control-label">
						<?php echo get_phrase('name');?> <span class="required">*</span>
					</label>

					<div class="col-md-7">
						<input type="text" class="form-control" name="name" required title="<?php echo get_phrase('value_required');?>" value="" autofocus>
					</div>
				</div>

				

				<div class="form-group">
					<label class="col-md-3 control-label">
						<?php echo get_phrase('gender');?>
					</label>

					<div class="col-md-7">
						<select name="sex" data-plugin-selectTwo data-minimum-results-for-search="Infinity" data-width="100%" class="form-control populate">
							<option value=""><?php echo get_phrase('select');?></option>
							<option value="male"><?php echo get_phrase('male');?></option>
							<option value="female"><?php echo get_phrase('female');?></option>
						</select>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-3 control-label">
						<?php echo get_phrase('address');?>
					</label>

					<div class="col-md-7">
						<input type="text" class="form-control" name="address" value="">
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-3 control-label">
						<?php echo get_phrase('phone');?>
					</label>

					<div class="col-md-7">
						<input type="text" class="form-control" name="phone" value="">
					</div>
				</div>

			


				<div class="form-group">
					<label class="col-md-3 control-label">
						<?php echo get_phrase('photo');?>
					</label>

					<div class="col-md-7">
						<div class="fileinput fileinput-new" data-provides="fileinput">
							<div class="fileinput-new thumbnail" style="width: 100px; height: 100px;" data-trigger="fileinput">
								<img src="http://placehold.it/200x200" alt="...">
							</div>
							<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px"></div>
							<div>
								<span class="btn btn-xs btn-default btn-file">
										<span class="fileinput-new">Select image</span>
							
								<span class="fileinput-exists">Change</span>
								<input type="file" name="userfile" accept="image/*">
								</span>
								<a href="#" class="btn btn-xs btn-warning fileinput-exists" data-dismiss="fileinput">Remove</a>
							</div>
						</div>
					</div>
				</div>
						<div class="form-group">
							  <div class="col-sm-offset-3 col-sm-5">
								  <button type="submit" class="btn btn-primary"><?php echo get_phrase('add_marshal');?></button>
							  </div>
							</div>
					</form>                
				</div>                
			</div>
			<!--CREATION FORM ENDS-->

		</div>
	</div>
   </div>
</div>
