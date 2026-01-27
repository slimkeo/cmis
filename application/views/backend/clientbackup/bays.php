<?php
   $query = $this->db->get( 'street' );
   $street = $query->result_array();
?>

<div class="row">
	<div class="col-md-12">

		<!---CONTROL TABS START-->
		<div class="tabs">
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#list" data-toggle="tab"><i class="fa fa-list"></i> 
					<?php echo get_phrase('bays_list');?>
						</a></li>
			<li>
				<a href="#add" data-toggle="tab"><i class="fa fa-plus-circle"></i>
					<?php echo get_phrase('add_bays');?>
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
							<th><div><?php echo get_phrase('bay_name');?></div></th>
							<th><div><?php echo get_phrase('street');?></div></th>
							<th><div><?php echo get_phrase('current_#');?></div></th>
							<th><div><?php echo get_phrase('max_#');?></div></th>
							<th><div><?php echo get_phrase('peak_hour');?></div></th>
							<th><div><?php echo get_phrase('options');?></div></th>
						</tr>
					</thead>
					<tbody>
						<?php $count = 1;foreach($bays as $row):?>
						<tr>
							<td><?php echo $row['bay_name'];?></td>
							<td><?php echo $this->db->get_where('street' , array(
                                        'street_id' => $row['street_id']
                                    ))->row()->street_name;
                             ?></td>							
							<td><?php echo $row['current_marshals'];?></td>
							<td><?php echo $row['max_user'];?></td>
							<td><?php echo $row['peak_hour'];?></td>
							<td>


								<!-- EDITING LINK -->
								<a href="#" class="btn btn-primary btn-xs" data-placement="top" data-toggle="tooltip" data-original-title="<?php echo get_phrase('edit');?>" onClick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_edit_bay/<?php echo $row['bay_id'];?>');">
								<i class="fa fa-pencil"></i>
								</a>

								<!-- DELETION LINK -->
								<a href="#" class="btn btn-danger btn-xs" data-placement="top" data-toggle="tooltip" data-original-title="<?php echo get_phrase('delete');?>" onClick="confirm_modal('<?php echo base_url();?>index.php?admin/bays/delete/<?php echo $row['bay_id'];?>');">
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
					<?php echo form_open(base_url() . 'index.php?admin/bays/create' , array('class' => 'form-horizontal form-bordered validate'));?>
							<div class="form-group">
								<label class="col-sm-3 control-label"><?php echo get_phrase('bay_name');?> <span class="required">*</span></label>
								<div class="col-sm-5">
									<input type="text" class="form-control" name="bay_name" required title="<?php echo get_phrase('value_required');?>" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label"><?php echo get_phrase('street_name');?></label>
								<div class="col-sm-5">
										<select data-plugin-selectTwo class="form-control populate" name="street_name" onchange="class_section(this.value)" style="width: 100%">
					<option value=""><?php echo get_phrase('select_street'); ?></option>
					<?php foreach ($street as $rowz): ?>
					<option value="<?php echo $rowz['street_name']; ?>" <?php if ($street_id == $rowz[ 'street_id']) echo 'selected'; ?>><?php echo $rowz['street_name']; ?></option>
					<?php endforeach; ?>
				</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label"><?php echo get_phrase('max_user');?></label>
								<div class="col-sm-5">
									<input type="text" class="form-control" name="max_user"/>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label"><?php echo get_phrase('peak_hour');?></label>
								<div class="col-sm-5">
									<input type="text" class="form-control" name="peak_hour"/>
								</div>
							</div>
						<div class="form-group">
							  <div class="col-sm-offset-3 col-sm-5">
								  <button type="submit" class="btn btn-primary"><?php echo get_phrase('add_bay');?></button>
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
