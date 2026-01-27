<div class="row">
	<div class="col-md-12">

		<!---CONTROL TABS START-->
		<div class="tabs">
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#list" data-toggle="tab"><i class="fa fa-list"></i> 
					<?php echo get_phrase('supervisors');?>
						</a></li>
			<li>
				<a href="#add" data-toggle="tab"><i class="fa fa-plus-circle"></i>
					<?php echo get_phrase('add_supervisor');?>
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
					<th width="80">
						<div>
							<?php echo get_phrase('photo');?>
						</div>
					</th>
                     
					<th>
						<div>
							<?php echo get_phrase('name');?>
						</div>
					</th>
<th>
						<div>
							<?php echo get_phrase('address');?>
						</div>
					</th>
	
					<th>
						<div>
							<?php echo get_phrase('contact');?>
						</div>
					</th>
					
						<th>
						<div>
							<?php echo get_phrase('email');?>
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
				
				$supervisors = $this->db->get_where( 'supervisor', array('status' => $status))->result_array();
				foreach ( $supervisors as $row ): ?>
				<tr>
					<td class="center"><img src="<?php echo $this->crud_model->get_image_url('supervisor',$row['supervisor_id']);?>" width="30"/>
					</td>
                    
					<td>
						<?php echo $row['name'];?>
					</td>
<td>
						<?php echo $row['address'];?>
					</td>
					
					<td>
						<?php echo $row['phone'];?>
					</td>
					
					<td>
						<?php echo $row['email'];?>
					</td>
					
					<td>

						<!-- MARSHAL EDITING LINK -->

						<a href="#" class="btn btn-xs btn-primary" data-placement="top" data-toggle="tooltip" data-original-title="<?php echo get_phrase('edit');?>" onClick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_supervisor_edit/<?php echo $row['supervisor_id'];?>');">
                        <i class="fa fa-pencil"></i>
                        </a>

						<!-- TEACHER PASSWORD RESET LINK -->
						<a href="#" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo get_phrase('reset_password');?>" onClick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_supervisor_password/<?php echo $row['supervisor_id'];?>');">
                        <i class="fa fa-unlock-alt"></i>
                        </a>

						<!-- TEACHER DELETION LINK -->
						<a href="#" class="btn btn-xs btn-danger" data-placement="top" data-toggle="tooltip" data-original-title="<?php echo get_phrase('delete');?>" onClick="confirm_modal('<?php echo base_url();?>index.php?admin/marshal/delete/<?php echo $row['supervisor_id'];?>');">
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
					<?php echo form_open(base_url() . 'index.php?admin/supervisor/create' , array('class' => 'form-horizontal form-bordered validate'));?>

		
			

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
							<option value="Male"><?php echo get_phrase('male');?></option>
							<option value="Female"><?php echo get_phrase('female');?></option>
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
						<?php echo get_phrase('email');?>
					</label>

					<div class="col-md-7">
						<input type="email" class="form-control" name="email" value="">
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
								  <button type="submit" class="btn btn-primary"><?php echo get_phrase('add_supervisor');?></button>
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
