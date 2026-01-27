<?php 
$edit_data		=	$this->db->get_where('week' , array('week_id' => $week_id) )->result_array();


$value_to_select =  array(
    'bay_name','date',
    'sum(total) as total',
    'sum(actual) as actual',
    'sum(variance) as variance'
            );

$this->db->select($value_to_select);
$this->db->from("dailyrecon d,bays b");
$this->db->where("b.bay_id=d.bay_id");
$this->db->where('week=29');
$this->db->group_by('bay_name');
$query7 = $this->db->get();
$result7 = $query7->result_array();

$value_to_select =  array('street_name',
                'bay_name',
                'sum(total) as total',
                'sum(actual) as actual',
                'sum(variance) as variance'
            );

$this->db->select($value_to_select);
$this->db->from("dailyrecon d,bays b,street s");
$this->db->where("s.street_id=b.street_id");
$this->db->where("b.bay_id=d.bay_id");
$this->db->where('week',$week_id);
$this->db->group_by('street_name');
$query6 = $this->db->get();
$result6 = $query6->result_array();



?>


<!-- start: page -->
<?php
			


   foreach($result6 as $row):

	$system = $system + $row['total'];
	$actual = $actual + $row['actual'];
	$variance = $variance + $row['variance'];
	
	
	
	$street = $row['street_name']; 
													
	 if($street == 'Gwamile Street')
		$gwa = $row['total'];		
	 else if ($street == 'Dzeliwe Street')
		$dze = $row['total'];
	else if ($street == 'Makhosini Drive')
		$mak = $row['system'];
	else if ($street == 'Betfusile Street')
		$bet = $row['total'];
	else if ($street == 'Enforcement')
		$karl = $row['total'];
	else if ($street == 'Libandla Street')
		$lib = $row['total'];
	else if ($street == 'Mahlokohla Street')
		$mah = $row['total'];
	else if ($street == 'Mdada Street')
		$mda = $row['total'];
	else if ($street == 'Msakato Street')
		$msa = $row['total'];	
	else if ($street == 'Zwide Street')
		$zwi = $row['total'];
	else if ($street == 'Siyalu Street')
		$siy = $row['total'];
		else if ($street == 'Makhosini Drive')
		$nju = $row['total'];
	else if ($street == 'CBS Parking')
		$cbs = $row['total'];
	else if ($street == 'Teba Street')
		$teb = $row['total'];
		
		if($street == 'Gwamile Street')
		$gwa2 = $row['actual'];		
	 else if ($street == 'Dzeliwe Street')
		$dze2 = $row['actual'];
	else if ($street == 'Makhosini Drive')
		$mak2 = $row['system'];
	else if ($street == 'Betfusile Street')
		$bet2 = $row['actual'];
	else if ($street == 'Enforcement')
		$karl2 = $row['actual'];
	else if ($street == 'Libandla Street')
		$lib2 = $row['actual'];
	else if ($street == 'Mahlokohla Street')
		$mah2 = $row['actual'];
	else if ($street == 'Mdada Street')
		$mda2 = $row['actual'];
	else if ($street == 'Msakato Street')
		$msa2 = $row['actual'];
	else if ($street == 'Somhlolo Street')
		$som2 = $row['actual'];
	else if ($street == 'Zwide Street')
		$zwi2 = $row['actual'];
	else if ($street == 'Siyalu Street')
		$siy2 = $row['actual'];
		else if ($street == 'Makhosini Drive')
		$nju2 = $row['actual'];
	else if ($street == 'CBS Parking')
		$cbs2 = $row['actual'];
	else if ($street == 'Teba Street')
		$teb2 = $row['actual'];
											
	
	
	
	
	
	
	endforeach;	
	
?>

			
			
			<div class="row">
			
									

	
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
								<strong class="amount"><?php echo number_format($system, 2, '.', ' ') ?></strong>
								
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
								<strong class="amount"> <?php echo number_format($actual, 2, '.', ' ') ?></strong>
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
								<strong class="amount"><?php echo number_format($variance, 2, '.', ' ') ?></strong>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
				
			
			</div>

					<div class="row">
				
					
						<div class="col-lg-12" data-appear-animation="bounceIn">
							
							<section class="panel">
								<header class="panel-heading">
									
						
										<h2 class="panel-title">Total Revenue Chart </h2>
						
									</header>
								<div class="panel-body">
									<div class="row">
										<div class="col-lg-12" data-appear-animation="fadeInRightBig">
											
																		
											<!-- Morris: Area -->
											
		
											
										<div class="chart chart-md" id="morrisStacked"></div>
												
												<script type="text/javascript">
						
											var morrisStackedData = [{
												y: 'BET',
												a:  <?php echo $bet; ?>,
												b: <?php echo $bet2; ?>
											}, {
												y: 'CBS',
												a:  <?php echo $cbs; ?>,
												b: <?php echo $cbs2; ?>
											}, {
												y: 'DZE',
												a:  <?php echo $dze; ?>,
												b: <?php echo $dze2; ?>
											},  {
												y: 'GWA',
												a:  <?php echo $gwa; ?>,
												b: <?php echo $gwa2; ?>
											}, {
												y: 'LIB',
												a:  <?php echo $lib; ?>,
												b: <?php echo $lib2; ?>
											}, {
												y: 'MAH',
												a:  <?php echo $mah; ?>,
												b: <?php echo $mah2; ?>
											}, {
												y: 'MDA',
												a:  <?php echo $mda; ?>,
												b: <?php echo $mda2; ?>
											}, {
												y: 'MSA',
												a:  0,
												b: 0
											}, {
												y: 'NJU',
												a:  <?php echo $nju; ?>,
												b: <?php echo $nju2; ?>
											}, {
												y: 'OBR',
												a:  0,
												b: 0
											}, {
												y: 'SIY',
												a:  <?php echo $siy; ?>,
												b: <?php echo $siy2; ?>
											}, {
												y: 'ZWI',
												a:  <?php echo $zwi; ?>,
												b: <?php echo $zwi2; ?>
											}];
						
											// See: assets/javascripts/ui-elements/examples.charts.js for more settings.
						
										</script>
										
					
					
									<hr class="solid short mt-lg">
												<div class="row">
													<div class="col-md-4">
														<div class="h4 text-weight-bold mb-none mt-lg">E <?php echo number_format($system, 2, '.', ' ') ?></div>
														<p class="text-xs text-primary mb-none">System Cash </p>
													</div>
													<div class="col-md-4">
														<div class="h4 text-weight-bold mb-none mt-lg">E <?php echo number_format($actual, 2, '.', ' ') ?></div>
														<p class="text-xs text-primary mb-none">Actual Cash</p>
													</div>
													<div class="col-md-4">
														<div class="h4 text-weight-bold mb-none mt-lg">E <?php echo number_format($variance, 2, '.', ' ') ?></div>
														<p class="text-xs text-primary mb-none">Variance Cash</p>
													</div>
												</div>
												
												</div>
										</div>
									</div>
					</section>
					
					</div>
					

	

<div class="row">			
	<div class="col-md-12 col-lg-12">
		<section class="panel">
			<header class="panel-heading">
				<div class="panel-actions">
					<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
						<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
										</div>
						
										<h2 class="panel-title">Perfomance Report - <?php 
		
		
		$week =$this->db->get_where('week' , array('week_id' =>  $week_id))->row()->week; 
		
		echo $week;
		?></h2>	
		
	
		
		<?php
			$dayincome = $this->db->get_where( 'dailyrecon', array('week' => $week_id) )->result_array();
			$todayincome = 0;
			
			foreach ( $dayincome as $rowd ):
			$todayincome = $todayincome + $rowd[ 'actual' ] ;
			$systemcash = $systemcash + $rowd[ 'total' ] ;
			$varience = $systemcash - $todayincome ;
			endforeach;
		 ?>
		 
		</header>
									
								<div class="panel-body">
									<div class="row">
										<div class="col-lg-12" data-appear-animation="fadeInRightBig">
										
										
											<!-- Morris: Line -->
									<div class="chart chart-sm" id="flotDashSales1" style="height: 345px;"></div>

						<!-- Flot: Earning Graph -->
						<script>
							var flotDashSales1Data = [{
								data: [
									<?php
									
									foreach($result6 as $row):
										$dates = $row['date'];
                                        $bays = $row['street_name'];
										
										
										$first = strtoupper(substr($bays, 0,3));
										
										$actuals =$row['actual'];
										
										
											?>

								

									 ["<?php echo $first ?>", <?php echo $actuals ?>],

									<?php endforeach; ?>
							],
							 color: "#2baab1"
							}];
						 // See: assets/javascripts/dashboard/custom_dashboard.js for more settings.
						</script>
					
													<!-- Flot: Sales Porto Wordpress -->
										
			
												
												</div>
					</div>
					</section>
					
											
										
				<div class="col-lg-9" data-appear-animation="bounceIn">
							
							<section class="panel">
								<header class="panel-heading">
									
						
										<h2 class="panel-title">Total Revenue </h2>
						
									</header>
								<div class="panel-body">
									<div class="row">
										<div class="col-lg-12" data-appear-animation="fadeInRightBig">
										
										<table class="table table-bordered table-striped table-condensed mb-none" id="datatable-tabletools">
					<thead>
						<tr>
							
							<th><div><?php echo get_phrase('street');?></div></th>
							<th><div><?php echo get_phrase('total');?></div></th>
							<th><div><?php echo get_phrase('actual');?></div></th>
							<th><div><?php echo get_phrase('variance');?></div></th>
							<th><div><?php echo get_phrase('period');?></div></th>
						
						</tr>
					</thead>
					<tbody>
						<?php $count = 1;foreach($result6 as $row):?>
						<tr>
							
							<td><?php echo $row['street_name'];?></td>
							<td><?php echo number_format($row['total'], 2, '.', ' ');?></td>							
							<td><?php echo number_format($row['actual'], 2, '.', ' ');?></td>
							<td><?php echo number_format($row['variance'], 2, '.', ' ');?></td>
							<td><?php echo $row['peak_hour'];?></td>
							
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
									
									
										
								
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
					
		
					
						</div>
					</div>
					<!-- end: page -->
									
									
									
						
									</div>
						
						</section>
						
						</div>
						
						</div>
	
