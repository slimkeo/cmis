<div class="row">
	<div class="col-md-12">

		<!---CONTROL TABS START-->
		<div class="tabs">
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#list" data-toggle="tab"><i class="fa fa-list"></i> 
					<?php echo get_phrase('monthly_subscriber');?>
						</a></li>
			<li>
				<a href="#add" data-toggle="tab"><i class="fa fa-plus-circle"></i>
				<?php echo get_phrase('new_subscriber');?>
						</a></li>
		</ul>
		<!---CONTROL TABS END-->

		<div class="tab-content">
		<br>
			<!--TABLE LISTING STARTS-->
			<div class="tab-pane box active" id="list">
			
		<table class="table table-bordered table-striped  mb-none" id="datatable-tabletools">
			<thead>
				<tr>
					<th width="10">
						
					</th>
					<th>
						<div>
							<?php echo get_phrase('name');?>
						</div>
					</th>
					<th>
						<div>
							<?php echo get_phrase('car_reg');?>
						</div>
					</th>
					<th>
						<div>
							<?php echo get_phrase('alt_car_reg');?>
						</div>
					</th>
<th>
						<div>
							<?php echo get_phrase('code');?>
						</div>
					</th>
					<th>
						<div>
							<?php echo get_phrase('organization');?>
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
				$count = 1;
				$disks = $this->db->get( 'disks' )->result_array();
				foreach ( $disks as $row ): ?>
				<tr>
					
					<td>
						<?php echo $count++;?>
					</td>
					<td>
						<?php echo $row['name'];?>
					</td>
					<td>
						<?php echo $row['car_reg'];?>
					</td>
					<td>
						<?php echo $row['alt_car_reg'];?>
					</td>
<td>
						<?php echo $row['qr'];?>
					</td>
					<td>
						<?php echo $row['organization'];?>
					</td>
					<td>

						<!-- TEACHER EDITING LINK -->

						<a href="#" class="btn btn-xs btn-primary" data-placement="top" data-toggle="tooltip" data-original-title="<?php echo get_phrase('edit');?>" onClick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_edit_disks/<?php echo $row['dignitaries_id'];?>');">
                        <i class="fa fa-pencil"></i>
                        </a>

						<!-- TEACHER DELETION LINK -->
						<a href="#" class="btn btn-xs btn-info" data-placement="top" data-toggle="tooltip" data-original-title="<?php echo get_phrase('edit');?>" onClick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_qr_code/<?php echo $row['disk_id'];?>');">
                        <i class="fa fa-camera"></i>
                        </a>	

						<!-- TEACHER DELETION LINK -->
						<a href="#" class="btn btn-xs btn-danger" data-placement="top" data-toggle="tooltip" data-original-title="<?php echo get_phrase('delete');?>" onClick="confirm_modal('<?php echo base_url();?>index.php?admin/disks/delete/<?php echo $row['disk_id'];?>');">
                        <i class="fa fa-trash"></i>
                        </a>			

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
					<?php echo form_open(base_url() . 'index.php?admin/disks/create' , array('class' => 'form-horizontal form-bordered validate'));?>
							<div class="form-group">
								<label class="col-sm-3 control-label"><?php echo get_phrase('name');?> <span class="required">*</span></label>
								<div class="col-sm-5">
									<input type="text" class="form-control" name="name" required title="<?php echo get_phrase('value_required');?>" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label"><?php echo get_phrase('car_reg');?></label>
								<div class="col-sm-5">
							<input type="text" class="form-control" name="car_reg" required title="<?php echo get_phrase('value_required');?>" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label"><?php echo get_phrase('alt_car_reg');?></label>
								<div class="col-sm-5">
									<input type="text" class="form-control" name="alt_car_reg"/>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label"><?php echo get_phrase('organization');?></label>
								<div class="col-sm-5">
									<input type="text" class="form-control" name="organization"/>
								</div>
							</div>
						<div class="form-group">
							  <div class="col-sm-offset-3 col-sm-5">
								  <button type="submit" class="btn btn-primary"><?php echo get_phrase('issue_parking_disk');?></button>
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
