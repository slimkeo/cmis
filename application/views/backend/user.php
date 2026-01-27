<div class="row">
	<div class="col-md-12">

		<!---CONTROL TABS START-->
		<div class="tabs">
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#list" data-toggle="tab"><i class="fa fa-list"></i> 
					<?php echo get_phrase('all_clients');?>
						</a></li>
			<li>
				<a href="#add" data-toggle="tab"><i class="fa fa-plus-circle"></i>
					<?php echo get_phrase('new_client'); ?>
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
							<?php echo get_phrase('client_no');?>
						</div>
					</th>
					<th>
						<div>
							<?php echo get_phrase('fullname');?>
						</div>
					</th>
					<th>
						<div>
							<?php echo get_phrase('organization');?>
						</div>
					</th>
<th>
						<div>
							<?php echo get_phrase('email');?>
						</div>
					</th>
<th>
						<div>
							<?php echo get_phrase('contact');?>
						</div>
					</th>
					<th>
						<div>
							<?php echo get_phrase('gender');?>
						</div>
					</th>
				<div>
						<?php echo get_phrase('createdate');?>
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
				
				$status = "Active";
				foreach ( $clients as $row ): ?>
				<tr>
                                       <td>
						<?php echo $row['client_id'];?>
					</td>
					<td>
						<?php echo $row['fullname'].' '.$row['lastname'];?>
					</td>
					<td>
						<?php echo $row['organization'];?>
					</td>
					<td>
						<?php echo $row['email'];?>
					</td>
					<td>
						<?php echo $row['contact'];?>
					</td>
					<td>
						<?php echo $row['gender'];?>
					</td>
					<td>

						<!-- VIEW CLIENT DETAILS LINK -->
						<a href="<?php echo base_url(); ?>index.php?admin/client_details/<?php echo $row['client_id'];?>" class="btn btn-xs btn-info" data-placement="top" data-toggle="tooltip" 
						data-original-title="<?php echo get_phrase('view_client');?>" target="_blank">
                        <i class="fa fa-eye"></i>
                        </a>


						<!-- CLIENT EDITING LINK -->

						<a href="#" class="btn btn-xs btn-success" data-placement="top" data-toggle="tooltip" 
						data-original-title="<?php echo get_phrase('edit');?>" onClick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_client_edit/<?php echo $row['client_id'];?>');">
                        <i class="fa fa-pencil"></i>
                        </a>
						

						<!-- CLIENT DELETION LINK -->
						<a href="#" class="btn btn-xs btn-danger" data-placement="top" data-toggle="tooltip"
						 data-original-title="<?php echo get_phrase('delete');?>" onClick="confirm_modal('<?php echo base_url();?>index.php?admin/client/delete/<?php echo $row['client_id'];?>');">
                        <i class="fa fa-trash"></i>
                        </a>			

					</td>
				</tr>
				<?php endforeach;?>
			</tbody>
		</table>
			</div>
			<!--TABLE LISTING ENDS//`id`,`national_id`, `fullname`, `contact`, `address`, `organization`, `salary`, `status`, `createdate`,''gender `timestamp`SELECT * FROM `client` WHERE 1  -->
			<!--CREATION FORM STARTS-->
			<div class="tab-pane box" id="add" style="padding: 5px">
				<div class="box-content">
					<?php echo form_open(base_url() . 'index.php?admin/clients/create' , array('class' => 'form-horizontal form-bordered validate','enctype'=>'multipart/form-data'));?>

						<div class="form-group">
					<label class="col-md-3 control-label">
						<?php echo get_phrase('fullname');?> <span class="required">*</span>
					</label>

					<div class="col-md-7">
						<input type="text" class="form-control" name="fullname" required title="<?php echo get_phrase('value_required');?>" value="" autofocus>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label">
						<?php echo get_phrase('lastname');?> <span class="required">*</span>
					</label>

					<div class="col-md-7">
						<input type="text" class="form-control" name="lastname" required title="<?php echo get_phrase('value_required');?>" value="" autofocus>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label">
						<?php echo get_phrase('gender');?>
					</label>

					<div class="col-md-7">
						<select name="gender" data-plugin-selectTwo data-minimum-results-for-search="Infinity" data-width="100%" class="form-control populate">
							<option value=""><?php echo get_phrase('select');?></option>
							<option value="Male"><?php echo get_phrase('male');?></option>
							<option value="Female"><?php echo get_phrase('female');?></option>
						</select>
					</div>
				</div>				
		<div class="form-group">
					<label class="col-md-3 control-label">
						<?php echo get_phrase('contact');?>
					</label>

					<div class="col-md-7">
				<input type="text" class="form-control" name="contact" required title="<?php echo get_phrase('value_required');?>" value="" autofocus>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label">
						<?php echo get_phrase('organization');?> <span class="required">*</span>
					</label>

					<div class="col-md-7">
						<input type="text" class="form-control" name="organization" required title="<?php echo get_phrase('value_required');?>" value="" autofocus>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label">
						<?php echo get_phrase('organization_contact');?> <span class="required">*</span>
					</label>

					<div class="col-md-7">
						<input type="text" class="form-control" name="org_contact" required title="<?php echo get_phrase('value_required');?>" value="" autofocus>
					</div>
				</div>				
				
				<div class="form-group">
					<label class="col-md-3 control-label">
						<?php echo get_phrase('address');?>
					</label>


					<div class="col-md-7">
				<input type="text" class="form-control" name="address" required title="<?php echo get_phrase('value_required');?>" value="" autofocus>
					</div>
				</div>
				<div class="form-group">
								<label class="col-sm-3 control-label"><?php echo get_phrase('town');?></label>
								<div class="col-sm-7">
								<select data-plugin-selectTwo class="form-control populate" name="town" onchange="class_section(this.value)" style="width: 100%">
									<?php foreach ($towns as $rowz): ?>
									<option value="<?php echo $rowz['id']; ?>" <?php if ($row['town'] == $rowz[ 'id']) echo 'selected'; ?>><?php echo $rowz['name']; ?></option>
									<?php endforeach; ?>
								</select>
								</div>
							</div>

				<div class="form-group">
					<label class="col-md-3 control-label">
						<?php echo get_phrase('email');?>
					</label>

					<div class="col-md-7">
						<input type="text" class="form-control" name="email" value="">
					</div>
				</div>

						<div class="form-group">
							  <div class="col-sm-offset-3 col-sm-5">
								  <button type="submit" class="btn btn-primary"><?php echo get_phrase('add_client');?></button>
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
