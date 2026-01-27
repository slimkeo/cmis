<div class="row">
	<div class="col-md-12">

		<!---CONTROL TABS START-->
		<div class="tabs">
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#list" data-toggle="tab"><i class="fa fa-list"></i> 
					<?php echo get_phrase('device_list');?>
						</a></li>
			<li>
				<a href="#add" data-toggle="tab"><i class="fa fa-plus-circle"></i>
					<?php echo get_phrase('add_device');?>
						</a></li>
		</ul>
		<!---CONTROL TABS END-->

		<div class="tab-content">
		<br>
			<!--TABLE LISTING STARTS-->
			<div class="tab-pane box active" id="list">
				<table class="table table-bordered table-striped table-condensed mb-none" id="datatable-tabletools">
					<thead>
						<tr>
							<th><div><?php echo get_phrase('device_name');?></div></th>
							<th><div><?php echo get_phrase('device_serial');?></div></th>
							<th><div><?php echo get_phrase('mtn_number');?></div></th>
							<th><div><?php echo get_phrase('swazimobile');?></div></th>
							<th><div><?php echo get_phrase('add_date');?></div></th>
							<th><div><?php echo get_phrase('options');?></div></th>
						</tr>
					</thead>
					<tbody>
						<?php $count = 1;foreach($devices as $row):?>
						<tr>
							<td><?php echo $row['device_name'];?></td>
							<td><?php echo $row['serial'];?></td>
							<td><?php echo $row['mtnphone'];?></td>
							<td><?php echo $row['smmobile'];?></td>
							<td><?php echo $row['addDate'];?></td>
							<td>

									<!-- VIEW LINK -->
								<a href="#" class="btn btn-success btn-xs" data-placement="top" data-toggle="tooltip" data-original-title="<?php echo get_phrase('view');?>" onClick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_view_device/<?php echo $row['device_id'];?>');">
								<i class="fa fa-eye"></i>
								</a>

								<!-- EDITING LINK -->
								<a href="#" class="btn btn-primary btn-xs" data-placement="top" data-toggle="tooltip" data-original-title="<?php echo get_phrase('edit');?>" onClick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_edit_device/<?php echo $row['device_id'];?>');">
								<i class="fa fa-pencil"></i>
								</a>

								<!-- DELETION LINK -->
								<a href="#" class="btn btn-danger btn-xs" data-placement="top" data-toggle="tooltip" data-original-title="<?php echo get_phrase('delete');?>" onClick="confirm_modal('<?php echo base_url();?>index.php?admin/transport/delete/<?php echo $row['device_id'];?>');">
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
					<?php echo form_open(base_url() . 'index.php?admin/devices/create' , array('class' => 'form-horizontal form-bordered validate'));?>
							
							<div class="form-group">
								<label class="col-sm-3 control-label"><?php echo get_phrase('device_name');?></label>
									<div class="col-sm-7">
									<input type="text" class="form-control" name="device_name" value="<?php echo $row['device_name'];?>"
										required title="<?php echo get_phrase('value_required');?>"/>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-3 control-label"><?php echo get_phrase('serial');?> <span class="required">*</span></label>
								<div class="col-sm-5">
									<input type="text" class="form-control" name="serial" required title="<?php echo get_phrase('value_required');?>" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label"><?php echo get_phrase('MTN_No:');?></label>
								<div class="col-sm-5">
									<input type="text" class="form-control" name="mtnphone"/>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label"><?php echo get_phrase('MTN_Sim');?></label>
								<div class="col-sm-5">
									<input type="text" class="form-control" name="mtnsim"/>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label"><?php echo get_phrase('MTN_PUK');?></label>
								<div class="col-sm-5">
									<input type="text" class="form-control" name="mtnpuk"/>
								</div>
							</div>
							
							<hr/>
							
								<div class="form-group">
								<label class="col-sm-3 control-label"><?php echo get_phrase('Swazi_Mobile');?></label>
								<div class="col-sm-5">
									<input type="text" class="form-control" name="smmobile"/>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label"><?php echo get_phrase('SM_Sim');?></label>
								<div class="col-sm-5">
									<input type="text" class="form-control" name="smsim"/>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label"><?php echo get_phrase('SM_PUK');?></label>
								<div class="col-sm-5">
									<input type="text" class="form-control" name="snpuk"/>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-3 control-label"><?php echo get_phrase('add_date');?></label>
								<div class="col-sm-5">
									<input type="text" class="form-control" data-plugin-datepicker name="addDate"/>
								</div>
							</div>
						<div class="form-group">
							  <div class="col-sm-offset-3 col-sm-5">
								  <button type="submit" class="btn btn-primary"><?php echo get_phrase('add_device');?></button>
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
