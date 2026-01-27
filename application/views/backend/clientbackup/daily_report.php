<div class="row">
	<div class="col-md-12">
	    
	    
	    <?php 
	    
	  
	    
$currentDateTime = date('Y-m-d');
/*	$today=date_create(date('Y-m-d'));
	$prev_date=date_sub($today,date_interval_create_from_date_string("1 days"));
	$currentDateTime= date_format($prev_date,'Y-m-d');*/
	    

	    ?>

		<!---CONTROL TABS START-->
		<div class="tabs">
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#list" data-toggle="tab"><i class="fa fa-calendar"></i> 
					<?php echo get_phrase('daily_recon');?>
					-
					<?php   
  							echo $currentDateTime;
					?>
						</a></li>
			
		</ul>
		<!---CONTROL TABS END-->

		<div class="tab-content"><br />





<?php 

$assignment_id =	$this->db->get('assignment')->row()->assignment_id;

$marshal_id = $this->db->get_where('assignment' , array('assignment_id' => $assignment_id))->row()->marshal_id;
$marshal_name = $this->db->get_where('marshal' , array('marshal_id' => $marshal_id))->row()->name;

$bay_id = $this->db->get_where('assignment' , array('assignment_id' => $assignment_id))->row()->bay_id;
$bay_name = $this->db->get_where('bays' , array('bay_id' => $bay_id))->row()->bay_name;

$month = date('M');
$week = date('W');

				


 $dailyrecons = $this->db->get_where('dailyrecon', array('date' => $currentDateTime ))->result_array();
		
		foreach($dailyrecons as $res):
		
		$totals = $totals + $res['total'];
		$momos = $momos + $res['momo'];
		$actuals = $actuals + $res['actual'];
		$variances = $variances + $res['variance'];
		endforeach;			


?>

			<!--TABLE LISTING STARTS-->
			<div class="tab-pane box active" id="list">
				<table class="table table-bordered table-striped table-condensed mb-none" id="datatable-tabletools">
					<thead>
						<tr>
						<th></th>
							
							<th><div><?php echo get_phrase('marshal');?></div></th>
							<th><div><?php echo get_phrase('cash');?></div></th>
							<th><div><?php echo get_phrase('card_topup');?></div></th>
							<th><div><?php echo get_phrase('cashless');?></div></th>
							<th><div><?php echo get_phrase('momo');?></div></th>
							<th><div><?php echo get_phrase('airtime');?></div></th>							
							<th><div><?php echo get_phrase('total');?></div></th>
							<th><div><?php echo get_phrase('actual');?></div></th>
							<th><div><?php echo get_phrase('variance');?></div></th>
							<th><div><?php echo get_phrase('bayset');?></div></th>
						</tr>
					</thead>
					<tbody>
					
					
					<?php 
					
						$count = 1;
						
						 $assignment = $this->db->get_where('assignment')->result_array();
                                foreach($assignment as $row):								
								
											$id = $row['marshal_id'];						
 $dailyartime = file_get_contents('http://nomakunini.com/airtime.php?option=bydate&&reportdate=2020-11-19');

$airtime = json_decode($dailyartime); 


											
											$this->db->select_sum('amount');
											$this->db->from('intickets');
											$this->db->where('description', 'overstay');
											$this->db->where('marshal_id', $id);
											$this->db->where('date', $currentDateTime);
											$overcash = $this->db->get()->row()->amount;

											$this->db->select_sum('amount');
											$this->db->from('intickets');
											$this->db->where('description', 'clamp');
											$this->db->where('marshal_id', $id);
											$this->db->where('date', $currentDateTime);
											$clamp = $this->db->get()->row()->amount;
											
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
											
											$cash = $overcash + $parkcash+$clamp;
											
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
											
						if(($totalcash-($topup+$cashless))>200 && $currentDateTime >'2019-08-06'  ){
						    

	                    
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
											
											
											$this->db->select_sum('amount');
											$this->db->from('intickets');
											$this->db->where('date',$currentDateTime);
											$sumcash = $this->db->get()->row()->amount;
											
                          $query=$this->db->query("SELECT SUM(`amount`) AS `total`, `marshal_id` FROM `intickets` where `date`='".$currentDateTime."' GROUP BY `marshal_id` HAVING SUM(`amount`)>200");
                    
                          $merchaaaant=$query->result_array();
											

                            if($sumcash > 3000 && $currentDateTime >'2019-08-06'){
                                $ff=sizeof($merchaaaant)*38;
                                $sumcash=$sumcash-$ff;
                            } 
											
											
							
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
							<td><?php echo number_format($airtime, 2, '.', ' '); ?></td>							
							<td><?php echo number_format($totalcash, 2, '.', ' '); ?></td>
							<td><?php echo number_format($actualcash, 2, '.', ' '); ?></td>
							<td><?php echo number_format($variance, 2, '.', ' '); ?></td>
							
							<td>
							<?php echo $this->db->get_where('bays' , array('bay_id' => $row['bay_id']))->row()->bay_name;?>
							</td>
						</tr>
						<?php endforeach;?>
					</tbody>
					
				
					
					
					
				</table>
				
				
							
			<div class="row">
			
									
	<div class="col-md-3" data-appear-animation="bounceInUp">
	
				<!--Calculating Totals-->
					
					<?php

					
					?>
					
		
		<section class="panel panel-featured-left panel-featured-primary">
			<div class="panel-body">
				<div class="widget-summary widget-summary-sm">
					<div class="widget-summary-col widget-summary-col-icon">
						<div class="summary-icon bg-primary">
							<i class="fa fa-desktop"></i>
						</div>
					</div>
					<div class="widget-summary-col">
						<div class="summary">
							<h4 class="title"><?php echo get_phrase('system_cash');?></h4>
							<div class="info">
								<span class="text-success text-uppercase">E</span>
								<strong class="amount"><?php echo number_format($sumcash, 2, '.', ' ') ?></strong>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
	
	<div class="col-md-3" data-appear-animation="bounceInUp">
	
				<!--Calculating Totals-->
					
					<?php

					
					?>
					
		
		<section class="panel panel-featured-left panel-featured-primary">
			<div class="panel-body">
				<div class="widget-summary widget-summary-sm">
					<div class="widget-summary-col widget-summary-col-icon">
						<div class="summary-icon bg-primary">
							<i class="fa fa-desktop"></i>
						</div>
					</div>
					<div class="widget-summary-col">
						<div class="summary">
							<h4 class="title"><?php echo get_phrase('system_cash');?></h4>
							<div class="info">
								<span class="text-success text-uppercase">E</span>
								<strong class="amount"><?php echo number_format($sumcash, 2, '.', ' ') ?></strong>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>	
	
		<div class="col-md-3" data-appear-animation="bounceInUp">
		
		<section class="panel panel-featured-left panel-featured-success">
			<div class="panel-body">
				<div class="widget-summary widget-summary-sm">
					<div class="widget-summary-col widget-summary-col-icon">
						<div class="summary-icon bg-success">
							<i class="fa fa-money"></i>
						</div>
					</div>
					<div class="widget-summary-col">
						<div class="summary">
							<h4 class="title"><?php echo get_phrase('actual_cash');?></h4>
							<div class="info">
								<span class="text-success text-uppercase">E</span>
								<strong class="amount"><?php echo number_format($actuals, 2, '.', ' ') ?></strong>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
	
		<div class="col-md-3" data-appear-animation="bounceInUp">
		
		<section class="panel panel-featured-left panel-featured-danger">
			<div class="panel-body">
				<div class="widget-summary widget-summary-sm">
					<div class="widget-summary-col widget-summary-col-icon">
						<div class="summary-icon bg-danger">
							<i class="fa fa-exchange"></i>
						</div>
					</div>
					<div class="widget-summary-col">
						<div class="summary">
							<h4 class="title"><?php echo get_phrase('variance_cash');?></h4>
							<div class="info">
								<span class="text-success text-uppercase">E</span>
								<strong class="amount"><?php echo number_format($variances, 2, '.', ' ') ?></strong>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
	
	</div>
				
				
				
			</div>
			<!--TABLE LISTING ENDS-->

   </div>
</div>
