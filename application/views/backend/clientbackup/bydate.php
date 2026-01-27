<section class="panel">



<div class="panel-body">
	<div class="row">
		<div class="col-md-4"></div>
		<div class="col-md-4">
			<div class="form_group">
				<label class="control-label mb-xs"><?php echo get_phrase('Select Date');?> <span class="required">*</span></label>
	
				
				<?php
		$query = $this->db->get( 'dates' );
		$dates = $query->result_array();
		?>
				<select data-plugin-selectTwo class="form-control populate" id="date" name="date" onchange="class_section(this.value)" style="width: 100%">
					
					
					<option value=""><?php echo get_phrase('select_date'); ?></option>
					<?php foreach ($dates as $row): ?>
					<option value="<?php echo $row['date']; ?>" <?php if ($date == $row[ 'date']) echo 'selected'; ?> ><?php echo $row['date']; ?></option>
					<?php endforeach; ?>
				</select>
				
				
				
			</div>
		</div>


	<br><br>

		<?php
		$query = $this->db->get_where( 'dates', array( 'date' => $date ) );
		if ( $query->num_rows() > 0 && $date != '' ):
			$capture = $query->result_array();
		foreach ( $capture as $row ):
		    
		    $assignment_id =	$this->db->get('assignment')->row()->assignment_id;

$marshal_id = $this->db->get_where('assignment' , array('assignment_id' => $assignment_id))->row()->marshal_id;
$marshal_name = $this->db->get_where('marshal' , array('marshal_id' => $marshal_id))->row()->name;

$bay_id = $this->db->get_where('assignment' , array('assignment_id' => $assignment_id))->row()->bay_id;
$bay_name = $this->db->get_where('bays' , array('bay_id' => $bay_id))->row()->bay_name;
		
	
			?>
	

<div class="row">
	<div class="col-md-12">
	
	

		<!---CONTROL TABS START-->
		<div class="tabs">
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#list" data-toggle="tab"><i class="fa fa-list"></i> 
					<?php echo get_phrase('report_by_date');?>
					
					<?php - 
  $currentDateTime = $row['date'];
  echo $currentDateTime;
 ?>
						</a></li>
						
					
					
			
		</ul>
		<!---CONTROL TABS END-->

		<div class="tab-content">
		
			
		
		<br>
			<!--TABLE LISTING STARTS-->
			<div class="tab-pane box active" id="list">
					<table class="table table-bordered table-striped table-condensed mb-none" id="datatable-tabletools">
					<thead>
						<tr>
						<th></th>
							
							<th><div><?php echo get_phrase('marshal');?></div></th>
							<th><div><?php echo get_phrase('cash');?></div></th>
							<th><div><?php echo get_phrase('card_top_up');?></div></th>
							<th><div><?php echo get_phrase('cashless');?></div></th>
							<th><div><?php echo get_phrase('momo');?></div></th>
							<th><div><?php echo get_phrase('total');?></div></th>
							<th><div><?php echo get_phrase('actual');?></div></th>
							<th><div><?php echo get_phrase('variance');?></div></th>
							<th><div><?php echo get_phrase('action');?></div></th>
						</tr>
					</thead>
					<tbody>
					
					
					<?php 
					
						$count = 1;
						
						 $assignment = $this->db->get_where('assignment')->result_array();
                                foreach($assignment as $row):								
								
											$id = $row['marshal_id'];								
											$this->db->select_sum('amount');
											$this->db->from('intickets');
											$this->db->where('description', 'overstay');
											$this->db->where('marshal_id', $id);
											$this->db->where('date', $currentDateTime);
											$overcash = $this->db->get()->row()->amount;
											
											$this->db->select_sum('amount');
											$this->db->from('intickets');
											$this->db->where('description', 'park');
											$this->db->where('marshal_id', $id);
											$this->db->where('date', $currentDateTime);
											$parkcash = $this->db->get()->row()->amount;
											
								if($parkcash>200 && $currentDateTime >'2019-08-06'){
											 $parkcash=$parkcash-38; 
	
						  $exd =	$this->db->get('ex_dates')->result_array();
						    
						       foreach($exd as $rowr){
						            
						            if($rowr['date']==$currentDateTime){
						         	 $parkcash=$parkcash+38;
						         	 break;
						            }
						        }
	
	
	
						     	}
											
											$cash = $overcash + $parkcash;
											
											$this->db->select_sum('amount');
											$this->db->from('intickets');
											$this->db->where('description', 'momo');
											$this->db->where('marshal_id', $id);
											$this->db->where('date', $currentDateTime);
											$momocash = $this->db->get()->row()->amount;
											
																					$this->db->select_sum('amount');
											$this->db->from('intickets');
											$this->db->where('description', 'topup');
											$this->db->where('marshal_id', $id);
											$this->db->where('date', $currentDateTime);
											$topup = $this->db->get()->row()->amount;
											
                                             $this->db->select_sum('amount');
											$this->db->from('intickets');
											$this->db->where('description', 'cashless');
											$this->db->where('marshal_id', $id);
											$this->db->where('date', $currentDateTime);
											$cashless = $this->db->get()->row()->amount;												
											
											$this->db->select_sum('amount');
											$this->db->from('intickets');
											$this->db->where('marshal_id', $id);
											$this->db->where('date', $currentDateTime);
											$totalcash = $this->db->get()->row()->amount;
											
								if(($totalcash-($topup+$cashless))>200 && $currentDateTime >'2019-08-06'){
											 $totalcash=$totalcash-38; 
									
						  $exd =	$this->db->get('ex_dates')->result_array();
						    
						       foreach($exd as $rowr){
						            
						            if($rowr['date']==$currentDateTime){
						         	 $totalcash=$totalcash+38;
						         	 break;
						            }
						        }
	
	
	
						     	}
											
											//actual cash
											$actualcash = $this->db->get_where('dailyrecon' , array('marshal_id' => $row['marshal_id'], 'date' => $currentDateTime))->row()->actual;
											
											
											//variance 
											$variance = $this->db->get_where('dailyrecon' , array('marshal_id' => $row['marshal_id'], 'date' => $currentDateTime))->row()->variance;
											
							
						?>
						<tr>
							<th><?php echo $count++; ?></th>
							
							<td>	
							<?php echo $this->db->get_where('marshal' , array('marshal_id' => $row['marshal_id']))->row()->name;?>
							</td>
					 	   <td><?php echo number_format($parkcash, 2, '.', ' '); ?></td>
							<td><?php echo number_format($topup, 2, '.', ' '); ?></td>	
							<td><?php echo number_format($cashless, 2, '.', ' '); ?></td>
							<td><?php echo number_format($momocash, 2, '.', ' '); ?></td>
							<td><?php echo number_format($totalcash, 2, '.', ' '); ?></td>
							<td><?php echo number_format($actualcash, 2, '.', ' '); ?></td>
							<td><?php echo number_format($variance, 2, '.', ' '); ?></td>
							
							<td><a href="#" class="btn btn-primary btn-sm" data-placement="top" data-toggle="tooltip" data-original-title="<?php echo get_phrase('input_actual');?>" onClick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_money_input/<?php echo $row['assignment_id'].'_'.$date;?>');">
								<i class="fa fa-user-plus"></i>
								</a></td>
						</tr>
						<?php endforeach;?>
					</tbody>
					
		</table>
			</div>
			<!--TABLE LISTING ENDS-->

		
   </div>
</div>

		<?php endforeach;?>
		<?php endif;?>
	</div>
</section>

<script type="text/javascript">
	function class_section( date ) {
		window.location.href = '<?php echo base_url(); ?>index.php?accountant/bydate/' + date;
	}
</script>