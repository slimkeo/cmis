<?php 
	$edit_data		=	$this->db->get_where('weeklyschedule' , array('schedule_id' => $param2) )->result_array();
   $query = $this->db->get( 'bays' );
   $bays = $query->result_array();
   
?>

<section class="panel">
	<?php foreach($edit_data as $row):?>
	<?php echo form_open(base_url() . 'index.php?admin/schedule/do_november/'.$row['schedule_id'] , array('class' => 'form-horizontal form-bordered validate','target'=>'_top'));?>
	<div class="panel-heading">
		<h4 class="panel-title" >
			<i class="fa fa-calendar"></i>
			<?php echo get_phrase('schedule_marshal');?>
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
					<option value=""><?php echo $row['bay_name']; ?></option>
					<?php foreach ($bays as $rowz): ?>
					<option value="<?php echo $rowz['bay_name']; ?>" <?php if ($bay_id == $rowz[ 'bay_id']) echo 'selected'; ?>><?php echo $rowz['bay_name']; ?></option>
					<?php endforeach; ?>
				</select>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label"><?php echo get_phrase('time_period');?></label>
					<div class="col-sm-7">
						<select name="time_period" data-plugin-selectTwo data-minimum-results-for-search="Infinity" data-width="100%" class="form-control populate">
							<option value=""><?php echo get_phrase('select');?></option>
							<option value="06:30 - 11:30 Hrs"><?php echo get_phrase('06:30 - 11:30 Hrs');?></option>
							<option value="06:30 - 13:00 Hrs"><?php echo get_phrase('06:30 - 13:00 Hrs');?></option>
							<option value="11:30 - 16:30 Hrs"><?php echo get_phrase('11:30 - 16:30 Hrs');?></option>
							<option value="11:30 - 18:00 Hrs"><?php echo get_phrase('11:30 - 18:00 Hrs');?></option>
							<option value="14:30 - 18:00 Hrs"><?php echo get_phrase('14:30 - 18:00 Hrs');?></option>
							<option value="06:30 - 18:00 Hrs"><?php echo get_phrase('06:30 - 18:00 Hrs');?></option>
							
						</select>
					</div>
				</div>
				
				
				<div class="form-group">
					<label class="col-sm-3 control-label"><?php echo get_phrase('schedule_date');?></label>
					<div class="col-sm-7">
						<select name="schedule_date" data-plugin-selectTwo data-minimum-results-for-search="Infinity" data-width="100%" class="form-control populate">
							<option value=""><?php echo get_phrase('select');?></option>
							<option value="Mon, Tue, Wed"><?php echo get_phrase('Mon, Tue, Wed');?></option>
							<option value="Mon, Thur,Sat"><?php echo get_phrase('Mon, Thur,Sat');?></option>
							<option value="Thur, Fri, Sat"><?php echo get_phrase('Thur, Fri, Sat');?></option>
							<option value="Tue, Fri, Sat"><?php echo get_phrase('Tue, Fri, Sat');?></option>
							<option value="Mon, Wed, Sat"><?php echo get_phrase('Mon, Wed, Sat');?></option>
							<option value="Tue, Fri, Sat"><?php echo get_phrase('Tue, Fri, Sat');?></option>
							<option value="All Week"><?php echo get_phrase('All Week');?></option>
						</select>
					</div>
				</div>
				
				
			
				
		</div>
	
		<footer class="panel-footer">
			<div class="row">
			<div class="col-sm-9 col-sm-offset-3">
			 <button type="submit" class="btn btn-primary"><?php echo get_phrase('schedule_marshal');?></button>
			</div>
			</div>
		</footer>
		
 </form>
 <?php endforeach;?>
</section> 
        
        