<?php
   $query = $this->db->get( 'bays' );
   $bays = $query->result_array();
   
   $queryz = $this->db->get( 'device' );
   $device = $queryz->result_array();
   
   $querym = $this->db->get( 'marshal' );
   $marshal = $querym->result_array();
?>


<div class="row">
	<div class="col-md-12">

		<!---CONTROL TABS START-->
		<div class="tabs">
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#list" data-toggle="tab"><i class="fa fa-list"></i> 
					<?php echo get_phrase('allocations');?>
						</a></li>
			<li>
				<a href="#add" data-toggle="tab"><i class="fa fa-plus-circle"></i>
					<?php echo get_phrase('new_allocations');?>
						</a></li>
		</ul>
		<!---CONTROL TABS END-->

		<div class="tab-content">
		<br>
			<!--TABLE LISTING STARTS-->
			<div class="tab-pane box active" id="list">
				<table class="table table-bordered table-striped mb-none" id="datatable-tabletools">
					<thead>
						<tr>
							<th></th>
							<th><div><?php echo get_phrase('marshal');?></div></th>
							<th><div><?php echo get_phrase('device');?></div></th>
							<th><div><?php echo get_phrase('bay_set');?></div></th>
							<th><div><?php echo get_phrase('date_assigned');?></div></th>
							<th><div><?php echo get_phrase('options');?></div></th>
						</tr>
					</thead>
					<tbody>
						<?php $count = 1;foreach($assignments as $row):?>
						<tr>
						
							<td><?php echo $count++;?></td>
							<td><?php echo $this->db->get_where('marshal' , array(
                                        'marshal_id' => $row['marshal_id']
                                    ))->row()->name;
                                ?>
							</td>
							<td><?php echo $this->db->get_where('device' , array(
                                        'device_id' => $row['device_id']
                                    ))->row()->device_name;
                                ?>
							</td>
							
							<td><?php echo $this->db->get_where('bays' , array(
                                        'bay_id' => $row['bay_id']
                                    ))->row()->bay_name;
                                ?></td>
							<td><?php echo $row['date'];?></td>
							
							<td>


								<!-- EDITING LINK -->
								<a href="#" class="btn btn-primary btn-xs" data-placement="top" data-toggle="tooltip" data-original-title="<?php echo get_phrase('re_schedule');?>" onClick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_edit_allocation/<?php echo $row['assignment_id'];?>');">
								<i class="fa fa-calendar"></i>
								</a>
								
								
								<a href="#" class="btn btn-warning btn-xs" data-placement="top" data-toggle="tooltip" data-original-title="<?php echo get_phrase('change_gadget');?>" onClick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_change_gadget/<?php echo $row['assignment_id'];?>');">
								<i class="fa fa-tablet"></i>
								</a>
									<!-- EDITING LINK -->
								<a href="#" class="btn btn-success btn-xs" data-placement="top" data-toggle="tooltip" data-original-title="<?php echo get_phrase('bay_rotation');?>" onClick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_bay_rotation/<?php echo $row['assignment_id'];?>');">
								<i class="fa fa-refresh"></i>
								</a>
								
							

								<!-- DELETION LINK -->
								<a href="#" class="btn btn-danger btn-xs" data-placement="top" data-toggle="tooltip" data-original-title="<?php echo get_phrase('delete');?>" onClick="confirm_modal('<?php echo base_url();?>index.php?admin/allocations/delete/<?php echo $row['assignment_id'];?>');">
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
					<?php echo form_open(base_url() . 'index.php?admin/allocations/create' , array('class' => 'form-horizontal form-bordered validate'));?>
						
							<div class="form-group">
								<label class="col-sm-3 control-label"><?php echo get_phrase('marshal');?></label>
								<div class="col-sm-5">
										<select data-plugin-selectTwo class="form-control populate" name="marshal_id" onchange="class_section(this.value)" style="width: 100%">
					<option value=""><?php echo get_phrase('select_marshal'); ?></option>
					<?php foreach ($marshal as $rowzm): ?>
					<option value="<?php echo $rowzm['marshal_id']; ?>" <?php if ($marshal_id == $rowzm[ 'marshal_id']) echo 'selected'; ?>><?php echo $rowzm['name']; ?></option>
					<?php endforeach; ?>
				</select>
								</div>
							</div>
							
								
								<div class="form-group">
								<label class="col-sm-3 control-label"><?php echo get_phrase('device');?></label>
								<div class="col-sm-5">
										<select data-plugin-selectTwo class="form-control populate" name="device_id" onchange="class_section(this.value)" style="width: 100%">
					<option value=""><?php echo get_phrase('select_device'); ?></option>
					<?php foreach ($device as $rows): ?>
					<option value="<?php echo $rows['device_id']; ?>" <?php if ($device_id == $rows[ 'device_id']) echo 'selected'; ?>><?php echo $rows['device_name']; ?></option>
					<?php endforeach; ?>
				</select>
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
							  <div class="col-sm-offset-3 col-sm-5">
								  <button type="submit" class="btn btn-primary"><?php echo get_phrase('complete_allocation');?></button>
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
