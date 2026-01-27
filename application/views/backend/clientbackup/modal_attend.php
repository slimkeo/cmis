<?php 
$edit_data		=	$this->db->get_where('incident' , array('id' => $param2) )->result_array();
?>



<section class="panel">
	<?php foreach($edit_data as $row):?>
	<?php echo form_open(base_url() . 'index.php?admin/incident/do_update/'.$row['id'] , array('class' => 'form-horizontal form-bordered validate','target'=>'_top'));?>
	<div class="panel-heading">
		<h4 class="panel-title" >
			<i class="fa fa-pencil-square"></i>
			<?php echo get_phrase('attend_incident');?>
		</h4>
	</div>
	
		<div class="panel-body">
				<div class="form-group">
					<label class="col-sm-3 control-label"><?php echo get_phrase('marshal');?></label>
					<div class="col-sm-7">
						<input type="text" class="form-control" name="marshal" value="<?php echo $row['marshal'];?>"
							required title="<?php echo get_phrase('value_required');?>"/>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label"><?php echo get_phrase('bayset');?></label>
					<div class="col-sm-7">
						<input type="text" class="form-control" name="bayset" value="<?php echo $row['bayset'];?>"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label"><?php echo get_phrase('incident');?></label>
					<div class="col-sm-7">
						<input type="text" class="form-control" name="incident" value="<?php echo $row['incident'];?>"/>
					</div>
				</div>
		</div>
	
		<footer class="panel-footer">
			<div class="row">
			<div class="col-sm-9 col-sm-offset-3">
			 <button type="submit" class="btn btn-primary"><?php echo get_phrase('confirm_attendend');?></button>
			</div>
			</div>
		</footer>
		
 </form>
 <?php endforeach;?>
</section> 
        
        