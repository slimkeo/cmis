<?php 
$edit_data	=	$this->db->get_where('assignment' , array('assignment_id' => $param2) )->result_array();
   $query = $this->db->get( 'bays' );
   $bays = $query->result_array();
   
   $queryz = $this->db->get( 'device' );
   $device = $queryz->result_array();
   
   $querym = $this->db->get( 'marshal' );
   $marshal = $querym->result_array();
?>

<section class="panel">
	<?php foreach($edit_data as $row):?>
	<?php echo form_open(base_url() . 'index.php?admin/allocations/do_rotate/'.$row['assignment_id'] , array('class' => 'form-horizontal form-bordered validate','target'=>'_top'));?>
	<div class="panel-heading">
		<h4 class="panel-title" >
			<i class="fa fa-refresh"></i>
			<?php echo get_phrase('rotate_marshal');?>
		</h4>
	</div>
	
		<div class="panel-body">
				<div class="form-group">
					<label class="col-sm-3 control-label"><?php echo get_phrase('marshal');?></label>
					<div class="col-sm-7">
					
					<input type="text" name="marshal" value="<?php echo $this->db->get_where('marshal' , array(
                                        'marshal_id' => $row['marshal_id']
                                    ))->row()->name;
                                ?>" readonly="readonly" class="form-control"  />
					
									
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label"><?php echo get_phrase('bay_set');?></label>
					<div class="col-sm-7">
					<input type="hidden" name="bay_id" value="<?php echo $row['bay_id']; ?>" />
					<input type="text" name="bay" value="<?php echo $this->db->get_where('bays' , array(
                                        'bay_id' => $row['bay_id']
                                    ))->row()->bay_name;
                                ?>" readonly="readonly" class="form-control"  />
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label"><?php echo get_phrase('fill_in_by');?></label>
					<div class="col-sm-7">
					
		<select data-plugin-selectTwo class="form-control populate" name="marshal_id" onchange="class_section(this.value)" style="width: 100%">
					<option value=""><?php echo $this->db->get_where('marshal' , array(
                                        'marshal_id' => $row['marshal_id']
                                    ))->row()->name; ?></option>
					<?php foreach ($marshal as $rowzm): ?>
					<option value="<?php echo $rowzm['marshal_id']; ?>" <?php if ($marshal_id == $rowzm[ 'marshal_id']) echo 'selected'; ?>><?php echo $rowzm['name']; ?></option>
					<?php endforeach; ?>
				</select>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label"><?php echo get_phrase('duration');?></label>
					<div class="col-sm-7">
								<select data-plugin-selectTwo class="form-control populate" name="duration" onchange="class_section(this.value)" style="width: 100%">
					<option value=""><?php echo get_phrase('select_duration'); ?></option>
					<option value="1 hour"><?php echo get_phrase('1_hour'); ?></option>
					<option value="2 hours"><?php echo get_phrase('2_hours'); ?></option>
					<option value="3 hours"><?php echo get_phrase('3_hours'); ?></option>
					<option value="4 hours"><?php echo get_phrase('4_hours'); ?></option>
					<option value="8 hours"><?php echo get_phrase('8_hours'); ?></option>
					<option value="all day"><?php echo get_phrase('all_day'); ?></option>
				</select>
					</div>
				</div>
					<div class="form-group">
					<label class="col-sm-3 control-label"><?php echo get_phrase('reason');?></label>
					<div class="col-sm-7">
								<select data-plugin-selectTwo class="form-control populate" name="reason" onchange="class_section(this.value)" style="width: 100%">
					<option value=""><?php echo get_phrase('select_reason'); ?></option>
					<option value="break"><?php echo get_phrase('break'); ?></option>
					<option value="late"><?php echo get_phrase('late'); ?></option>
					<option value="absent"><?php echo get_phrase('absent'); ?></option>
					<option value="uniform"><?php echo get_phrase('uniform'); ?></option>
					<option value="medical"><?php echo get_phrase('medical'); ?></option>
					<option value="other"><?php echo get_phrase('other'); ?></option>
				</select>
					</div>
				</div>
				
		</div>
	
		<footer class="panel-footer">
			<div class="row">
			<div class="col-sm-9 col-sm-offset-3">
			 <button type="submit" class="btn btn-primary"><?php echo get_phrase('rotate_marshal');?></button>
			</div>
			</div>
		</footer>
		
 </form>
 <?php endforeach;?>
</section> 
        
        