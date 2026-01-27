<?php 
$edit_data		=	$this->db->get_where('street' , array('street_id' => $param2) )->result_array();
?>

<section class="panel">
	<?php foreach($edit_data as $row):?>
	<?php echo form_open(base_url() . 'index.php?admin/street/do_update/'.$row['street_id'] , array('class' => 'form-horizontal form-bordered validate','target'=>'_top'));?>
	<div class="panel-heading">
		<h4 class="panel-title" >
			<i class="fa fa-pencil-square"></i>
			<?php echo get_phrase('edit_transport');?>
		</h4>
	</div>
	
		<div class="panel-body">
				<div class="form-group">
					<label class="col-sm-3 control-label"><?php echo get_phrase('street_name');?></label>
					<div class="col-sm-7">
						<input type="text" class="form-control" name="street_name" value="<?php echo $row['street_name'];?>"
							required title="<?php echo get_phrase('value_required');?>"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label"><?php echo get_phrase('number_of_bays');?></label>
					<div class="col-sm-7">
						<input type="text" class="form-control" name="number_of_bays" value="<?php echo $row['number_of_bays'];?>"/>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label"><?php echo get_phrase('right_bays');?></label>
					<div class="col-sm-7">
						<input type="text" class="form-control" name="rightBays" value="<?php echo $row['rightBays'];?>"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label"><?php echo get_phrase('left_bays');?></label>
					<div class="col-sm-7">
						<input type="text" class="form-control" name="left_bays" value="<?php echo $row['leftBays'];?>"/>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label"><?php echo get_phrase('description');?></label>
					<div class="col-sm-7">
						<input type="text" class="form-control" name="description" value="<?php echo $row['description'];?>"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label"><?php echo get_phrase('street_type');?></label>
					<div class="col-sm-7">
						<input type="text" class="form-control" name="street_type" value="<?php echo $row['street_type'];?>"/>
					</div>
				</div>
		</div>
	
		<footer class="panel-footer">
			<div class="row">
			<div class="col-sm-9 col-sm-offset-3">
			 <button type="submit" class="btn btn-primary"><?php echo get_phrase('edit_street');?></button>
			</div>
			</div>
		</footer>
		
 </form>
 <?php endforeach;?>
</section> 
        
        