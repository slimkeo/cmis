<?php 


if($year==''){
    $year=date('Y');
}



               $y=date('Y');


?>
<div class="col-md-12">
    	<div class="row">
		<div class="col-md-4"></div>
		<div class="col-md-4">
			<div class="form_group">
				<label class="control-label mb-xs"><?php echo get_phrase('Select Year');?> <span class="required">*</span></label>
	
				
				<select data-plugin-selectTwo class="form-control populate" id="date" name="date" onchange="class_section(this.value)" style="width: 100%">
					
					
					<option value=""><?php echo get_phrase('select_year'); ?></option>
					<?php for ($i = $y; $i >= $y-3; $i--){ ?>
					<option value="<?php echo $i; ?>" <?php if ($year == $i) echo 'selected'; ?> ><?php echo $i; ?></option>
					<?php } ?>
				</select>
				
				
				
			</div>
		</div>


			</div>
			<br>
<br>
</div>



	<?php


 $dailyartime = file_get_contents('http://nomakunini.com/airtime.php?option=daily_report');

$airtime = json_decode($dailyartime); 
$airtime = 0; 
								
		           // $year = date('Y');
		            $year = $year;
		        	$this->db->where('year',$year);
					$this->db->select_sum('actual');
					$que = $this->db->get('dailyrecon'); 
					$totalactual = $que->row()->actual;
				
					$this->db->where('year',$year);
					$this->db->select_sum('total');
					$que2 = $this->db->get('dailyrecon'); 
					$totalsystem = $que2->row()->total;
								
					$totalvariance = $totalsystem - $totalactual;
				
							
			$dayincome = $this->db->get_where( 'intickets', array('date' => date('Y-m-d'),'cashless' => 0,'description !=' => "topup"))->result_array();
			$todayincome = 0;
			foreach ( $dayincome as $row ):
			$todayincome = $todayincome + $row[ 'amount' ] ;
			endforeach;					


			$topupincome = $this->db->get_where( 'intickets', array('date' => date('Y-m-d'),'description ' => 'topup') )->result_array();
			$topup = 0;
			foreach ( $topupincome as $row1 ):
			$topup = $topup + $row1[ 'amount' ] ;
			endforeach;	
			
			$cashlessincomee = $this->db->get_where( 'intickets', array('date' => date('Y-m-d'),'description' => 'cashless') )->result_array();
			$cashlessincome = 0;
			foreach ( $cashlessincomee as $row11 ):
			$cashlessincome = $cashlessincome + $row11[ 'amount' ] ;
			endforeach;			
			
			                          $query=$this->db->query("SELECT SUM(`amount`) AS `total`, `marshal_id` FROM `intickets` where `date`='".date('Y-m-d')."' AND `description`!='topup' AND `cashless`='0' GROUP BY `marshal_id` HAVING SUM(`amount`)>200");
                    
                          $merchaaaant=$query->result_array();
											

                            if($todayincome > 3000 && date('Y-m-d') >'2019-08-06'){
                                $ff=sizeof($merchaaaant)*38;
                                $todayincome=$todayincome-$ff;
                            } 	
                            
                            $sub_total=$todayincome+$cashlessincome+$topup+$airtime;
								  
	?>
		<div class="col-md-3" data-appear-animation="bounceInUp">
		
		<section class="panel panel-featured-left panel-featured-primary">
			<div class="panel-body">
				<div class="widget-summary widget-summary-sm">
					<div class="widget-summary-col widget-summary-col-icon">
						<div class="summary-icon bg-primary">
							<i class="fa fa-car"></i>
						</div>
					</div>
					<div class="widget-summary-col">
						<div class="summary">
							<h4 class="title"><?php echo get_phrase('todays_park_cash');?></h4>
							<div class="info">
								
								<strong class="amount"><?php echo $todayincome; ?></strong>
								<span class="text-primary text-uppercase"><?php echo date('Y-m-d');?></span>
							</div>
						</div>
	
					</div>
				</div>
			</div>
		</section>
	</div>
		<div class="col-md-3" data-appear-animation="bounceInUp">
		
		<section class="panel panel-featured-left panel-featured-primary">
			<div class="panel-body">
				<div class="widget-summary widget-summary-sm">
					<div class="widget-summary-col widget-summary-col-icon">
						<div class="summary-icon bg-primary">
							<i class="fa fa-car"></i>
						</div>
					</div>
					<div class="widget-summary-col">
						<div class="summary">
							<h4 class="title"><?php echo get_phrase('todays_card_top_up');?></h4>
							<div class="info">
								
								<strong class="amount"><?php echo $topup; ?></strong>
								<span class="text-primary text-uppercase"><?php echo date('Y-m-d');?></span>
							</div>
						</div>
	
					</div>
				</div>
			</div>
		</section>
	</div>	

		<div class="col-md-3" data-appear-animation="bounceInUp">
		
		<section class="panel panel-featured-left panel-featured-primary">
			<div class="panel-body">
				<div class="widget-summary widget-summary-sm">
					<div class="widget-summary-col widget-summary-col-icon">
						<div class="summary-icon bg-primary">
							<i class="fa fa-car"></i>
						</div>
					</div>
					<div class="widget-summary-col">
						<div class="summary">
							<h4 class="title"><?php echo get_phrase('todays_cashless_transactions');?></h4>
							<div class="info">
								
								<strong class="amount"><?php echo $cashlessincome; ?></strong>
								<span class="text-primary text-uppercase"><?php echo date('Y-m-d');?></span>
							</div>
						</div>
	
					</div>
				</div>
			</div>
		</section>
	</div>	
		<div class="col-md-3" data-appear-animation="bounceInUp">
		
		<section class="panel panel-featured-left panel-featured-primary">
			<div class="panel-body">
				<div class="widget-summary widget-summary-sm">
					<div class="widget-summary-col widget-summary-col-icon">
						<div class="summary-icon bg-primary">
							<i class="fa fa-car"></i>
						</div>
					</div>
					<div class="widget-summary-col">
						<div class="summary">
							<h4 class="title"><?php echo get_phrase('airtime');?></h4>
							<div class="info">
								
								<strong class="amount"><?php echo $airtime; ?></strong>
								<span class="text-primary text-uppercase"><?php echo date('Y-m-d');?></span>
							</div>
						</div>
	
					</div>
				</div>
			</div>
		</section>
	</div>
		<div class="col-md-3" data-appear-animation="bounceInUp">
		
		<section class="panel panel-featured-left panel-featured-primary">
			<div class="panel-body">
				<div class="widget-summary widget-summary-sm">
					<div class="widget-summary-col widget-summary-col-icon">
						<div class="summary-icon bg-primary">
							<i class="fa fa-car"></i>
						</div>
					</div>
					<div class="widget-summary-col">
						<div class="summary">
							<h4 class="title"><?php echo get_phrase('sub_total');?></h4>
							<div class="info">
								
								<strong class="amount"><?php echo $sub_total; ?></strong>
								<span class="text-primary text-uppercase"><?php echo date('Y-m-d');?></span>
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
							<i class="fa fa-desktop"></i>
						</div>
					</div>
					<div class="widget-summary-col">
						<div class="summary">
							<h6 class="title" style="font-size:11px;"><?php echo get_phrase('total_system');?></h6>
							<div class="info">
								<span class="text-success text-uppercase">E</span>
								<strong class="amount" ><?php echo number_format($totalsystem, 2, '.', ' ') ?></strong>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
		<div class="col-md-3" data-appear-animation="bounceInUp">
		
		<section class="panel panel-featured-left panel-featured-info">
			<div class="panel-body">
				<div class="widget-summary widget-summary-sm">
					<div class="widget-summary-col widget-summary-col-icon">
						<div class="summary-icon bg-info">
							<i class="fa fa-database"></i>
						</div>
					</div>
					<div class="widget-summary-col">
						<div class="summary">
							<h4 class="title" ><?php echo get_phrase('total_actual');?></h4>
							<div class="info">
								<span class="text-info text-uppercase">E</span>
								<strong class="amount"> <?php echo number_format($totalactual, 2, '.', ' ') ?></strong>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
	
		<div class="col-md-3" data-appear-animation="bounceInUp">
		
		<section class="panel panel-featured-left panel-featured-secondary">
			<div class="panel-body">
				<div class="widget-summary widget-summary-sm">
					<div class="widget-summary-col widget-summary-col-icon">
						<div class="summary-icon bg-secondary">
							<i class="fa fa-arrow-down"></i>
						</div>
					</div>
					<div class="widget-summary-col">
						<div class="summary">
							<h4 class="title"><?php echo get_phrase('total_variance');?></h4>
							<div class="info">
								<span class="text-secondary text-uppercase">E</span>
								<strong class="amount"><?php echo number_format($totalvariance, 2, '.', ' ') ?></strong>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>


	<div class="col-md-6">
			<section class="panel">
				<header class="panel-heading"><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
					<div class="panel-actions">
						<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
						<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
					</div>
						
		<h2 class="panel-title">Perfomance Report - <?php 
		$marshal =$this->db->get_where('marshal' , array('marshal_id' =>  $marshal_id))->row()->name; 
		echo $marshal;?>
		</h2>	
		
		<?php
		$pieces = explode(" ", $marshal);
		?>
		</header>
									
								<div class="panel-body">
									<div class="row">
										<div class="col-lg-12" data-appear-animation="fadeInRightBig">
											<!-- Morris: Line -->
										<div class="chart chart-md" id="morrisLine"></div>
										<script type="text/javascript">
						
											var morrisLineData = [
											
											<?php
								
										$year = $year;
										$this->db->select("*");
                                		$this->db->where('year',$year);
                                	    $this->db->from('inmonths');
                                	    $q = $this->db->get();
                                	    $incount = $q->result_array();
										
											
								foreach ($incount as $moh): 
												
								$startdates = $moh['startdate'];
								$enddates   = $moh['enddate'];
									
								
								
								$this->db->where('date >=',$startdates);
								$this->db->where('date <=',$enddates);
								$this->db->where('year',$year);
								$this->db->select_sum('actual');
								$querya = $this->db->get('dailyrecons'); 
								$actuals1 = $querya->row()->actual;
												
								$this->db->where('date >=',$startdates);
								$this->db->where('date <=',$enddates);
								$this->db->where('year',$year);
								$this->db->select_sum('total');
								$query2 = $this->db->get('dailyrecons'); 
								$totals1 = $query2->row()->total;
								
								
								if(!empty($actuals1)){
								$actualy = $actuals1;
								}else{
								$actualy = 0;
								}
								
								if(!empty($totals1)){
								$totally = $totals1;
								}else{
								$totally = 0;
								}
												
									$lilanga = $moh['startdate'];			
								  
							    ?>
											
											
											{
												y: "<?php echo $lilanga; ?>",
												a:  <?php echo $totally ?> ,
												b: <?php echo $actualy ?>
											}, 
											<?php endforeach; ?>
											];
						
											// See: assets/javascripts/ui-elements/examples.charts.js for more settings.
						
										</script>
					
													<!-- Flot: Sales Porto Wordpress -->
												
												</div>
					</section>
					
					<hr class="solid short mt-lg">
					
</div>
											
		
	<div class="col-md-6">
			<section class="panel">
				<header class="panel-heading">
					<div class="panel-actions">
						<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
						<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
					</div>
						
		<h2 class="panel-title">Perfomance Report - <?php 
		$marshal =$this->db->get_where('marshal' , array('marshal_id' =>  $marshal_id))->row()->name; 
		echo $marshal;?>
		</h2>	
		
		<?php
		$pieces = explode(" ", $marshal);
		?>
		</header>
						
						<div class="panel-body">
						
							<!-- Morris: Donut -->
										<div class="chart chart-md" id="morrisDonut"></div>
										<script type="text/javascript">
						
											var morrisDonutData = [
											
											
											<?php
										
								

								
								
								foreach ($incount as $inyanga): 
								
								$inyanga1 = $inyanga['month'];
								$mstartdates = $inyanga['startdate'];
								$menddates   = $inyanga['enddate'];
								
								$this->db->where('date >=',$mstartdates);
								$this->db->where('date <=',$menddates);
								$this->db->where('year',$year);
								//$this->db->where('month',$inyanga1);
								$this->db->select_sum('actual');
								$querya1 = $this->db->get('dailyrecon'); 
								$actual8 = $querya1->row()->actual;
								
								if(!empty($actual8)){
								$actualm =  number_format($actual8, 2, '.', '');
								}else{
								$actualm = 0;
								}
								
										
								?>						
											
											{
												label: "<?php echo $inyanga1; ?>",
												value: "<?php echo $actualm ?>"
											}, 
											
											<?php endforeach; ?>
											];
						
											// See: assets/javascripts/ui-elements/examples.charts.js for more settings.
						
										</script>
						
						</div>
					</section>
					
					<hr class="solid short mt-lg">
					
</div>
                        <div class="row">           
                        
    
                                <div class="col-md-6 col-lg-12 col-xl-6" data-appear-animation="bounceIn">
        <div class="row">
            <div class="col-md-12 col-lg-6 col-xl-6">
                <section class="panel panel-featured-left panel-featured-primary">
                    <div class="panel-body">
                        <div class="widget-summary">
                            <div class="widget-summary-col widget-summary-col-icon">
                                <div class="summary-icon bg-primary">
                                    <i class="fa fa-ticket"></i>
                                </div>
                            </div>
                            
                            
                            <?php
                            
                            $allTickets = $this->db->count_all('tickets');
                            
                            
                            ?>
                            <div class="widget-summary-col">
                                <div class="summary">
                                    <h4 class="title">
                                        <?php echo get_phrase('tickets');?>
                                    </h4>
                                    <div class="info">
                                        <strong class="amount">
                                        <?php echo 264776 + $allTickets ?>
                                        </strong>
                                    </div>
                                </div>
                                <div class="summary-footer">
                                    <span class="text-muted text-uppercase">All Tickets</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-md-12 col-lg-6 col-xl-6" data-appear-animation="bounceIn">
                <section class="panel panel-featured-left panel-featured-primary">
                    <div class="panel-body">
                        <div class="widget-summary">
                            <div class="widget-summary-col widget-summary-col-icon">
                                <div class="summary-icon bg-primary">
                                    <i class="fa fa-users"></i>
                                </div>
                            </div>
                            <div class="widget-summary-col">
                                <div class="summary">
                                    <h4 class="title">
                                        <?php echo get_phrase('marshals');?>
                                    </h4>
                                    <div class="info">
                                        <strong class="amount">
                                            <?php echo $this->db->count_all('marshal'); ?>
                                        </strong>
                                    </div>
                                </div>
                                <div class="summary-footer">
                                    <span class="text-muted text-uppercase">Total Marshals</span>
                                </div>
                            </div>
                        </div>


                    </div>
                </section>
            </div>
            <div class="col-md-12 col-lg-6 col-xl-6" data-appear-animation="bounceIn">
                <section class="panel panel-featured-left panel-featured-primary">
                    <div class="panel-body">
                        <div class="widget-summary">
                            <div class="widget-summary-col widget-summary-col-icon">
                                <div class="summary-icon bg-primary">
                                    <i class="fa fa-tablet"></i>
                                </div>
                            </div>
                            <div class="widget-summary-col">
                                <div class="summary">
                                    <h4 class="title">
                                        <?php echo get_phrase('devices');?>
                                    </h4>
                                    <div class="info">
                                        <strong class="amount">
                                            <?php echo $this->db->count_all('device');?>
                                        </strong>
                                    </div>
                                </div>
                                <div class="summary-footer">
                                    <span class="text-muted text-uppercase">Total Devices</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-md-12 col-lg-6 col-xl-6" data-appear-animation="bounceIn">
                <section class="panel panel-featured-left panel-featured-primary">
                    <div class="panel-body">
                        <div class="widget-summary">
                            <div class="widget-summary-col widget-summary-col-icon">
                                <div class="summary-icon bg-primary">
                                    <i class="fa fa-car"></i>
                                </div>
                            </div>
                                <div class="widget-summary-col">
                                <div class="summary">
                                    <h4 class="title">
                                        <?php echo get_phrase('baysets');?>
                                    </h4>
                                    <div class="info">
                                        <strong class="amount">
                                            <?php echo $this->db->count_all('bays');?>
                                        </strong>
                                    </div>
                                </div>
                                <div class="summary-footer">
                                    <span class="text-muted text-uppercase">Bay Sets</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    
    <div class="col-lg-6" data-appear-animation="bounceInLeft">
                            <section class="panel">
                                            <header class="panel-heading">
                                                <div class="panel-actions">
                                                    <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                                                    <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
                                                </div>
                        
                                                <h2 class="panel-title">Bays on Streets </h2>
                                            </header>
                                            <div class="panel-body">
                                                <div class="row text-center">
                                                    <div class="col-md-6">
                                                        <div class="circular-bar">
                                                            <div class="circular-bar-chart" data-percent="63" data-plugin-options='{ "barColor": "#0088CC", "delay": 300 }'>
                                                                <strong>Left Bays</strong>
                                                                <label><span class="percent">63></span>%</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="circular-bar">
                                                            <div class="circular-bar-chart" data-percent="34" data-plugin-options='{ "barColor": "#2BAAB1", "delay": 600 }'>
                                                                <strong>Right Bays</strong>
                                                                <label><span class="percent">34</span>%</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>  
                            </div>
                           
    </div>	
					
		<div class="row">
					
			<div class="col-md-6" data-appear-animation="fadeInRightBig">
								<section class="panel">
								<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
											<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
										</div>
										
										<h2 class="panel-title">Perfomance Report - Bar Representation</h2>
						</header>
									
									<div class="panel-body">
						
										<!-- Morris: Area -->
										<div class="chart chart-md" id="morrisStacked"></div>
										<script type="text/javascript">
						
											var morrisStackedData = [
											 
								<?php	
								
								foreach ($incount as $inc): 
												
								$startdate = $inc['startdate'];
								$enddate   = $inc['enddate'];
									
								
								
								$this->db->where('date >=',$startdate);
								$this->db->where('date <=',$enddate);
								$this->db->where('year',$year);
								$this->db->select_sum('actual');
								$que = $this->db->get('dailyrecons'); 
								$actuals2 = $que->row()->actual;
												
								$this->db->where('date >=',$startdate);
								$this->db->where('date <=',$enddate);
								$this->db->where('year',$year);
								$this->db->select_sum('total');
								$que2 = $this->db->get('dailyrecons'); 
								$totals2 = $que2->row()->total;
								
								
								if(!empty($actuals2)){
								$actually = $actuals2;
								}else{
								$actually = 0;
								}
								
								if(!empty($totals2)){
								$totally2 = $totals2;
								}else{
								$totally2 = 0;
								}
												
									$inyanga = date('M',strtotime($inc['startdate']));			
								  
							    ?>   
											{
												y: "<?php echo $inyanga; ?>",
												a:  <?php echo $totally2 ?> ,
												b: <?php echo $actually ?>
											}, 
											
											
											<?php endforeach; ?>
										
											];
						
											// See: assets/javascripts/ui-elements/examples.charts.js for more settings.
						
										</script>
						
						
						
									</div>
								</section>
								
							</div>
			<div class="col-md-6" data-appear-animation="fadeInRightBig">
								<section class="panel">
								<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
											<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
										</div>
										
										<h2 class="panel-title">Monthly Reports</h2>
						</header>
									
		<div class="panel-body">
		
		<div class="scrollable" data-plugin-scrollable style="height: 350px;">
	<div class="scrollable-content">
	<?php 
	
	
/*	$inmonths = $this->db->get('inmonths', 'year' => $year )->result_array());
	
	*/
		
		$this->db->select("*");
		$this->db->where('year',$year);
	    $this->db->from('inmonths');
	    $query1 = $this->db->get();
	    $inmonths = $query1->result_array();
	
	;?>
	<?php foreach($inmonths as $row):
	
			$startdate = $row['startdate'];
			$enddate   = $row['enddate'];
			
			
			
											
			$this->db->where('date >=',$startdate);
        	$this->db->where('date <=',$enddate);
        	$this->db->where('year',$year);
			$this->db->select_sum('actual');
			$querys = $this->db->get('dailyrecon'); 
			$result7 = $querys->row()->actual;
												
			
												
	?>
	
	<div class="col-md-12" data-appear-animation="bounceInUp">		
		<section class="panel panel-featured-left panel-featured-primary">
			<div class="panel-body">
				<div class="widget-summary widget-summary-sm">
					<div class="widget-summary-col widget-summary-col-icon">
						<div class="summary-icon bg-primary">
							<i class="fa fa-money"></i>
						</div>
					</div>
					<div class="widget-summary-col">
						<div class="summary">
							<h4 class="title"><?php echo date('F',strtotime($row['startdate'])).' -'.$row['year'].' Financials';?></h4>
							<div class="info">
								<span class="text-primary text-uppercase">E</span>
								<strong class="amount"><?php echo number_format($result7, 2, '.', ' ') ?></strong>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
<?php endforeach; ?>
</div>
</div>
		
		
		</div>
								</section>
								
							</div>


						</div>
						
						
						<div class="row">
						
						
							<div class="col-md-12" data-appear-animation="fadeInRightBig">
								<section class="panel">
								<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
											<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
										</div>
										
										<h2 class="panel-title">Datatable Presentation - <?php echo $year; ?></h2>
								</header>
									
									<div class="panel-body">
									<div class="table-responsive">
					<table class="table table-bordered table-striped table-condensed mb-none" id="datatable-tabletools">
					<thead>
						<tr>
						
						<th><div>#</div></th>
							<th><div><?php echo get_phrase('month');?></div></th>
							<th><div><?php echo get_phrase('year');?></div></th>
							<th><div><?php echo get_phrase('system');?></div></th>
							<th><div><?php echo get_phrase('actual');?></div></th>
							<th><div><?php echo get_phrase('variance');?></div></th>
							<th><div><?php echo get_phrase('%_loss/_gain');?></div></th>
							<th><div><?php echo get_phrase('position');?></div></th>
						</tr>
					</thead>
					<tbody>
					
						<?php $count = 1;foreach($incount as $row):
						
						
							$startdated = $row['startdate'];
			                $enddated   = $row['enddate'];
			
			
			
											
                			$this->db->where('date >=',$startdated);
                        	$this->db->where('date <=',$enddated);
							$this->db->where('year',$year);
							$this->db->select_sum('total');
							$query = $this->db->get('dailyrecons'); 
							$result6 = $query->row()->total;
							
							$this->db->where('date >=',$startdated);
                        	$this->db->where('date <=',$enddated);
							$this->db->where('year',$year);
							$this->db->select_sum('actual');
							$querys = $this->db->get('dailyrecons'); 
							$result7 = $querys->row()->actual;
							
							$this->db->where('date >=',$startdated);
                        	$this->db->where('date <=',$enddated);
							$this->db->where('year',$year);
							$this->db->select_sum('variance');
							$queryz = $this->db->get('dailyrecons'); 
							$result8 = $queryz->row()->variance;
							
							$this->db->select('*');
							$this->db->where('date >=',$startdated);
                        	$this->db->where('date <=',$enddated);
							$this->db->where('year',$year);
							$queryz = $this->db->get('dailyrecons'); 
							$result9 = $queryz->row()->bay_id;
							
							$percentage = ($result8 / $result6) * 100;
							
							if($percentage > 1){
							   
							  $ciklasi = 'text-danger'; 
							    
							}else{
							    
							    $ciklasi = 'text-success'; 
							}
							
							if($result9 == '80'){
							    
							    $position = 'Reliever';
							    
							}else{
							    
							    $position = 'Full Time';
							}
							
						
						?>
						<tr>
						<td><?php echo $count++;?></td>
							<td><?php echo $row['month'];?></td>
							<td><?php echo $row['year'];?></td>
							<td><?php echo number_format($result6, 2, '.', ' ') ?></td>
							<td><?php echo number_format($result7, 2, '.', ' ') ?></td>
							<td><?php echo number_format($result8, 2, '.', ' ') ?></td>
							<td class='<?php echo $ciklasi; ?>'><?php echo number_format($percentage, 2, '.', ' '). ' %' ?></td>
							
							<td><?php echo $position;?></td>
							
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
									</div>
								</section>
								
							</div>
						
							
						</div>
						
						
						
						<div class="row">
						
						
							<div class="col-md-12" data-appear-animation="fadeInRightBig">
								<section class="panel">
								<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
											<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
										</div>
										
										<h2 class="panel-title">Milestone Presentation</h2>
								</header>
									
									<div class="panel-body">
									
									
									<!-- start: page -->
					
				            
									
					<div class="timeline">
						<div class="tm-body">
						    
						    	<?php
								foreach ($incount as $mile): 
												
								$startdatem = $mile['startdate'];
								$enddatem   = $mile['enddate'];
								
								
								$this->db->where('date >=',$startdatem);
								$this->db->where('date <=',$enddatem);
								$this->db->where('year',$year);
								$this->db->select_sum('actual');
								$quem = $this->db->get('dailyrecons'); 
								$actuals3 = $quem->row()->actual;
												
								$this->db->where('date >=',$startdatem);
								$this->db->where('date <=',$enddatem);
								$this->db->where('year',$year);
								$this->db->select_sum('total');
								$quem2 = $this->db->get('dailyrecons'); 
								$totals3 = $quem2->row()->total;
								
								
							    $inyanganemnyaka = date('M',strtotime($mile['startdate'])).' - '.$year;	
												
								$variance3 = $totals3 - $actuals3;			
								  
							    ?>
						    
							<div class="tm-title">
								<h3 class="h5 text-uppercase"><?php echo $inyanganemnyaka; ?></h3>
							</div>
							<ol class="tm-items">
								
								
								<li>
									<div class="tm-info">
										<div class="tm-icon"><i class="fa fa-user"></i></div>
										<time class="tm-datetime" datetime="2016-11-14 17:25">
											<div class="tm-datetime-time"><?php echo $pieces[0]; ?></div>
											<div class="tm-datetime-date"><?php echo $pieces[1]; ?></div>
											
										</time>
									</div>
									<div class="tm-box appear-animation" data-appear-animation="fadeInRight" data-appear-animation-delay="400">
										<p>
										
	
		<div class="col-md-4" data-appear-animation="bounceInUp">
		
		<section class="panel panel-featured-left panel-featured-success">
			<div class="panel-body">
				<div class="widget-summary widget-summary-sm">
					<div class="widget-summary-col widget-summary-col-icon">
						<div class="summary-icon bg-success">
							<i class="fa fa-desktop"></i>
						</div>
					</div>
					<div class="widget-summary-col">
						<div class="summary">
							<h4 class="title"><?php echo get_phrase('total_system');?></h4>
							<div class="info">
								<span class="text-success text-uppercase">E</span>
								<strong class="amount"><?php echo number_format($totals3, 2, '.', ' ') ?></strong>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
		<div class="col-md-4" data-appear-animation="bounceInUp">
		
		<section class="panel panel-featured-left panel-featured-info">
			<div class="panel-body">
				<div class="widget-summary widget-summary-sm">
					<div class="widget-summary-col widget-summary-col-icon">
						<div class="summary-icon bg-info">
							<i class="fa fa-database"></i>
						</div>
					</div>
					<div class="widget-summary-col">
						<div class="summary">
							<h4 class="title"><?php echo get_phrase('total_actual');?></h4>
							<div class="info">
								<span class="text-info text-uppercase">E</span>
								<strong class="amount"> <?php echo number_format($actuals3, 2, '.', ' ') ?></strong>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
	
		<div class="col-md-4" data-appear-animation="bounceInUp">
		
		<section class="panel panel-featured-left panel-featured-secondary">
			<div class="panel-body">
				<div class="widget-summary widget-summary-sm">
					<div class="widget-summary-col widget-summary-col-icon">
						<div class="summary-icon bg-secondary">
							<i class="fa fa-arrow-down"></i>
						</div>
					</div>
					<div class="widget-summary-col">
						<div class="summary">
							<h4 class="title"><?php echo get_phrase('total_variance');?></h4>
							<div class="info">
								<span class="text-secondary text-uppercase">E</span>
								<strong class="amount"><?php echo number_format($variance3, 2, '.', ' ') ?></strong>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
										</p>
										
										<div id="gmap-checkin-example" class="mb-sm" style="height: 100px; width: 100%;"></div>
										<div class="tm-meta">
											
										</div>
									</div>
								</li>
							</ol>
						
					<?php endforeach; ?>	
						
						
						
							
									
									
						
									</div>
						
						</section>
						
						</div>
						
						</div>
	
<script type="text/javascript">
    function class_section( date ) {
        window.location.href = '<?php echo base_url(); ?>index.php?accountant/dashboard/'+date;
    }
</script>	