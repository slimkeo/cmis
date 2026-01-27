<?php
   $query = $this->db->get( 'town' );
   $towns = $query->result_array();
?>

<?php
$edit_data = $this->db->get_where( 'client', array( 'id' => $param2 ) )->result_array();
foreach ( $edit_data as $row ):
	?>
	<div class="row">
		<div class="col-md-12">
			<section class="panel">
			
				<?php echo form_open(base_url() . 'index.php?admin/client/do_update/'.$row['id'] , array('class' => 'form-horizontal form-bordered','target'=>'_top', 'id' => 'form', 'enctype' => 'multipart/form-data'));?>
				
				<div class="panel-heading">
					<h4 class="panel-title">
            		<i class="fa fa-pencil-square"></i>
					<?php echo get_phrase('edit_client')." Acccount : ".$row['id'];?>
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
							<?php echo get_phrase('fullname');?>
						</label>
						<div class="col-md-7">
							<input type="text" class="form-control" required name="fullname" value="<?php echo $row['fullname'];?>"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">
							<?php echo get_phrase('lastname');?>
						</label>
						<div class="col-md-7">
							<input type="text" class="form-control" required name="lastname" value="<?php echo $row['lastname'];?>"/>
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
							<?php echo get_phrase('organization');?>
						</label>
						<div class="col-md-7">
							<input type="text" class="form-control" required name="organization" value="<?php echo $row['organization'];?>"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">
							<?php echo get_phrase('org_contact');?>
						</label>
						<div class="col-md-7">
							<input type="text" class="form-control" required name="org_contact" value="<?php echo $row['org_contact'];?>"/>
						</div>
					</div>	
					<div class="form-group">
						<label class="col-md-3 control-label">
							<?php echo get_phrase('salary');?>
						</label>
						<div class="col-md-7">
							<input type="text" class="form-control" required name="salary" value="<?php echo $row['salary'];?>"/>
						</div>
					</div>			
					<div class="form-group">
						<label class="col-md-3 control-label">
							<?php echo get_phrase('address');?>
						</label>
						<div class="col-md-7">
							<input type="text" class="form-control" required name="address" value="<?php echo $row['address'];?>"/>
						</div>
					</div>					
					
					<div class="form-group">
								<label class="col-sm-3 control-label"><?php echo get_phrase('town');?></label>
								<div class="col-sm-7">
								<select data-plugin-selectTwo class="form-control populate" name="town" onchange="class_section(this.value)" style="width: 100%">
					<?php foreach ($towns as $rowz): ?>
					<option value="<?php echo $rowz['id']; ?>" <?php if ($row['town'] == $rowz[ 'id']) echo 'selected'; ?>><?php echo $rowz['name']; ?></option>
					<?php endforeach; ?>
				</select>
								</div>
							</div>
					
					<div class="form-group">
						<label class="col-md-3 control-label">
							<?php echo get_phrase('email');?>
						</label>
						<div class="col-md-7">
							<input type="email" class="form-control" name="email" value="<?php echo $row['email'];?>"/>
						</div>
					</div>
					
					

				</div>
				<footer class="panel-footer">
					<div class="row">
						<div class="col-sm-9 col-sm-offset-3">
							<button type="submit" class="btn btn-primary">
								<?php echo get_phrase('edit_client');?>
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