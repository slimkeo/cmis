
<?php 

$param1 = explode("_",$param2);
	    
$currentDateTime = $param1[1];
$marshalID = $param1[0];


$id		=	$this->db->get_where('assignment' , array('assignment_id' => $marshalID) )->row()->assignment_id;


	

$marshal_id = $this->db->get_where('assignment' , array('assignment_id' => $id))->row()->marshal_id;
$marshal_name = $this->db->get_where('marshal' , array('marshal_id' => $marshal_id))->row()->name;

$bay_id = $this->db->get_where('assignment' , array('assignment_id' => $id))->row()->bay_id;
$bay_name = $this->db->get_where('bays' , array('bay_id' => $bay_id))->row()->bay_name;

	
	
					$this->db->select_sum('amount');
					$this->db->from('intickets');
					$this->db->where('description', 'overstay');
					$this->db->where('marshal_id', $marshal_id);
					$this->db->where('date', $currentDateTime);
					$overcash = $this->db->get()->row()->amount;
											
					$this->db->select_sum('amount');
					$this->db->from('intickets');
					$this->db->where('description', 'park');
					$this->db->where('marshal_id', $marshal_id);
					$this->db->where('date', $currentDateTime);
					$parkcash = $this->db->get()->row()->amount;
											
					$cash = $overcash + $parkcash;
											
					$this->db->select_sum('amount');
											$this->db->from('intickets');
											$this->db->where('description', 'momo');
											$this->db->where('marshal_id', $marshal_id);
											$this->db->where('date', $currentDateTime);
											$momocash = $this->db->get()->row()->amount;
											
											$this->db->select_sum('amount');
											$this->db->from('intickets');
											$this->db->where('marshal_id', $marshal_id);
											$this->db->where('date', $currentDateTime);
											$totalcash = $this->db->get()->row()->amount;
											
											
										$query = $this->db->get( 'bays' );
                                        $bays = $query->result_array();
											
	

?>

<section class="panel">
	
	<?php echo form_open(base_url() . 'index.php?administrator/dailyrecon/adit_returns/' , array('class' => 'form-horizontal form-bordered validate','target'=>'_top'));?>
	<div class="panel-heading">
		<h4 class="panel-title" >
			<i class="fa fa-pencil-square"></i>
			<?php echo get_phrase('input_cash');?> -
			<?php echo $marshal_name; ?> -  <?php echo $currentDateTime; ?>
		</h4>
	</div>
	
	<div class="panel-body">
	
	
						<?php 
		
						
						?>
						<div class="form-group">
								<label class="col-sm-3 control-label"><?php echo get_phrase('bay');?></label>
								<div class="col-sm-7">
		<select data-plugin-selectTwo class="form-control populate" name="bay_id" onchange="class_section(this.value)" style="width: 100%">
					<option value=""><?php echo get_phrase('select_bay'); ?></option>
					<?php foreach ($bays as $rowz): ?>
					<option value="<?php echo $rowz['bay_id']; ?>" <?php if ($bay_id == $rowz[ 'bay_id']) echo 'selected'; ?>><?php echo $rowz['bay_name']; ?></option>
					<?php endforeach; ?>
				</select>
								</div>
							</div>
							
					
					<div class="form-group">
						<label class="col-md-3 control-label">
							<?php echo get_phrase('marshal');?>
						</label>
						<div class="col-md-7">
							<input type="text" readonly="true" class="form-control" value="<?php echo $marshal_name; ?>" />
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-md-3 control-label">
							<?php echo get_phrase('cash');?>
						</label>
						<div class="col-md-7">
							<input type="text" class="form-control" name="cash" value="<?php echo number_format($cash, 2, '.', ' '); ?> " readonly="readonly"/>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-md-3 control-label">
							<?php echo get_phrase('momo');?>
						</label>
						<div class="col-md-7">
							<input type="text" class="form-control" name="momo" value="<?php echo number_format($momocash, 2, '.', ' '); ?>" readonly="readonly"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">
							<?php echo get_phrase('total');?>
						</label>
						<div class="col-md-7">
						
							<input type="text" class="form-control" name="total" value="<?php echo number_format($totalcash, 2, '.', ' '); ?>" readonly="readonly"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">
							<?php echo get_phrase('date');?>
						</label>
						<div class="col-md-7">
							<input type="text" class="form-control" name='date' value="<?php echo $currentDateTime; ?>" readonly="readonly"/>
						</div>
					</div>
					
					    <input type="hidden" class="form-control" name="marshal_id" value="<?php echo $marshal_id ?>"/>
					
					
					
					<div class="form-group">
						<label class="col-md-3 control-label">
							<?php echo get_phrase('returns_value');?>
						</label>
						<div class="col-md-7">
							<input type="text" class="form-control" name="returns" value="0.00"/>
						</div>
					</div>
					
					
					
					

				</div>
	
		
	
		<footer class="panel-footer">
			<div class="row">
			<div class="col-sm-9 col-sm-offset-3">
			 <button type="submit" class="btn btn-primary"><?php echo get_phrase('commit_changes');?></button>
			</div>
			</div>
		</footer>
		
 </form>

</section> 
        
        