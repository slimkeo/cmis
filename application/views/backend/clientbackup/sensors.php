<?php

   
    $query2 = $this->db->get( 'street' );
   	$streets = $query2->result_array();
   
   $query3 = $this->db->get( 'bays' );
   $bays = $query3->result_array();
?>

<div class="row">
	<div class="col-md-12">

		<!---CONTROL TABS START-->
		<div class="tabs">
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#list" data-toggle="tab"><i class="fa fa-list"></i> 
					<?php echo get_phrase('sensors');?>
						</a></li>
			<li>
				<a href="#add" data-toggle="tab"><i class="fa fa-plus-circle"></i>
					<?php echo get_phrase('add_sensor');?>
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
							<th>#</th>
							<th><div><?php echo get_phrase('wpsdid');?></div></th>
							<th><div><?php echo get_phrase('hardver');?></div></th>
							<th><div><?php echo get_phrase('softver');?></div></th>
							<th><div><?php echo get_phrase('voltage');?></div></th>
							<th><div><?php echo get_phrase('bay');?></div></th>
							<th><div><?php echo get_phrase('street');?></div></th>
							<th><div><?php echo get_phrase('options');?></div></th>
						</tr>
					</thead>
					<tbody>
						<?php $count = 1;foreach($sensors as $row):?>
						<tr>
							<td><?php echo $count++;?></td>
							<td><?php echo $row['wpsdid'];?></td>
							<td><?php echo $row['hardver'];?></td>
							<td><?php echo $row['softver'];?></td>
							<td><?php echo $row['voltage'];?></td>
							<td><?php echo $this->db->get_where('bays' , array(
                                        'bay_id' => $row['bay_id']
                                    ))->row()->bay_name;
                             ?></td>
							<td><?php echo $this->db->get_where('street' , array(
                                        'street_id' => $row['street_id']
                                    ))->row()->street_name;
                             ?></td>
							
							<td>
							
							<!-- DETAILS LINK -->
								<a href="#" class="btn btn-info btn-xs" data-placement="top" data-toggle="tooltip" data-original-title="<?php echo get_phrase('details');?>" onClick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_sensor_details/<?php echo $row['id'];?>');">
								<i class="fa fa-info"></i>
								</a>
								
								
							<!--  EDITING LINK  -->
								<a href="#" class="btn btn-warning btn-xs" data-placement="top" data-toggle="tooltip" data-original-title="<?php echo get_phrase('edit');?>" onClick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_sensor_edit/<?php echo $row['id'];?>');">
								<i class="fa fa-edit"></i>
								</a>
							

								<!-- DELETION LINK -->
								<a href="#" class="btn btn-danger btn-xs" data-placement="top" data-toggle="tooltip" data-original-title="<?php echo get_phrase('delete');?>" onClick="confirm_modal('<?php echo base_url();?>index.php?admin/sensors/delete/<?php echo $row['id'];?>');">
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
					<?php echo form_open(base_url() . 'index.php?admin/sensors/create' , array('class' => 'form-horizontal form-bordered validate'));?>
							<div class="form-group">
								<label class="col-sm-3 control-label"><?php echo get_phrase('wpsdid');?> <span class="required">*</span></label>
								<div class="col-sm-5">
									<input type="text" class="form-control" name="wpsdid" required title="<?php echo get_phrase('value_required');?>" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label"><?php echo get_phrase('hardver');?></label>
								<div class="col-sm-5">
									<input type="text" class="form-control" name="hardver" required title="<?php echo get_phrase('value_required');?>" />
				
								</div>
							</div>
							
								<div class="form-group">
								<label class="col-sm-3 control-label"><?php echo get_phrase('softver');?> <span class="required">*</span></label>
								<div class="col-sm-5">
									<input type="text" class="form-control" name="softver" required title="<?php echo get_phrase('value_required');?>" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label"><?php echo get_phrase('voltage');?></label>
								<div class="col-sm-5">
									<input type="text" class="form-control" name="voltage" required title="<?php echo get_phrase('value_required');?>" />
				
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-3 control-label"><?php echo get_phrase('bay');?></label>
								<div class="col-sm-5">
										<select data-plugin-selectTwo class="form-control populate" name="bay_id" onchange="class_section(this.value)" style="width: 100%">
					<option value=""><?php echo get_phrase('select_bay'); ?></option>
					<?php foreach ($bays as $rowz): ?>
					<option value="<?php echo $rowz['bay_id']; ?>" <?php if ($bay_id == $rowz[ 'bay_id']) echo 'selected'; ?>><?php echo $rowz['bay_name']; ?></option>
					<?php endforeach; ?>
				</select>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-3 control-label"><?php echo get_phrase('street');?></label>
								<div class="col-sm-5">
										<select data-plugin-selectTwo class="form-control populate" name="street_id" onchange="class_section(this.value)" style="width: 100%">
					<option value=""><?php echo get_phrase('select_street'); ?></option>
					<?php foreach ($streets as $rowz): ?>
					<option value="<?php echo $rowz['street_id']; ?>" <?php if ($street_id == $rowz[ 'street_id']) echo 'selected'; ?>><?php echo $rowz['street_name']; ?></option>
					<?php endforeach; ?>
				</select>
								</div>
							</div>
							
				
							
							<div class="form-group">
								<label class="col-sm-3 control-label"><?php echo get_phrase('status');?></label>
								<div class="col-sm-5">
										 <select name="status" class="form-control" required data-plugin-selectTwo data-width="100%" data-minimum-results-for-search="Infinity" >
                                <option value=""><?php echo get_phrase('select_status');?></option>
                                <option value="Active"><?php echo get_phrase('Active');?></option>
                                <option value="Disabled"><?php echo get_phrase('Disabled');?></option>
                            </select>
								</div>
							</div>
						<div class="form-group">
							  <div class="col-sm-offset-3 col-sm-5">
								  <button type="submit" class="btn btn-primary"><?php echo get_phrase('add_sensor');?></button>
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
