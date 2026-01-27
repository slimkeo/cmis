<?php 
$edit_data		=	$this->db->get_where('device' , array('device_id' => $param2) )->result_array();
?>

<section class="panel">
	<?php foreach($edit_data as $row):?>
	<?php echo form_open(base_url() . 'index.php?admin/devices/do_update/'.$row['device_id'] , array('class' => 'form-horizontal form-bordered validate','target'=>'_top'));?>
	<div class="panel-heading">
		<h4 class="panel-title" >
			<i class="fa fa-pencil-square"></i>
			<?php echo get_phrase('edit_devices');?>
		</h4>
	</div>
	
		<div class="panel-body">
			<div class="form-group">
					<label class="col-sm-3 control-label"><?php echo get_phrase('device_name');?></label>
					<div class="col-sm-7">
						<input type="text" class="form-control" name="device_name" value="<?php echo $row['device_name'];?>"
							required title="<?php echo get_phrase('value_required');?>"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label"><?php echo get_phrase('serial');?></label>
					<div class="col-sm-7">
						<input type="text" class="form-control" name="serial" value="<?php echo $row['serial'];?>"
							required title="<?php echo get_phrase('value_required');?>"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label"><?php echo get_phrase('Swazi_MTN');?></label>
					<div class="col-sm-7">
						<input type="text" class="form-control" name="mtnphone" value="<?php echo $row['mtnphone'];?>"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label"><?php echo get_phrase('MTN_PUK');?></label>
					<div class="col-sm-7">
						<input type="text" class="form-control" name="mtnpuk" value="<?php echo $row['mtnpuk'];?>"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label"><?php echo get_phrase('MTN_sim');?></label>
					<div class="col-sm-7">
						<input type="text" class="form-control" name="mtnsim" value="<?php echo $row['mtnsim'];?>"/>
					</div>
				</div>
				<hr />
				
					<div class="form-group">
					<label class="col-sm-3 control-label"><?php echo get_phrase('swazi_mobile');?></label>
					<div class="col-sm-7">
						<input type="text" class="form-control" name="smmobile" value="<?php echo $row['smmobile'];?>"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label"><?php echo get_phrase('SM_sim');?></label>
					<div class="col-sm-7">
						<input type="text" class="form-control" name="smsim" value="<?php echo $row['smsim'];?>"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label"><?php echo get_phrase('SM_PUK');?></label>
					<div class="col-sm-7">
						<input type="text" class="form-control" name="smsim" value="<?php echo $row['smpuk'];?>"/>
					</div>
				</div>
				
		</div>
	
		<footer class="panel-footer">
			<div class="row">
			<div class="col-sm-9 col-sm-offset-3">
			 <button type="submit" class="btn btn-primary"><?php echo get_phrase('edit_device');?></button>
			</div>
			</div>
		</footer>
		
 </form>
 <?php endforeach;?>
</section> 
        
        