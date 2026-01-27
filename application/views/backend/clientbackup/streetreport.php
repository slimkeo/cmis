<?php 
$edit_data		=	$this->db->get_where('street' , array('street_id' => $street_id) )->result_array();
?>
	



					<div class="row">
				
					
						<div class="col-md-6 col-lg-12">
							<section class="panel">
								<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
											<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
										</div>
						
										<h2 class="panel-title">Perfomance Report - <?php 
		
		
		$street =$this->db->get_where('street' , array('street_id' =>  $street_id))->row()->street_name; 
		
		
		echo $street;
		?></h2>	
		
		<?php
		
				// Example 1
		
		$pieces = explode(" ", $street);
		
		
		
		?>
		
		<?php
			$dayincome = $this->db->get_where( 'collections', array('street' => $street) )->result_array();
			$todayincome = 0;
			foreach ( $dayincome as $rowd ):
			$todayincome = $todayincome + $rowd[ 'actual' ] ;
			$systemcash = $systemcash + $rowd[ 'systemcash' ] ;
			$varience = $systemcash - $todayincome ;
			endforeach;
		 ?>
		 
		 <?php
			
				$count = $this->db->get_where( 'collections', array('street' => $street, 'month' =>'Feb' ) )->result_array();
				foreach ( $count as $rows ): 
				
				$month = $rows['month']; 
				$febbroughtback = $febbroughtback + $rows['broughtback'];
				$febsystemcash = $febsystemcash + $rows['systemcash']; 
				$febactual = $febactual + $rows['actual']; 
				$febvarience = $febactual - $febsystemcash; 
				$febv = $febsystemcash - $febactual;
				
				
				$febloss = ($febv / $febsystemcash) * 100;
				 
				endforeach;
				
		?>
		
		<?php
			
				$count = $this->db->get_where( 'collections', array('street' => $street, 'month' =>'Mar' ) )->result_array();
				foreach ( $count as $rows ): 
				
				$month = $rows['month']; 
				$marbroughtback = $marbroughtback + $rows['broughtback'];
				$marsystemcash = $marsystemcash + $rows['systemcash']; 
				$maractual = $maractual + $rows['actual']; 
				$marvarience = $maractual - $marsystemcash; 
				
				$marv = $marsystemcash - $maractual;
				
				
				$marloss = ($marv / $marsystemcash) * 100;
				 
				endforeach;
				
		?>
		
		<?php
			
				$count = $this->db->get_where( 'collections', array('street' => $street, 'month' =>'Apr' ) )->result_array();
				foreach ( $count as $rows ): 
				
				$month = $rows['month']; 
				$aprbroughtback = $aprbroughtback + $rows['broughtback'];
				$aprsystemcash = $aprsystemcash + $rows['systemcash']; 
				$apractual = $apractual + $rows['actual']; 
				$aprvarience = $apractual - $aprsystemcash; 
				
				$aprv = $aprsystemcash - $apractual;
				
				
				$aprloss = ($aprv / $aprsystemcash) * 100;
				 
				endforeach;
				
		?>
		<?php
			
				$count = $this->db->get_where( 'collections', array('street' => $street, 'month' =>'May' ) )->result_array();
				foreach ( $count as $rows ): 
				
				$month = $rows['month']; 
				$maybroughtback = $maybroughtback + $rows['broughtback'];
				$maysystemcash = $maysystemcash + $rows['systemcash']; 
				$mayactual = $mayactual + $rows['actual']; 
				$mayvarience = $mayactual - $maysystemcash; 
				
				
				$mayv = $maysystemcash - $mayactual;
				
				
				$mayloss = ($mayv / $maysystemcash) * 100;
				 
				endforeach;
				
		?>
		
		<?php
			
				$count = $this->db->get_where( 'collections', array('street' => $street, 'month' =>'Jun' ) )->result_array();
				foreach ( $count as $rows ): 
				
				$month = $rows['month']; 
				$junbroughtback = $junbroughtback + $rows['broughtback'];
				$junsystemcash = $junsystemcash + $rows['systemcash']; 
				$junactual = $junactual + $rows['actual']; 
				$junvarience = $junactual - $junsystemcash; 
				
				$junv = $junsystemcash - $junactual;
				
				
				$junloss = ($junv / $junsystemcash) * 100;
				 
				endforeach;
				
		?>
		
		<?php
			
				$count = $this->db->get_where( 'collections', array('street' => $street, 'month' =>'Jul' ) )->result_array();
				foreach ( $count as $rows ): 
				
				$month = $rows['month']; 
				$julbroughtback = $julbroughtback + $rows['broughtback'];
				$julsystemcash = $julsystemcash + $rows['systemcash']; 
				$julactual = $julactual + $rows['actual']; 
				$julvarience = $julactual - $julsystemcash; 
				
				$julv = $julsystemcash - $julactual;
				
				
				$julloss = ($julv / $julsystemcash) * 100;
				 
				endforeach;
				
				?>
				
			<?php
			
				$count = $this->db->get_where( 'collections', array('street' => $street, 'month' =>'Aug' ) )->result_array();
				foreach ( $count as $rows ): 
				
				$month = $rows['month']; 
				$augbroughtback = $augbroughtback + $rows['broughtback'];
				$augsystemcash = $augsystemcash + $rows['systemcash']; 
				$augactual = $augactual + $rows['actual']; 
				$augvarience = $augactual - $augsystemcash; 
				
				$augv = $augsystemcash - $augactual;
				
				
				$augloss = ($augv / $augsystemcash) * 100;
				 
				endforeach;
				
				?>
			
			<?php
			
				$count = $this->db->get_where( 'collections', array('street' => $street, 'month' =>'Sep' ) )->result_array();
				foreach ( $count as $rows ): 
				
				$month = $rows['month']; 
				$sepbroughtback = $sepbroughtback + $rows['broughtback'];
				$sepsystemcash = $sepsystemcash + $rows['systemcash']; 
				$sepactual = $sepactual + $rows['actual']; 
				$sepvarience = $sepactual - $sepsystemcash; 
				
				
				$sepv = $sepsystemcash - $sepactual;
				
				
				$seploss = ($sepv / $sepsystemcash) * 100;
				 
				endforeach;
				
				?>
				<?php
			
				$count = $this->db->get_where( 'collections', array('street' => $street, 'month' =>'Oct' ) )->result_array();
				foreach ( $count as $rows ): 
				
				$month = $rows['month']; 
				$octbroughtback = $octbroughtback + $rows['broughtback'];
				$octsystemcash = $octsystemcash + $rows['systemcash']; 
				$octactual = $octactual + $rows['actual']; 
				$octvarience = $octactual - $octsystemcash; 
				
				
				$octv = $octsystemcash - $octactual;
				
				
				$octloss = ($octv / $octsystemcash) * 100;
				 
				endforeach;
				
				?>
				
				<?php
			
				$count = $this->db->get_where( 'collections', array('street' => $street, 'month' =>'Nov' ) )->result_array();
				foreach ( $count as $rows ): 
				
				$month = $rows['month']; 
				$novbroughtback = $novbroughtback + $rows['broughtback'];
				$novsystemcash = $novsystemcash + $rows['systemcash']; 
				$novactual = $novactual + $rows['actual']; 
				$novvarience = $novactual - $novsystemcash; 
				
				$novv = $novsystemcash - $novactual;
				
				
				$novloss = ($novv / $novsystemcash) * 100;
				 
				endforeach;
				
				?>
				<?php
			
				$count = $this->db->get_where( 'collections', array('street' => $street, 'month' =>'Dec' ) )->result_array();
				foreach ( $count as $rows ): 
				
				$month = $rows['month']; 
				$decbroughtback = $decbroughtback + $rows['broughtback'];
				$decsystemcash = $decsystemcash + $rows['systemcash']; 
				$decactual = $decactual + $rows['actual']; 
				$decvarience = $decactual - $decsystemcash; 
				
				$decv = $decsystemcash - $decactual;
				
				
				$decloss = ($decv / $decsystemcash) * 100;
				 
				endforeach;
				
				?>
									</header>
									
								<div class="panel-body">
									<div class="row">
										<div class="col-lg-12" data-appear-animation="fadeInRightBig">
											<!-- Morris: Line -->
										<div class="chart chart-md" id="morrisLine"></div>
										<script type="text/javascript">
						
											var morrisLineData = [{
												y: '2023-01-01',
												a:  0,
												b:  0
											}, {
												y: '2023-02-01',
												a:  <?php echo  $febsystemcash ?>,
												b:  <?php echo  $febactual ?>
											}, {
												y: '2023-03-01',
												a:  <?php echo  $marsystemcash ?>,
												b:  <?php echo  $maractual ?>
											}, {
												y: '2023-04-01',
												a:  <?php echo  $aprsystemcash ?>,
												b:  <?php echo  $apractual ?>
											}, {
												y: '2023-05-01',
												a:  <?php echo  $maysystemcash ?>,
												b:  <?php echo  $mayactual ?>
											}, {
												y: '2023-06-01',
												a:  <?php echo  $junsystemcash ?>,
												b:  <?php echo  $junactual ?>
											}, {
												y: '2023-07-01',
												a:  <?php echo  $julsystemcash ?>,
												b:  <?php echo  $julactual ?>
											}, {
												y: '2023-08-01',
												a:  <?php echo  $augsystemcash ?>,
												b:  <?php echo  $augactual ?>
											}, {
												y: '2023-09-01',
												a:  <?php echo  $sepsystemcash ?>,
												b:  <?php echo  $sepactual ?>
											},{
												y: '2023-10-01',
												a:  <?php echo  $octsystemcash ?>,
												b:  <?php echo  $octactual ?>
											},{
												y: '2023-11-01',
												a:  <?php echo  $novsystemcash ?>,
												b:  <?php echo  $novactual ?>
											},{
												y: '2023-12-01',
												a: 0,
												b: 0
											}];
						
											// See: assets/javascripts/ui-elements/examples.charts.js for more settings.
						
										</script>
					
													<!-- Flot: Sales Porto Wordpress -->
												
												</div>
					</section>
					
					<hr class="solid short mt-lg">
					
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
							<h4 class="title"><?php echo get_phrase('cars_parked');?></h4>
							<div class="info">
								
								<strong class="amount">281107</strong>
								<span class="text-primary text-uppercase"><?php echo get_phrase('-_2023');?></span>
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
							<h4 class="title"><?php echo get_phrase('total_system');?></h4>
							<div class="info">
								<span class="text-success text-uppercase">E</span>
								<strong class="amount"><?php echo number_format($systemcash, 2, '.', ' ') ?></strong>
								
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
							<h4 class="title"><?php echo get_phrase('total_actual');?></h4>
							<div class="info">
								<span class="text-info text-uppercase">E</span>
								<strong class="amount"> <?php echo number_format($todayincome, 2, '.', ' ') ?></strong>
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
								<strong class="amount"><?php echo number_format($varience, 2, '.', ' ') ?></strong>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
					
		<div class="row">
					
			<div class="col-md-12" data-appear-animation="fadeInRightBig">
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
						
											var morrisStackedData = [{
												y: 'Jan',
												a:  0,
												b: 0
											}, {
												y: 'Feb',
												a:  <?php echo  $febsystemcash ?>,
												b:  <?php echo  $febactual ?>
											}, {
												y: 'Mar',
												a:  <?php echo  $marsystemcash ?>,
												b:  <?php echo  $maractual ?>
											}, {
												y: 'Apr',
												a:  <?php echo  $aprsystemcash ?>,
												b:  <?php echo  $apractual ?>
											}, {
												y: 'May',
												a:  <?php echo  $maysystemcash ?>,
												b:  <?php echo  $mayactual ?>
											}, {
												y: 'Jun',
												a:  <?php echo  $junsystemcash ?>,
												b:  <?php echo  $junactual ?>
											}, {
												y: 'Jul',
												a:  <?php echo  $julsystemcash ?>,
												b:  <?php echo  $julactual ?>
											}, {
												y: 'Aug',
												a:  <?php echo  $augsystemcash ?>,
												b:  <?php echo  $augactual ?>
											}, {
												y: 'Sep',
												a:  <?php echo  $sepsystemcash ?>,
												b:  <?php echo  $sepactual ?>
											}, {
												y: 'Oct',
												a:  <?php echo  $octsystemcash ?>,
												b:  <?php echo  $octactual ?>
											}, {
												y: 'Nov',
												a:  <?php echo  $novsystemcash ?>,
												b:  <?php echo  $novactual ?>
											}, {
												y: 'Dec',
												a:  0,
												b:  0
											}];
						
											// See: assets/javascripts/ui-elements/examples.charts.js for more settings.
						
										</script>
						
						
						
									</div>
								</section>
								
							</div	
							
						</div>
						
						
						<div class="row">
						
						
							<div class="col-md-8" data-appear-animation="fadeInRightBig">
								<section class="panel">
								<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
											<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
										</div>
										
										<h2 class="panel-title">Datatable Presentation</h2>
								</header>
									
									<div class="panel-body">
									<div class="table-responsive">
										<table class="table table-striped mb-none">
											<thead>
												<tr>
													<th>#</th>
													<th>Month</th>
													<th>System</th>
													<th>Actual</th>
													<th>Variance</th>
													<th>Loss %</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>1</td>
													<td>February</td>
													<td><?php echo $febsystemcash; ?></td>
													<td><?php echo $febactual; ?></td>
													<td><?php echo $febvarience; ?></td>
													<td>
																<span class="text-center"><?php echo number_format($febloss); ?>%</span>
															
													</td>
												</tr>
												<tr>
													<td>2</td>
													<td>March</td>
													<td><?php echo $marsystemcash; ?></td>
													<td><?php echo $maractual; ?></td>
													<td><?php echo $marvarience; ?></td>
													<td>
													
																<span class="text-center"><?php echo number_format($marloss); ?>%</span>
														
													</td>
												</tr>
												
												<tr>
													<td>3</td>
													<td>April</td>
													<td><?php echo $aprsystemcash; ?></td>
													<td><?php echo $apractual; ?></td>
													<td><?php echo $aprvarience; ?></td>
													<td>
													
																<span class="text-center"><?php echo number_format($aprloss); ?>%</span>
															
													</td>
												</tr>
												<tr>
													<td>4</td>
													<td>May</td>
													<td><?php echo $maysystemcash; ?></td>
													<td><?php echo $mayactual; ?></td>
													<td><?php echo $mayvarience; ?></td>
													<td>
													
																<span class="text-center"><?php echo number_format($mayloss); ?>%</span>
														
													</td>
												</tr>
												<tr>
													<td>5</td>
													<td>June</td>
													<td><?php echo $junsystemcash; ?></td>
													<td><?php echo $junactual; ?></td>
													<td><?php echo $junvarience; ?></td>
													<td>
													
																<span class="text-center"><?php echo number_format($junloss); ?>%</span>
													
													</td>
												</tr>
												<tr>
													<td>6</td>
													<td>July</td>
													<td><?php echo $julsystemcash; ?></td>
													<td><?php echo $julactual; ?></td>
													<td><?php echo $julvarience; ?></td>
													<td>
													
																<span class="text-center"><?php echo number_format($julloss); ?>%</span>
													
													</td>
												</tr>
												<tr>
													<td>7</td>
													<td>August</td>
													<td><?php echo $augsystemcash; ?></td>
													<td><?php echo $augactual; ?></td>
													<td><?php echo $augvarience; ?></td>
													<td>
													
																<span class="text-center"><?php echo number_format($augloss); ?>%</span>
														
													</td>
												</tr>
												
												<tr>
													<td>8</td>
													<td>September</td>
													<td><?php echo $sepsystemcash; ?></td>
													<td><?php echo $sepactual; ?></td>
													<td><?php echo $sepvarience; ?></td>
													<td>
													
																<span class="text-center"><?php echo number_format($seploss); ?>%</span>
													
													</td>
												</tr>
												<tr>
													<td>9</td>
													<td>October</td>
													<td><?php echo $octsystemcash; ?></td>
													<td><?php echo $octactual; ?></td>
													<td><?php echo $octvarience; ?></td>
													<td>
												
																<span class="text-center"><?php echo number_format($octloss); ?>%</span>
														
													</td>
												</tr>
												<tr>
													<td>10</td>
													<td>November</td>
													<td><?php echo $novsystemcash; ?></td>
													<td><?php echo $novactual; ?></td>
													<td><?php echo $novvarience; ?></td>
													<td>
													
																<span class="text-center"><?php echo number_format($novloss); ?>%</span>
														
													</td>
												</tr>
												<tr>
													<td>11</td>
													<td>December</td>
													<td><?php echo $decsystemcash; ?></td>
													<td><?php echo $decactual; ?></td>
													<td><?php echo $decvarience; ?></td>
													<td>
													
																<span class="text-center"><?php echo number_format($decloss); ?>%</span>
													
													</td>
												</tr>
												
											</tbody>
										</table>
									
									</div>
								</section>
								
							</div>
								<div class="col-md-4" data-appear-animation="fadeInRightBig">
								<section class="panel">
								<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
											<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
										</div>
										
										<h2 class="panel-title">Pie Chart Presentation</h2>
								</header>
									
									<div class="panel-body">
									<!-- Flot: Pie -->
										<div class="chart chart-md" id="flotPie"></div>
										<script type="text/javascript">
						
											var flotPieData = [{
												label: "February",
												data: [
													[1, <?php echo number_format($febloss); ?>]
												],
												color: '#0088cc'
											}, {
												label: "March",
												data: [
													[1, <?php echo number_format($marloss); ?>]
												],
												color: '#2baab1'
											}, {
												label: "April",
												data: [
													[1, <?php echo number_format($aprloss); ?>]
												],
												color: '#734ba9'
											}, {
												label: "May",
												data: [
													[1, <?php echo number_format($mayloss); ?>]
												],
												color: '#E36159'
											}, {
												label: "June",
												data: [
													[1, <?php echo number_format($junloss); ?>]
												],
												color: '#E36159'
											}, {
												label: "July",
												data: [
													[1, <?php echo number_format($julloss); ?>]
												],
												color: '#01579B'
											}, {
												label: "August",
												data: [
													[1, <?php echo number_format($augloss); ?>]
												],
												color: '#FF6F00'
											}, {
												label: "September",
												data: [
													[1, <?php echo number_format($seploss); ?>]
												],
												color: '#E36159'
											}, {
												label: "October",
												data: [
													[1, <?php echo number_format($octloss); ?>]
												],
												color: '#F44336'
											}, {
												label: "November",
												data: [
													[1, <?php echo number_format($novloss); ?>]
												],
												color: '#FFC107'
											}];
						
											// See: assets/javascripts/ui-elements/examples.charts.js for more settings.
						
										</script>
									
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
							<div class="tm-title">
								<h3 class="h5 text-uppercase">February 2023</h3>
							</div>
							<ol class="tm-items">
								
								
								<li>
									<div class="tm-info">
										<div class="tm-icon"><i class="fa fa-map-marker"></i></div>
										<time class="tm-datetime" datetime="2016-11-14 17:25">
											<div class="tm-datetime-time"><?php echo $pieces[0]; ?></div>
											<div class="tm-datetime-date">Street</div>
											
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
								<strong class="amount"><?php echo number_format($febsystemcash, 2, '.', ' ') ?></strong>
								
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
								<strong class="amount"> <?php echo number_format($febactual, 2, '.', ' ') ?></strong>
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
								<strong class="amount"><?php echo number_format($febvarience, 2, '.', ' ') ?></strong>
								
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
							<div class="tm-title">
								<h3 class="h5 text-uppercase">March 2023</h3>
							</div>
							<ol class="tm-items">
								
								
								<li>
									<div class="tm-info">
										<div class="tm-icon"><i class="fa fa-map-marker"></i></div>
										<time class="tm-datetime" datetime="2016-11-14 17:25">
											<div class="tm-datetime-time"><?php echo $pieces[0]; ?></div>
											<div class="tm-datetime-date">Street</div>
											
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
								<strong class="amount"><?php echo number_format($marsystemcash, 2, '.', ' ') ?></strong>
								
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
								<strong class="amount"> <?php echo number_format($maractual, 2, '.', ' ') ?></strong>
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
								<strong class="amount"><?php echo number_format($marvarience, 2, '.', ' ') ?></strong>
								
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
							
							
							
					<div class="tm-title">
								<h3 class="h5 text-uppercase">April 2023</h3>
							</div>
							<ol class="tm-items">
								
								
								<li>
									<div class="tm-info">
										<div class="tm-icon"><i class="fa fa-map-marker"></i></div>
										<time class="tm-datetime" datetime="2016-11-14 17:25">
											<div class="tm-datetime-time"><?php echo $pieces[0]; ?></div>
											<div class="tm-datetime-date">Street</div>
											
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
								<strong class="amount"><?php echo number_format($aprsystemcash, 2, '.', ' ') ?></strong>
								
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
								<strong class="amount"> <?php echo number_format($apractual, 2, '.', ' ') ?></strong>
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
								<strong class="amount"><?php echo number_format($aprvarience, 2, '.', ' ') ?></strong>
								
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
							
							
							
							
					<div class="tm-title">
								<h3 class="h5 text-uppercase">May 2023</h3>
							</div>
							<ol class="tm-items">
								
								
								<li>
									<div class="tm-info">
										<div class="tm-icon"><i class="fa fa-map-marker"></i></div>
										<time class="tm-datetime" datetime="2016-11-14 17:25">
											<div class="tm-datetime-time"><?php echo $pieces[0]; ?></div>
											<div class="tm-datetime-date">Street</div>
											
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
								<strong class="amount"><?php echo number_format($maysystemcash, 2, '.', ' ') ?></strong>
								
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
								<strong class="amount"> <?php echo number_format($mayactual, 2, '.', ' ') ?></strong>
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
								<strong class="amount"><?php echo number_format($mayvarience, 2, '.', ' ') ?></strong>
								
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
							
							
				<div class="tm-title">
								<h3 class="h5 text-uppercase">June 2023</h3>
							</div>
							<ol class="tm-items">
								
								
								<li>
									<div class="tm-info">
										<div class="tm-icon"><i class="fa fa-map-marker"></i></div>
										<time class="tm-datetime" datetime="2016-11-14 17:25">
											<div class="tm-datetime-time"><?php echo $pieces[0]; ?></div>
											<div class="tm-datetime-date">Street</div>
											
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
								<strong class="amount"><?php echo number_format($junsystemcash, 2, '.', ' ') ?></strong>
								
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
								<strong class="amount"> <?php echo number_format($junactual, 2, '.', ' ') ?></strong>
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
								<strong class="amount"><?php echo number_format($junvarience, 2, '.', ' ') ?></strong>
								
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
							
							
							<div class="tm-title">
								<h3 class="h5 text-uppercase">July 2023</h3>
							</div>
							<ol class="tm-items">
								
								
								<li>
									<div class="tm-info">
										<div class="tm-icon"><i class="fa fa-map-marker"></i></div>
										<time class="tm-datetime" datetime="2016-11-14 17:25">
											<div class="tm-datetime-time"><?php echo $pieces[0]; ?></div>
											<div class="tm-datetime-date">Street</div>
											
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
								<strong class="amount"><?php echo number_format($julsystemcash, 2, '.', ' ') ?></strong>
								
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
								<strong class="amount"> <?php echo number_format($julactual, 2, '.', ' ') ?></strong>
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
								<strong class="amount"><?php echo number_format($julvarience, 2, '.', ' ') ?></strong>
								
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
							
							
							<div class="tm-title">
								<h3 class="h5 text-uppercase">Aug 2023</h3>
							</div>
							<ol class="tm-items">
								
								
								<li>
									<div class="tm-info">
										<div class="tm-icon"><i class="fa fa-map-marker"></i></div>
										<time class="tm-datetime" datetime="2016-11-14 17:25">
											<div class="tm-datetime-time"><?php echo $pieces[0]; ?></div>
											<div class="tm-datetime-date">Street</div>
											
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
								<strong class="amount"><?php echo number_format($augsystemcash, 2, '.', ' ') ?></strong>
								
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
								<strong class="amount"> <?php echo number_format($augactual, 2, '.', ' ') ?></strong>
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
								<strong class="amount"><?php echo number_format($augvarience, 2, '.', ' ') ?></strong>
								
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
							
							<div class="tm-title">
								<h3 class="h5 text-uppercase">September 2023</h3>
							</div>
							<ol class="tm-items">
								
								
								<li>
									<div class="tm-info">
										<div class="tm-icon"><i class="fa fa-map-marker"></i></div>
										<time class="tm-datetime" datetime="2016-11-14 17:25">
											<div class="tm-datetime-time"><?php echo $pieces[0]; ?></div>
											<div class="tm-datetime-date">Street</div>
											
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
								<strong class="amount"><?php echo number_format($sepsystemcash, 2, '.', ' ') ?></strong>
								
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
								<strong class="amount"> <?php echo number_format($sepactual, 2, '.', ' ') ?></strong>
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
								<strong class="amount"><?php echo number_format($sepvarience, 2, '.', ' ') ?></strong>
								
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
							
							<div class="tm-title">
								<h3 class="h5 text-uppercase">October 2023</h3>
							</div>
							<ol class="tm-items">
								
								
								<li>
									<div class="tm-info">
										<div class="tm-icon"><i class="fa fa-map-marker"></i></div>
										<time class="tm-datetime" datetime="2016-11-14 17:25">
											<div class="tm-datetime-time"><?php echo $pieces[0]; ?></div>
											<div class="tm-datetime-date">Street</div>
											
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
								<strong class="amount"><?php echo number_format($octsystemcash, 2, '.', ' ') ?></strong>
								
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
								<strong class="amount"> <?php echo number_format($octactual, 2, '.', ' ') ?></strong>
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
								<strong class="amount"><?php echo number_format($octvarience, 2, '.', ' ') ?></strong>
								
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
							
							
							<div class="tm-title">
								<h3 class="h5 text-uppercase">November 2023</h3>
							</div>
							<ol class="tm-items">
								
								
								<li>
									<div class="tm-info">
										<div class="tm-icon"><i class="fa fa-map-marker"></i></div>
										<time class="tm-datetime" datetime="2016-11-14 17:25">
											<div class="tm-datetime-time"><?php echo $pieces[0]; ?></div>
											<div class="tm-datetime-date">Street</div>
											
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
								<strong class="amount"><?php echo number_format($novsystemcash, 2, '.', ' ') ?></strong>
								
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
								<strong class="amount"> <?php echo number_format($novactual, 2, '.', ' ') ?></strong>
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
								<strong class="amount"><?php echo number_format($novvarience, 2, '.', ' ') ?></strong>
								
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
							
							<div class="tm-title">
								<h3 class="h5 text-uppercase">December 2023</h3>
							</div>
							<ol class="tm-items">
								
								
								<li>
									<div class="tm-info">
										<div class="tm-icon"><i class="fa fa-map-marker"></i></div>
										<time class="tm-datetime" datetime="2016-11-14 17:25">
											<div class="tm-datetime-time"><?php echo $pieces[0]; ?></div>
											<div class="tm-datetime-date">Street</div>
											
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
								<strong class="amount"><?php echo number_format($decsystemcash, 2, '.', ' ') ?></strong>
								
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
								<strong class="amount"> <?php echo number_format($decactual, 2, '.', ' ') ?></strong>
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
								<strong class="amount"><?php echo number_format($decvarience, 2, '.', ' ') ?></strong>
								
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
						
					
						</div>
					</div>
					<!-- end: page -->
									
									
									
						
									</div>
						
						</section>
						
						</div>
						
						</div>
	
