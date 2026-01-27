<div class="row">
	<div class="col-md-12">

		<!---CONTROL TABS START-->
		<div class="tabs">
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#list" data-toggle="tab"><i class="fa fa-list"></i> 
					<?php echo get_phrase('months_list');?>
						</a></li>
			<li>
				<a href="#add" data-toggle="tab"><i class="fa fa-plus-circle"></i>
					<?php echo get_phrase('tabular_layout');?>
						</a></li>
		</ul>
		<!---CONTROL TABS END-->

		<div class="tab-content">
		<br>
			<!--TABLE LISTING STARTS-->
			<div class="tab-pane box active" id="list">


<div class="row">
		<div class="pricing-table">
		
<?php
	$months = $this->db->get( 'inmonths' )->result_array();

	foreach ( $months as $row ):
	$month_id = $row['id'];
				?>
				
			<div class="col-lg-3">
			
			
			
			<div class="plan">
			<h3 data-appear-animation="rotateInUpRight"><?php echo $row['month'];?><span> <?php echo $row['year']; ?></span></h3>
				<ul>
				
				
				
				<li>	<!--  substr($row['time'], 0, 4); -->
				<a href="<?php echo base_url();?>index.php?admin/bymonths/<?php echo $row['month'];?>" class="btn btn-primary btn-sm" data-placement="top" data-toggle="tooltip" data-original-title="<?php echo get_phrase('view');?>">
                <i class="fa fa-eye"></i> Reconcilliations
                 </a>
				</li>
			
				</ul>
			</div>
		</div>
		<?php endforeach;?>
	</div>
</div>

</div>



<!--CREATION FORM STARTS-->
			<div class="tab-pane box" id="add" style="padding: 5px">
				<div class="box-content">
				
					<!--TABLE LISTING STARTS-->
			<div class="tab-pane box active" id="list">
				<table class="table table-bordered table-striped table-condensed mb-none" id="datatable-tabletools">
					<thead>
						<tr>
						
						<th><div>#</div></th>
						<th><div><?php echo get_phrase('month');?></div></th>
						<th><div><?php echo get_phrase('cash');?></div></th>
						<th><div><?php echo get_phrase('momo');?></div></th>
						<th><div><?php echo get_phrase('total');?></div></th>
						<th><div><?php echo get_phrase('actual');?></div></th>
						<th><div><?php echo get_phrase('variance');?></div></th>
						<th><div><?php echo get_phrase('%_loss/_gain');?></div></th>
						<th><div><?php echo get_phrase('tickets');?></div></th>	
						<th><div><?php echo get_phrase('options');?></div></th>	
						</tr>
					</thead>
					<tbody>
					
						<?php 
						
						$count = 1;
						foreach($months as $rowz):
						
							 
							$umnyaka = date('Y');									
							$startdated = $rowz['startdate'];
							$enddated   = $rowz['enddate'];
							
							
							
							$this->db->where('date >=',$startdated);
							$this->db->where('date <=',$enddated);
    						$this->db->from('intickets');
    						$tickets = $this->db->count_all_results();
							
							$this->db->where('month',$rowz['month']);
							$this->db->where('year',$umnyaka);
							$this->db->select_sum('cash');
							$query = $this->db->get('dailyrecon'); 
							$cash = $query->row()->cash;
							
							$this->db->where('month',$rowz['month']);
							$this->db->where('year',$umnyaka);
							$this->db->select_sum('momo');
							$querys = $this->db->get('dailyrecon'); 
							$momo = $querys->row()->momo;
							
							$this->db->where('month',$rowz['month']);
							$this->db->where('year',$umnyaka);
							$this->db->select_sum('total');
							$queryz = $this->db->get('dailyrecon'); 
							$total = $queryz->row()->total;
							
							$this->db->where('month',$rowz['month']);
							$this->db->where('year',$umnyaka);
							$this->db->select_sum('actual');
							$queryz = $this->db->get('dailyrecon'); 
							$actual = $queryz->row()->actual;
							
							
							$variance = $total - $actual;
							
							
						    $percentage = ($variance / $total) * 100;
							
							if($percentage > 1){
							   
							  $ciklasi = 'text-danger'; 
							    
							}else{
							    
							    $ciklasi = 'text-success'; 
							}
							
												
												
						///	endforeach;
						
						
						    
						
					
						?>
						<tr>
						<td><?php echo $count++;?></td>
							<td><?php echo $rowz['month'];?></td>
					 	   <td><?php echo number_format($cash, 2, '.', ' '); ?></td>
							<td><?php echo number_format($momo, 2, '.', ' '); ?></td>
							<td><?php echo number_format($total, 2, '.', ' '); ?></td>
							<td><?php echo number_format($actual, 2, '.', ' '); ?></td>
							<td><?php echo number_format($variance, 2, '.', ' '); ?></td>
							<td class='<?php echo $ciklasi; ?>'><?php echo number_format($percentage, 2, '.', ' '). ' %' ?></td>
							<td><?php echo $tickets;?></td>
							<td>
							<a href="<?php echo base_url();?>index.php?admin/bymonths/<?php echo $rowz['month'];?>" class="btn btn-primary btn-sm" data-placement="top" data-toggle="tooltip" data-original-title="<?php echo get_phrase('view');?>">
                <i class="fa fa-eye"></i> Reconcilliations
                 </a>
							</td>
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
				
		
				
				</div>
			</div>
			


	
			