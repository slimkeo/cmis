<div class="row">
	<div class="col-md-12">

		<!---CONTROL TABS START-->
		<div class="tabs">
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#list" data-toggle="tab"><i class="fa fa-list"></i> 
					<?php echo get_phrase('all_agms');?>
						</a></li>
			<li>
				<a href="#add" data-toggle="tab"><i class="fa fa-plus-circle"></i>
					<?php echo get_phrase('new_agm'); ?>
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
							<?php echo get_phrase('description');?>
						</div>
					</th>
					<th>
						<div>
							<?php echo get_phrase('date');?>
						</div>
					</th>
					<th>
						<div>
							<?php echo get_phrase('year');?>
						</div>
					</th>
<th>
						<div>
							<?php echo get_phrase('attendance');?>
						</div>
					</th>
<th>
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
				
				$i=1;
				foreach ( $agms as $row ): ?>
				<tr>
                    <td>
						<?php echo $i++;?>
					</td>
					<td>
						<?php echo $row['description'];?>
					</td>
					<td>
						<?php echo $row['date'];?>
					</td>
					<td>
						<?php echo $row['year'];?>
					</td>
					<td>
						<?php 
						//calculate year or else leave 0
						$attendance=0;
						echo $attendance;
						?>
					</td>
					<td>
						<?php echo $row['createdate'];?>
					</td>
					<td>

						<!-- VIEW CLIENT DETAILS LINK -->
						<a href="<?php echo base_url(); ?>index.php?burial/report_per_agm/<?php echo $row['id'];?>" class="btn btn-xs btn-info" data-placement="top" data-toggle="tooltip" 
						data-original-title="<?php echo get_phrase('view_agm');?>" target="_blank">
                        <i class="fa fa-eye"></i>
                        </a>


						<!-- CLIENT EDITING LINK -->

						<a href="#" class="btn btn-xs btn-success" data-placement="top" data-toggle="tooltip" 
						data-original-title="<?php echo get_phrase('edit');?>" onClick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_agm_edit/<?php echo $row['id'];?>');">
                        <i class="fa fa-pencil"></i>
                        </a>
						

						<!-- CLIENT DELETION LINK -->
						<a href="#" class="btn btn-xs btn-danger" data-placement="top" data-toggle="tooltip"
						 data-original-title="<?php echo get_phrase('delete');?>" onClick="confirm_modal('<?php echo base_url();?>index.php?burial/agms/delete/<?php echo $row['id'];?>');">
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
					<?php echo form_open(base_url() . 'index.php?burial/agms/create' , array('class' => 'form-horizontal form-bordered validate','enctype'=>'multipart/form-data'));?>
					<div class="form-group">
					<label class="col-md-3 control-label">
						<?php echo get_phrase('description');?>
					</label>

					<div class="col-md-7">
				<input type="text" class="form-control" name="description" required title="<?php echo get_phrase('value_required');?>" value="" autofocus>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label">
						<?php echo get_phrase('year');?> <span class="required">*</span>
					</label>

					<div class="col-md-7">
						<input type="number" class="form-control" name="year" required title="<?php echo get_phrase('value_required');?>" value="" autofocus>
					</div>
				</div>	
						<div class="form-group">
					<label class="col-md-3 control-label">
						<?php echo get_phrase('date');?> <span class="required">*</span>
					</label>

					<div class="col-md-7">
													<div class="input-daterange input-group" data-plugin-datepicker>
														<span class="input-group-addon">
															<i class="fa fa-calendar"></i>
														</span>
														<input type="text" class="form-control" name="date">
													</div>	
					</div>
				</div>
						<div class="form-group">
							  <div class="col-sm-offset-3 col-sm-5">
								  <button type="submit" class="btn btn-primary"><?php echo get_phrase('add_agm');?></button>
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
