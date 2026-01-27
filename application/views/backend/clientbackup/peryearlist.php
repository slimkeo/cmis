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
    
   // $year = date('Y');
    
$this->db->select('*');
$this->db->from('inmonths');
$this->db->group_by('year');
$result = $this->db->get()->result_array();

	foreach ( $result as $row ):
	$year = $row['year'];
	
		$this->db->where('year',$row['year']);
		$this->db->select_sum('actual');
		$queryz = $this->db->get('dailyrecon'); 
		$actuals = $queryz->row()->actual;

?>
				
			<div class="col-lg-3">
			
			
			
			<div class="plan">
			<h3 data-appear-animation="rotateInUpRight"><?php echo 'E'.number_format($actuals, 2, '.', ' '); ?><span> <?php echo  $year; ?></span></h3>
				<ul>
				
				
				
				<li>	<!--  substr($row['time'], 0, 4); -->
				<a href="<?php echo base_url();?>index.php?admin/byyear/<?php echo $row['year'];?>" class="btn btn-default btn-xs" data-placement="top" data-toggle="tooltip" data-original-title="<?php echo get_phrase('view');?>">
                <i class="fa fa-spinner"></i> Summary Report
                 </a>
				</li>
				
					<li>	<!--  substr($row['time'], 0, 4); -->
				<a href="<?php echo base_url();?>index.php?admin/reportperyear/<?php echo $row['year'];?>" class="btn btn-default btn-xs" data-placement="top" data-toggle="tooltip" data-original-title="<?php echo get_phrase('view');?>">
                <i class="fa fa-table"></i> Tabular Report 
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
						<th><div><?php echo get_phrase('year');?></div></th>
						<th><div><?php echo get_phrase('cash');?></div></th>
						<th><div><?php echo get_phrase('momo');?></div></th>
						<th><div><?php echo get_phrase('total');?></div></th>
						<th><div><?php echo get_phrase('actual');?></div></th>
						<th><div><?php echo get_phrase('variance');?></div></th>
						<th><div><?php echo get_phrase('%_loss/_gain');?></div></th>
						<th><div><?php echo get_phrase('options');?></div></th>	
						</tr>
					</thead>
					<tbody>
					
						<?php 
						
						$count = 1;
						foreach($result as $rowz):
						
							 
															
							$startdated = $rowz['startdate'];
							$enddated   = $rowz['enddate'];
							
							
							
							$this->db->where('date >=',$startdated);
							$this->db->where('date <=',$enddated);
    						$this->db->from('intickets');
    						$tickets = $this->db->count_all_results();
							
						
							$this->db->where('year',$rowz['year']);
							$this->db->select_sum('cash');
							$query = $this->db->get('dailyrecon'); 
							$cash = $query->row()->cash;
							
						
							$this->db->where('year',$rowz['year']);
							$this->db->select_sum('momo');
							$querys = $this->db->get('dailyrecon'); 
							$momo = $querys->row()->momo;
							
							
							$this->db->where('year',$rowz['year']);
							$this->db->select_sum('total');
							$queryz = $this->db->get('dailyrecon'); 
							$total = $queryz->row()->total;
							
						
							$this->db->where('year',$rowz['year']);
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
							<td><?php echo $rowz['year'];?></td>
					 	   <td><?php echo number_format($cash, 2, '.', ' '); ?></td>
							<td><?php echo number_format($momo, 2, '.', ' '); ?></td>
							<td><?php echo number_format($total, 2, '.', ' '); ?></td>
							<td><?php echo number_format($actual, 2, '.', ' '); ?></td>
							<td><?php echo number_format($variance, 2, '.', ' '); ?></td>
							<td class='<?php echo $ciklasi; ?>'><?php echo number_format($percentage, 2, '.', ' '). ' %' ?></td>
							
							<td>
							<a href="<?php echo base_url();?>index.php?admin/reportpermonth/<?php echo $rowz['year'];?>" class="btn btn-primary btn-sm" data-placement="top" data-toggle="tooltip" data-original-title="<?php echo get_phrase('view');?>">
                <i class="fa fa-eye"></i> Summary Report
                 </a>
							</td>
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
				
		
				
				</div>
			</div>
			


	
			