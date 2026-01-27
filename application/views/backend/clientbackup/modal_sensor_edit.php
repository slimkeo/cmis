<?php
$edit_data = $this->db->get_where( 'sensor', array( 'id' => $param2 ) )->result_array();


   $query = $this->db->get( 'bays' );
   $bays = $query->result_array();
   
   $querys = $this->db->get( 'street' );
   $streets = $querys->result_array();


foreach ( $edit_data as $row ):
	?>
	<div class="row">
		<div class="col-md-12">
			<section class="panel">
			
				<?php echo form_open(base_url() . 'index.php?admin/sensors/do_update/'.$row['id'] , array('class' => 'form-horizontal form-bordered','target'=>'_top', 'id' => 'form', 'enctype' => 'multipart/form-data'));?>
				
				<div class="panel-heading">
					<h4 class="panel-title">
            		<i class="fa fa-pencil-square"></i>
					<?php echo get_phrase('edit_sensor');?>
            	</h4>
				
				</div>

				<div class="panel-body">
					
					

					<div class="form-group">
						<label class="col-md-3 control-label">
							<?php echo get_phrase('wpsdid');?>
						</label>
						<div class="col-md-7">
							<input type="text" class="form-control" required name="wpsdid" value="<?php echo $row['wpsdid'];?>"/>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-md-3 control-label">
							<?php echo get_phrase('hardver');?>
						</label>
						<div class="col-md-7">
							<input type="text" class="form-control" required name="hardver" value="<?php echo $row['hardver'];?>"/>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-md-3 control-label">
							<?php echo get_phrase('softver');?>
						</label>
						<div class="col-md-7">
							<input type="text" class="form-control" required name="softver" value="<?php echo $row['softver'];?>"/>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-md-3 control-label">
							<?php echo get_phrase('voltage');?>
						</label>
						<div class="col-md-7">
							<input type="text" class="form-control" required name="voltage" value="<?php echo $row['voltage'];?>"/>
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
				<div class="form-group">
					<label class="col-sm-3 control-label"><?php echo get_phrase('street');?></label>
					<div class="col-sm-7">
		<select data-plugin-selectTwo class="form-control populate" name="street_id" onchange="class_section(this.value)" style="width: 100%">
					<option value="<?php echo $rowzm['street_id']; ?>"><?php echo $this->db->get_where('street' , array(
                                        'street_id' => $row['street_id']
                                    ))->row()->street_name; ?></option>
					<?php foreach ($streets as $rowzm): ?>
					<option value="<?php echo $rowzm['street_id']; ?>" <?php if ($street_id == $rowzm[ 'street_id']) echo 'selected'; ?>><?php echo $rowzm['street_name']; ?></option>
					<?php endforeach; ?>
				</select>
					</div>
				</div>
					
					
					
					

				</div>
				<footer class="panel-footer">
					<div class="row">
						<div class="col-sm-9 col-sm-offset-3">
							<button type="submit" class="btn btn-primary">
								<?php echo get_phrase('edit_sensor');?>
							</button>
						</div>
					</div>
				</footer>
				<?php echo form_close();?>
			</section>
		</div>
	</div>

<?php
endforeach;
?>