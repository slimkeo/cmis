<div class="row">
	<div class="col-md-12">

		<!---CONTROL TABS START-->
		<div class="tabs">
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#list" data-toggle="tab"><i class="fa fa-list"></i> 
					<?php echo get_phrase('all_users');?>
						</a></li>
			<li>
				<a href="#add" data-toggle="tab"><i class="fa fa-plus-circle"></i>
					<?php echo get_phrase('new_user'); ?>
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
							<?php echo get_phrase('national_id');?>
						</div>
					</th>
					<th>
						<div>
							<?php echo get_phrase('fullname');?>
						</div>
					</th>
					<th>
						<div>
							<?php echo get_phrase('email');?>
						</div>
					</th>
					<th>
						<div>
							<?php echo get_phrase('phone');?>
						</div>
					</th>
					<th>
						<div>
							<?php echo get_phrase('level');?>
						</div>
					</th>
					<th>
						<div>
							<?php echo get_phrase('createdate');?>
						</div>
					</th>
					<th>
						<div>
							<?php echo get_phrase('lastlogin');?>
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
				foreach ( $users as $row ): ?>
				<tr>
                    <td>
						<?php echo $i++;?>
					</td>
					<td>
						<?php echo $row['national_id'];?>
					</td>
					<td>
						<?php echo $row['name'];?>
					</td>
					<td>
						<?php echo $row['email'];?>
					</td>
					<td>
						<?php echo $row['phone'];?>
					</td>
					<td>
						<?php if ($row['level']==1) {
							echo "Admin";
						} elseif($row['level']==2){
							echo "Clerk";
						} elseif ($row['level']==3) {
							echo "Accountant";
						}
						;?>
					</td>
					<td>
						<?php echo $row['createdate'];?>
					</td>
					<td>
						<?php echo $row['last_login'];?>
					</td>
					<td>

						<!-- VIEW CLIENT DETAILS LINK -->
						<a href="<?php echo base_url(); ?>index.php?burial/report_per_user/<?php echo $row['id'];?>" class="btn btn-xs btn-info" data-placement="top" data-toggle="tooltip" 
						data-original-title="<?php echo get_phrase('view_agm');?>" target="_blank">
                        <i class="fa fa-eye"></i>
                        </a>


						<!-- CLIENT EDITING LINK -->

						<a href="#" class="btn btn-xs btn-success" data-placement="top" data-toggle="tooltip" 
						data-original-title="<?php echo get_phrase('edit');?>" onClick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_user_edit/<?php echo $row['id'];?>');">
                        <i class="fa fa-pencil"></i>
                        </a>
						

						<!-- CLIENT DELETION LINK -->
						<a href="#" class="btn btn-xs btn-danger" data-placement="top" data-toggle="tooltip"
						 data-original-title="<?php echo get_phrase('delete');?>" onClick="confirm_modal('<?php echo base_url();?>index.php?burial/manage_users/delete/<?php echo $row['id'];?>');">
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
					<?php echo form_open(base_url() . 'index.php?burial/manage_users/create' , array('class' => 'form-horizontal form-bordered validate','enctype'=>'multipart/form-data'));?>
					<div class="form-group">
					<label class="col-md-3 control-label">
						<?php echo get_phrase('national_id');?>
					</label>

					<div class="col-md-7">
				<input type="id" class="form-control" name="national_id" required title="<?php echo get_phrase('value_required');?>" value="" autofocus>
					</div>
				</div>
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
						<?php echo get_phrase('email');?> <span class="required">*</span>
					</label>

					<div class="col-md-7">
						<input type="text" class="form-control" name="email" required title="<?php echo get_phrase('value_required');?>" value="" autofocus>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label">
						<?php echo get_phrase('phone');?> <span class="required">*</span>
					</label>

					<div class="col-md-7">
						<input type="text" class="form-control" name="phone" required title="<?php echo get_phrase('value_required');?>" value="" autofocus>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label">
						<?php echo get_phrase('admin_previleges');?>
					</label>

					<div class="col-md-7">
						<select name="level" data-plugin-selectTwo data-minimum-results-for-search="Infinity" data-width="100%" class="form-control populate" required>
							<option value=""><?php echo get_phrase('select');?></option>
							<option value="1"><?php echo get_phrase('admin');?></option>
							<option value="2"><?php echo get_phrase('clerk');?></option>
							<option value="3"><?php echo get_phrase('finance');?></option>
						</select>
					</div>	
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label">
						<?php echo get_phrase('auto_generated_password');?> <span class="required">*</span>
					</label>

					<div class="col-md-7">
						<input type="text" class="form-control" name="password" required title="<?php echo get_phrase('value_required');?>" value="The Last 6 digits of id number" readonly>
					</div>
				</div>
						<div class="form-group">
							  <div class="col-sm-offset-3 col-sm-5">
								  <button type="submit" class="btn btn-primary"><?php echo get_phrase('add_user');?></button>
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
