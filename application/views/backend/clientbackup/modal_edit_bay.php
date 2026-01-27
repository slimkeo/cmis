<?php 
$edit_data		=	$this->db->get_where('bays' , array('bay_id' => $param2) )->result_array();
?>
<?php
   $query = $this->db->get( 'street' );
   $street = $query->result_array();
?>


<section class="panel">
	<?php foreach($edit_data as $row):?>
	<?php echo form_open(base_url() . 'index.php?admin/bays/do_update/'.$row['bay_id'] , array('class' => 'form-horizontal form-bordered validate','target'=>'_top'));?>
	<div class="panel-heading">
		<h4 class="panel-title" >
			<i class="fa fa-pencil-square"></i>
			<?php echo get_phrase('edit_Bay');?>
		</h4>
	</div>
	
		<div class="panel-body">
				<div class="form-group">
					<label class="col-sm-3 control-label"><?php echo get_phrase('bay_name');?></label>
					<div class="col-sm-7">
						<input type="text" class="form-control" name="bay_name" value="<?php echo $row['bay_name'];?>"
							required title="<?php echo get_phrase('value_required');?>"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label"><?php echo get_phrase('street_name');?></label>
					<div class="col-sm-7">
						<select data-plugin-selectTwo class="form-control populate" name="street_id" onchange="class_section(this.value)" style="width: 100%">
					<option value=""><?php echo $this->db->get_where('street' , array('street_id' => $row['street_id']))->row()->street_name;?>
					</option>
					<?php foreach ($street as $rowz): ?>
					<option value="<?php echo $rowz['street_id']; ?>" <?php if ($street_id == $rowz[ 'street_id']) echo 'selected'; ?>><?php echo $rowz['street_name']; ?></option>
					<?php endforeach; ?>
				</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label"><?php echo get_phrase('max_user');?></label>
					<div class="col-sm-7">
						<input type="text" class="form-control" name="max_user" value="<?php echo $row['max_user'];?>"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label"><?php echo get_phrase('peak_hour');?></label>
					<div class="col-sm-7">
						<input type="text" class="form-control" name="peak_hour" value="<?php echo $row['peak_hour'];?>"/>
					</div>
				</div>
		</div>
	
		<footer class="panel-footer">
			<div class="row">
			<div class="col-sm-9 col-sm-offset-3">
			 <button type="submit" class="btn btn-primary"><?php echo get_phrase('edit_bay');?></button>
			</div>
			</div>
		</footer>
		
 </form>
 <?php endforeach;?>
</section> 
        
        