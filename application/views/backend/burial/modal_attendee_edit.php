<?php
$agms = $this->db->get_where('agms')->result_array();
$edit_data = $this->db->get_where( 'attendance', array( 'id' => $param2 ) )->result_array();
foreach ( $edit_data as $row ):
	?>
	<div class="row">
		<div class="col-md-12">
			<section class="panel">
			
				<?php echo form_open(base_url() . 'index.php?burial/attendance/do_update/'.$row['id'] , array('class' => 'form-horizontal form-bordered','target'=>'_top', 'id' => 'form', 'enctype' => 'multipart/form-data'));?>
				
				<div class="panel-heading">
					<h4 class="panel-title">
            		<i class="fa fa-pencil-square"></i>
					<?php echo 'Edit '.$row['fullname'];?>
            	</h4>
				
				</div>

				<div class="panel-body">
				<div class="form-group">
						<label class="col-md-3 control-label">
							<?php echo get_phrase('national_id');?>
						</label>
						<div class="col-md-7">
							<input type="text" class="form-control" required name="national_id" value="<?php echo $row['national_id'];?>"/>
						</div>
					</div>
				<div class="form-group">
						<label class="col-md-3 control-label">
							<?php echo get_phrase('passbook');?>
						</label>
						<div class="col-md-7">
							<input type="text" class="form-control" required name="passbook" value="<?php echo $row['passbook'];?>"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">
							<?php echo get_phrase('fullname');?>
						</label>
						<div class="col-md-7">
							<input type="text" class="form-control" required name="fullname" value="<?php echo $row['fullname'];?>"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">
							<?php echo get_phrase('contact');?>
						</label>
						<div class="col-md-7">
							<input type="text" class="form-control" required name="contact" value="<?php echo $row['contact'];?>"/>
						</div>
					</div>	
					<div class="form-group">
						<label class="col-md-3 control-label">
							<?php echo get_phrase('momo');?>
						</label>
						<div class="col-md-7">
							<input type="text" class="form-control" required name="momo" value="<?php echo $row['momo'];?>"/>
						</div>
					</div>	
					<div class="form-group">
					<label class="col-sm-3 control-label">AGM</label>
					<div class="col-sm-7">
						<select data-plugin-selectTwo class="form-control populate" name="agm" onchange="class_section(this.value)" style="width: 100%" required>
							<?php foreach ($agms as $rowz): ?>
							<option value="<?php echo $rowz['id']; ?>" <?php if ($row['agm'] == $rowz[ 'id']) echo 'selected'; ?>><?php echo $rowz['description']; ?></option>
							<?php endforeach; ?>
								</select>
								</div>
							</div>				
					

				</div>
				<footer class="panel-footer">
					<div class="row">
						<div class="col-sm-9 col-sm-offset-3">
							<button type="submit" class="btn btn-primary">
								EDIT ATTENDEE
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