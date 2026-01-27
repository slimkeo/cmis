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
	<?php echo form_open(base_url() . 'index.php?admin/allocations/do_update/'.$row['assignment_id'] , array('class' => 'form-horizontal form-bordered validate','target'=>'_top'));?>
	<div class="panel-heading">
		<h4 class="panel-title" >
			<i class="fa fa-calendar"></i>
			<?php echo get_phrase('reschedule_marshal');?>
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
		<select data-plugin-selectTwo class="form-control populate" name="bay_id" onchange="class_section(this.value)" style="width: 100%">
					<option value="<?php echo $rowzm['bay_id']; ?>"><?php echo $this->db->get_where('bays' , array(
                                        'bay_id' => $row['bay_id']
                                    ))->row()->bay_name; ?></option>
					<?php foreach ($bays as $rowzm): ?>
					<option value="<?php echo $rowzm['bay_id']; ?>" <?php if ($bay_id == $rowzm[ 'bay_id']) echo 'selected'; ?>><?php echo $rowzm['bay_name']; ?></option>
					<?php endforeach; ?>
				</select>
					</div>
				</div>


				
				
		</div>
	
		<footer class="panel-footer">
			<div class="row">
			<div class="col-sm-9 col-sm-offset-3">
			 <button type="submit" class="btn btn-primary"><?php echo get_phrase('reschedule_marshal');?></button>
			</div>
			</div>
		</footer>
		
 </form>
 <?php endforeach;?>
</section> 
        
        