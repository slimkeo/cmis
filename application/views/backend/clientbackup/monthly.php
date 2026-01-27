
<section class="panel">
<div class="panel-body">
	<div class="row">
		<div class="col-md-4"></div>
		<div class="col-md-4">
			<div class="form_group">
				<label class="control-label mb-xs"><?php echo get_phrase('Select Month');?> <span class="required">*</span></label>
	
				
			<?php
				$query = $this->db->get('inmonths');
				$indates = $query->result_array();
			?>
				<select data-plugin-selectTwo class="form-control populate" id="month" name="month" onchange="month_section(this.value)" style="width: 100%">
				<option value=""><?php echo get_phrase('select_month'); ?></option>
					<?php foreach ($indates as $row): ?>
					<option value="<?php echo $row['month']; ?>" <?php if ($date == $row[ 'month']) echo 'selected'; ?> ><?php echo $row['month']; ?></option>
					<?php endforeach; ?>
				</select>
				
				
				
			</div>
		</div>


	<br><br>

		<?php
		$query = $this->db->get_where( 'dates', array( 'month' => $month ) );
		if ( $query->num_rows() > 0 && $month != '' ):
			$capture = $query->result_array();

		
	
			?>
	

<div class="row">
	<div class="col-md-12">
	
			<?php
			$dayincome = $this->db->get_where( 'collections', array('month' => $month) )->result_array();
			$todayincome = 0;
			foreach ( $dayincome as $rowd ):
			$todayincome = $todayincome + $rowd[ 'actual' ] ;
			$systemcash = $systemcash + $rowd[ 'systemcash' ] ;
			$varience = $systemcash - $todayincome ;
			endforeach;
		 ?>
	

		<!---CONTROL TABS START-->
		<div class="tabs">
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#list" data-toggle="tab"><i class="fa fa-list"></i> 
				<?php echo get_phrase('daily_collections');?>
				</a>
			</li>
						
			<li>
				<a href="#stats" data-toggle="tab">Statistics</a>
			</li>		
			
		</ul>
		<!---CONTROL TABS END-->

		<div class="tab-content">
		
		
	
		
		<br>
			<!--TABLE LISTING STARTS-->
			<div class="tab-pane box active" id="list">
					<div class="row ">
		<div class="col-md-4">
								<h5 class="text-weight-semibold text-dark text-uppercase mb-md mt-lg">Expected Amount</h5>
								<section class="panel panel-featured-left panel-featured-primary">
									<div class="panel-body">
										<div class="widget-summary">
											<div class="widget-summary-col widget-summary-col-icon">
												<div class="summary-icon bg-primary">
													<i class="fa fa-desktop"></i>
												</div>
											</div>
											<div class="widget-summary-col">
												<div class="summary">
													
													<div class="info">
													<span class="text-primary text-uppercase">E</span>
														<strong class="amount" style="font-size:22px;"><?php echo number_format($systemcash, 2, '.', ' ')?></strong>
														
													</div>
												</div>
												<div class="summary-footer">
													<a class="text-muted text-uppercase">(view all)</a>
												</div>
											</div>
										</div>
									</div>
								</section>
						
								
						
							</div>
		<div class="col-md-4">
								<h5 class="text-weight-semibold text-dark text-uppercase mb-md mt-lg">Actual Amount</h5>
							
								<section class="panel panel-featured-left panel-featured-secondary">
									<div class="panel-body">
										<div class="widget-summary">
											<div class="widget-summary-col widget-summary-col-icon">
												<div class="summary-icon bg-tertiary">
													<i class="fa fa-money"></i>
												</div>
											</div>
											<div class="widget-summary-col">
												<div class="summary">
													
													<div class="info">
													<span class="text-primary text-uppercase">E</span>
														<strong class="amount" style="font-size:22px;"><?php echo  number_format($todayincome, 2, '.', ' ') ?></strong>
													</div>
												</div>
												<div class="summary-footer">
													<a class="text-muted text-uppercase">(Emalangeni)</a>
												</div>
											</div>
										</div>
									</div>
								</section>
						</div>
							
								<div class="col-md-4">
								<h5 class="text-weight-semibold text-dark text-uppercase mb-md mt-lg">Variance Amount</h5>
								<section class="panel panel-featured-left panel-featured-primary">
									<div class="panel-body">
										<div class="widget-summary">
											<div class="widget-summary-col widget-summary-col-icon">
												<div class="summary-icon bg-secondary">
													<i class="fa fa-minus"></i>
												</div>
											</div>
											<div class="widget-summary-col">
												<div class="summary">
													
													<div class="info">
													<span class="text-primary text-uppercase">E</span>
														<strong class="amount" style="font-size:22px;"><?php echo  number_format($varience, 2, '.', ' ') ?></strong>
														
													</div>
												</div>
												<div class="summary-footer">
													<a class="text-muted text-uppercase">(view all)</a>
												</div>
											</div>
										</div>
									</div>
								</section>
						</div>
						
		
		</div>
</div>
		
		
			<!--TABLE LISTING STARTS-->
			<div class="tab-pane box active" id="list">
			
			<table class="table table-bordered table-striped table-condensed mb-none" id="datatable-tabletools">
					<thead>
						<tr>
							<th>#</th>
							<th><div><?php echo get_phrase('marshal');?></div></th>
							<th><div><?php echo get_phrase('street');?></div></th>
							<th><div><?php echo get_phrase('negative');?></div></th>
							<th><div><?php echo get_phrase('captured');?></div></th>
							<th><div><?php echo get_phrase('actual');?></div></th>
							<th><div><?php echo get_phrase('varience');?></div></th>
							<th><div><?php echo get_phrase('date');?></div></th>
						</tr>
					</thead>
					<tbody>
						<?php 
						
						
						$count = 1;
				$disks = $this->db->get_where( 'collections', array('month' => $month) )->result_array();
				foreach ( $disks as $row ): ?>
						
				
						<tr>
							<td><?php echo $count++;?></td>
							<td><?php echo $row['marshal'];?></td>
							<td><?php echo $row['street'];?></td>							
							<td><?php echo $row['broughtback'];?></td>
							<td><?php echo $row['systemcash'];?></td>
							<td><?php echo $row['actual'];?></td>
							<td><?php echo $row['varience'];?></td>
							<td><?php echo $row['date'];?></td>
						
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			
			
			</div>
			<!--TABLE LISTING ENDS-->
			
				<!--TABLE LISTING STARTS-->
<div class="tab-pane box" id="stats">
<div class="box-content">
<div class="row">
	<div class="col-md-6 col-lg-12 col-xl-6">
		<section class="panel">
		
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-12">
					<h6 style="margin-top: 0"><strong><?php echo get_phrase('actual_cash_2023');?></strong></h6>
						<div class="chart chart-sm" id="flotDashSales1" style="height: 255px;"></div>
						
						<?php 
						
						
						$collections = $this->db->get_where( 'collections', array('month' => $month) )->result_array();
				foreach ( $collections as $row ):
				
					$street = $row['street'];
					
					
				if($street == 'Gwamile Street')
				 	$gwamile = $gwamile + $row['actual'];
				else if ( $street == 'Dzeliwe Street' )
					$dzeliwe = $dzeliwe + $row['actual'];
				else if ( $street == 'Betfusile Street' )
				 	$betfusile = $betfusile + $row['actual'];
				else if ( $street == 'Mahlokohla Street' )
				 	$mahlokohla = $mahlokohla + $row['actual'];
				else if ( $street == 'Makhosini Drive' )
				 	$makhosini = $makhosini + $row['actual'];
				else if ( $street == 'Msakato Street' )
				 	$msakato = $msakato + $row['actual'];
				else if ( $street == 'Njumbane Street' )
				 	$njumbane = $njumbane + $row['actual'];
				else if ( $street == 'Siyalu Street' )
				 	$siyalu = $siyalu + $row['actual'];
				else if ( $street == 'Teba Street' )
				 	$teba = $teba + $row['actual'];
				else if ( $street == 'Zwide Street' )
				 	$zwide = $zwide + $row['actual'];
				else if ( $street == 'Mdada Street' )
					$mdada = $mdada + $row['actual'];
				else if ( $street == 'Dabede Street' )
					$dabede = $dabede + $row['actual'];
				else if ( $street == 'CBS Street' )
					$cbs = $cbs + $row['actual'];
				else if ( $street == 'Motsa' )
					$motsa = $motsa + $row['actual'];
				else if ( $street == 'Somhlolo Road' )
					$somhlolo = $somhlolo + $row['actual'];
				else if ( $street == 'Libandla Street' )
					$libandla = $libandla + $row['actual'];
				endforeach;
						
						?>
						
						
						<!-- Flot: Earning Graph -->
						<script>
							var flotDashSales1Data = [{
								data: [
								
									 ["GWA", <?php echo $gwamile ?>],
									 ["DZE", <?php echo $dzeliwe ?>],
									 ["BET", <?php echo $betfusile ?>],
									 ["MAH", <?php echo $mahlokohla ?>],
									 ["MAK", <?php echo $makhosini ?>],
									 ["NJU", <?php echo $njumbane ?>],
									 ["SIY", <?php echo $siyalu ?>],
									 ["SOM", <?php echo $somhlolo ?>],
									 ["TEB", <?php echo $teba ?>],
									 ["ZWI", <?php echo $zwide ?>],
									 ["MDA", <?php echo $mdada ?>],
									 ["DAB", <?php echo $dabede ?>],
									 ["CBS", <?php echo $cbs ?>],
									 ["OBR", <?php echo $motsa ?>],
									 ["LIB", <?php echo $libandla ?>],


									
							],
							 color: "#2baab1"
							}];
						 // See: assets/javascripts/dashboard/custom_dashboard.js for more settings.
						</script>

					</div>
					
				</div>
			</div>
		</section>
	</div>
			
			
			</div>
			<!--TABLE LISTING ENDS-->
			
		
	
		<?php endif;?>
	</div>
	
</section>

</div>
	



<script type="text/javascript">
	function month_section( month ) {
		window.location.href = '<?php echo base_url(); ?>index.php?admin/monthly/' + month;
	}
</script>