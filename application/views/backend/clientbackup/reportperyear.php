<div class="row">
	<div class="col-md-12">
	    
	    <?php
	    
	    
	    
			$this->db->select("*");
            $this->db->where('year',$year);
            $this->db->from('inmonths');
            $q = $this->db->get();
            $incount = $q->result_array();
	    
	    	foreach ($incount as $moh): 
												
			$startdated = $moh['startdate'];
			$enddated   = $moh['enddate'];
								
								
			endforeach;
	    
	    
	  
	    
	    ?>


		<!---CONTROL TABS START-->
		<div class="tabs">
		<ul class="nav nav-tabs">
				
			<?php
			
		
			
			 echo '<li class="active">';
			   echo '<a href="#list" data-toggle="tab"><i class="fa fa-calendar"></i>';
			   echo ' '.get_phrase('yearly_performance').' - '.$year;
			 
			   echo '</a></li>';
	
			
			
			
			?>
		</ul>
		<!---CONTROL TABS END-->

		<div class="tab-content"><br />







		
			
				<!--TABLE LISTING STARTS-->
			<div class="tab-pane box active" id="list">
				<table class="table table-bordered table-striped table-condensed mb-none" id="datatable-tabletools">
					<thead>
						<tr>
						<th></th>
							
						<th><div><?php echo get_phrase('marshal');?></div></th>
						<th><div><?php echo get_phrase('cash');?></div></th>
						<th><div><?php echo get_phrase('momo');?></div></th>
						<th><div><?php echo get_phrase('total');?></div></th>
						<th><div><?php echo get_phrase('actual');?></div></th>
						<th><div><?php echo get_phrase('variance');?></div></th>
						<th><div><?php echo get_phrase('%_loss/_gain');?></div></th>
						<!--<th><div><?php echo get_phrase('tickets');?></div></th>	-->
						</tr>
					</thead>
					<tbody>
					
					
					
						<tr>
						
							
			            <?php
			            
			            $count = 1;
			            $umnyaka = date('Y');
		                $assignment = $this->db->get_where('assignment')->result_array();
							
							foreach($assignment as $row):
							    
							    
							$marshal_id = $row['marshal_id'];
							
							
							$this->db->where('date >=',$startdated);
							$this->db->where('date <=',$enddated);
							$this->db->where('marshal_id',$marshal_id);
    						$this->db->from('intickets');
    						$tickets = $this->db->count_all_results();
							     
							//$this->db->where('month',$month);
							$this->db->where('year',$year);
							$this->db->where('marshal_id',$marshal_id);
							$this->db->select_sum('cash');
							$query = $this->db->get('dailyrecons'); 
							$cash = $query->row()->cash;
							
							//$this->db->where('month',$month);
							$this->db->where('year',$year);
							$this->db->where('marshal_id',$marshal_id);	
							$this->db->select_sum('momo');
							$querys = $this->db->get('dailyrecons'); 
							$momo = $querys->row()->momo;
							
							//$this->db->where('month',$month);
							$this->db->where('year',$year);
							$this->db->where('marshal_id',$marshal_id);
							$this->db->select_sum('total');
							$queryz = $this->db->get('dailyrecons'); 
							$total = $queryz->row()->total;
							
							//$this->db->where('month',$month);
							$this->db->where('year',$year);
							$this->db->where('marshal_id',$marshal_id);
							$this->db->select_sum('actual');
							$queryz = $this->db->get('dailyrecons'); 
							$actual = $queryz->row()->actual;
							
						
							
							$variance = $total - $actual;
							
							
						    $percentage = ($variance / $total) * 100;
							
							if($percentage > 1){
							   
							  $ciklasi = 'text-danger'; 
							    
							}else{
							    
							    $ciklasi = 'text-success'; 
							}
							
							
							
							?>
							
							<td><?php echo $count++;?></td> 
							<td>	
							<?php echo $this->db->get_where('marshal' , array('marshal_id' => $row['marshal_id']))->row()->name;?>
							</td>
					 	   <td><?php echo number_format($cash, 2, '.', ' '); ?></td>
							<td><?php echo number_format($momo, 2, '.', ' '); ?></td>
							<td><?php echo number_format($total, 2, '.', ' '); ?></td>
							<td><?php echo number_format($actual, 2, '.', ' '); ?></td>
							<td><?php echo number_format($variance, 2, '.', ' '); ?></td>
							<td class='<?php echo $ciklasi; ?>'><?php echo number_format($percentage, 2, '.', ' '). ' %' ?></td>
							
						
						<!--	<td><?php echo $tickets;?></td>-->
						
						</tr>
						
						<?php endforeach; ?>
					
					</tbody>
					
		</table>
				
			</div>
			<!--TABLE LISTING ENDS-->
			
			


   </div>
</div>
