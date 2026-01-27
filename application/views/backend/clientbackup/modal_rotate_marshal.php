<?php 
	$edit_data		=	$this->db->get_where('schedulenov' , array('schedule_id' => $param2) )->result_array();
   $query = $this->db->get( 'bays' );
   $bays = $query->result_array();
   
      
   $querym = $this->db->get( 'marshal' );
   $marshal = $querym->result_array();
   
?>

<section class="panel">
	<?php foreach($edit_data as $row):?>
	<?php echo form_open(base_url() . 'index.php?admin/schedule/rotate/'.$row['schedule_id'] , array('class' => 'form-horizontal form-bordered validate','target'=>'_top'));?>
	<div class="panel-heading">
		<h4 class="panel-title" >
			<i class="fa fa-pencil-square"></i>
			<?php echo get_phrase('create_schedule');?>
		</h4>
	</div>
	
		<div class="panel-body">
				<div class="form-group">
					<label class="col-sm-3 control-label"><?php echo get_phrase('marshal');?></label>
					<div class="col-sm-7">
				<input type="text" readonly="true" class="form-control" name="marshal" value="<?php echo $row['marshal'];?>"/>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label"><?php echo get_phrase('week');?></label>
					<div class="col-sm-7">
					
						<select name="week" data-plugin-selectTwo data-minimum-results-for-search="Infinity" data-width="100%" class="form-control populate">
							<option value=""><?php echo get_phrase('select');?></option>
							<option value="Week 1"><?php echo get_phrase('week_1');?></option>
							<option value="Week 2"><?php echo get_phrase('week_2');?></option>
							<option value="Week 3"><?php echo get_phrase('week_3');?></option>
							<option value="Week 4"><?php echo get_phrase('week_4');?></option>
						</select>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label"><?php echo get_phrase('bayset');?></label>
					<div class="col-sm-7">
						<select data-plugin-selectTwo class="form-control populate" name="bayset" onchange="class_section(this.value)" style="width: 100%">
					<option value=""><?php echo $row['bayset']; ?></option>
					<?php foreach ($bays as $rowz): ?>
					<option value="<?php echo $rowz['bay_name']; ?>" <?php if ($bay_id == $rowz[ 'bay_id']) echo 'selected'; ?>><?php echo $rowz['bay_name']; ?></option>
					<?php endforeach; ?>
				</select>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label"><?php echo get_phrase('rotation_reason');?></label>
					<div class="col-sm-7">
					<select name="week" data-plugin-selectTwo data-minimum-results-for-search="Infinity" data-width="100%" class="form-control populate">
							<option value=""><?php echo get_phrase('select_reason');?></option>
							<option value="Schedule"><?php echo get_phrase('scheduled Rotation');?></option>
							<option value="Sick"><?php echo get_phrase('sick');?></option>
							<option value="Personal reasons"><?php echo get_phrase('personal');?></option>
							<option value="No Uniform"><?php echo get_phrase('no_uniform');?></option>
							<option value="Late Coming"><?php echo get_phrase('late_coming');?></option>
							
						</select>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label"><?php echo get_phrase('fill_in_for');?></label>
					<div class="col-sm-7">
									<select data-plugin-selectTwo class="form-control populate" name="marshal" onchange="class_section(this.value)" style="width: 100%">
					<option value=""><?php echo $row['marshal']; ?></option>
					<?php foreach ($marshal as $rowzm): ?>
					<option value="<?php echo $rowzm['marshal']; ?>" <?php if ($marshal_id == $rowzm[ 'marshal_id']) echo 'selected'; ?>><?php echo $rowzm['name']; ?></option>
					<?php endforeach; ?>
				</select>
					</div>
				</div>
			
				
		</div>
	
		<footer class="panel-footer">
			<div class="row">
			<div class="col-sm-9 col-sm-offset-3">
			 <button type="submit" class="btn btn-primary"><?php echo get_phrase('re_schedule_marshal');?></button>
			</div>
			</div>
		</footer>
		
 </form>
 <?php endforeach;?>
</section> 
        
        