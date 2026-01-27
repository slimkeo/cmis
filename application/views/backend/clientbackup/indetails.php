<?php 
$edit_data		=	$this->db->get_where('marshal' , array('marshal_id' => $marshal_id) )->result_array();
?>
				<div class="row">
						<div class="col-md-12">
							<div class="tabs tabs-primary">
								<ul class="nav nav-tabs">
								
								    <li>
										<a href="#profile" data-toggle="tab">Marshal #:-  <?php echo $marshal_id ?></a>
										
									</li>
								
									<li>
										<a href="#stats" data-toggle="tab">Statistics</a>
									</li>
									<li>
										<a href="#graph" data-toggle="tab">Graph</a>
									</li>
									
									
									
									
									
								</ul>
								<div class="tab-content">
								
					

				<div id="profile" class="tab-pane active">
			<div class="panel-body">
			
			<div class="row col-md-12">		
								
			<div class="col-md-3">
		
				<div class="thumb-info mb-md">
					<img src="<?php echo $this->crud_model->get_image_url('marshal' , $marshal_id);?>" class="rounded img-responsive">
					<div class="thumb-info-title">
						<span class="thumb-info-inner">
							<?php echo $this->db->get_where('marshal' , array('marshal_id' =>  $marshal_id))->row()->name; ?>
						</span>
						<span class="thumb-info-type">
							<input type="button" value="Print Report" class="btn btn-primary" onclick="PrintDiv();" /> 
						</span>
					</div>
				</div>	
				</div>
		<div class="col-md-9">
		
		
			
		
		
		<h3>Perfomance Sheet<span> - <?php 
		
		
		$marshal =$this->db->get_where('marshal' , array('marshal_id' =>  $marshal_id))->row()->name; 
		
		
		echo $marshal;
		?>
		
		<?php
			$dayincome = $this->db->get_where( 'collections', array('marshal' => $marshal) )->result_array();
			$todayincome = 0;
			foreach ( $dayincome as $rowd ):
			$todayincome = $todayincome + $rowd[ 'actual' ] ;
			$varience = $varience + $rowd[ 'varience' ] ;
			$systemcash = $systemcash + $rowd[ 'systemcash' ] ;
			endforeach;
		 ?>
		
		</span></h3>
		
		<div class="row ">
		<div class="col-md-4">
								<h5 class="text-weight-semibold text-dark text-uppercase mb-md mt-lg">Expected Amount</h5>
								<section class="panel panel-featured-left panel-featured-primary">
									<div class="panel-body">
										<div class="widget-summary">
											<div class="widget-summary-col widget-summary-col-icon">
												<div class="summary-icon bg-primary">
													<i class="fa fa-mobile-phone"></i>
												</div>
											</div>
											<div class="widget-summary-col">
												<div class="summary">
													
													<div class="info">
														<strong class="amount"><?php echo $systemcash; ?></strong>
														<span class="text-primary">(Emalangeni)</span>
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
														<strong class="amount"><?php echo $todayincome; ?></strong>
														<span class="text-primary">(Emalangeni)</span>
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
														<strong class="amount"><?php echo $varience; ?></strong>
														<span class="text-primary">(Emalangeni)</span>
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

			
	<div class="row col-md-12">
	
	
									<div class="col-md-12">
										<h3 class="mt-lg"></h3>
										
									</div>
									<div class="col-md-12 col-xl-6">
										<section class="panel panel-featured panel-featured-primary">
											<div class="panel-body">
												<h6 style="margin-top: 0"><strong><?php echo get_phrase('actuals_statistics');?></strong></h6>
						<div class="chart chart-sm" id="flotDashSales1" style="height: 365px;"></div>

						<!-- Flot: Earning Graph -->
						<script>
							var flotDashSales1Data = [{
								data: [
									<?php
								
							
								
									$t = 0;
									
									
									
										$income = $this->db->get_where( 'collections', array('marshal' => $marshal) )->result_array();

										foreach ( $income as $row ):
										
										$month = $row[ 'month' ] ;
										
											$monthly = $this->db->get_where( 'collections', array('month' => $month, 'marshal' => $marshal) )->result_array();
										
									foreach ( $monthly as $monthly ):
									
											switch ($month) {
									
										case "Feb":
										
											$t = $monthly[ 'actual' ] ;
											$m = 'Feb';
											break;
										case "Mar":
											$t = $monthly[ 'actual' ] ;
											$m = 'Mar';
											break;
										case "Apr":
											$t = $monthly[ 'actual' ] ;
											$m = 'Apr';
											break;
										case "May":
											$t = $monthly[ 'actual' ] ;
											$m = 'May';
											break;
										case "Jun":
											$t = $monthly[ 'actual' ] ;
											$m = 'Jun';
											break;
										case "Jul":
											$t = $monthly[ 'actual' ] ;
											$m = 'Jul';
											break;
										case "Aug":
											$t = $monthly[ 'actual' ] ;
											$m = 'Aug';
											break;
										case "Sep":
											$t = $monthly[ 'actual' ] ;
											$m = 'Sep';
											break;
										case "Oct":
											$t = $monthly[ 'actual' ] ;
											$m = 'Oct';
											break;	
										
										case "Nov":
											$t = $monthly[ 'actual' ] ;
											$m = 'Nov';
											break;
										case "Dec":
											$t = $monthly[ 'actual' ] ;
											$m = 'Dec';
											break;
											
										
										default:
											
									}
										
									endforeach;

									
										
									?>

									 ["<?php echo $m ?>", <?php echo $t ?>],

									<?php endforeach; ?>
							],
							 color: "#2baab1"
							}];
						 // See: assets/javascripts/dashboard/custom_dashboard.js for more settings.
						</script>
												<hr class="solid short mt-lg">
												
											</div>
										</section>
									</div>
									
	
	</div>
	




	<div class="row col-md-12">
	<div class="table-responsive">
		
		
	
	
		
		<table class="table table-bordered table-striped table-condensed mb-none" id="datatable-tabletools">
					<thead>

						<tr>


							<th><div><?php echo get_phrase('marshal');?></div></th>
							<th><div><?php echo get_phrase('street');?></div></th>
							<th><div><?php echo get_phrase('negative');?></div></th>
							<th><div><?php echo get_phrase('captured');?></div></th>
							<th><div><?php echo get_phrase('actual');?></div></th>
							<th><div><?php echo get_phrase('varience');?></div></th>
							<th><div><?php echo get_phrase('month');?></div></th>
							<th><div><?php echo get_phrase('year');?></div></th>
						</tr>
					</thead>
					<tbody>
						<?php 
						
						
						$count = 1;
				$disks = $this->db->get_where( 'collections', array('marshal' => $marshal) )->result_array();
				foreach ( $disks as $row ): ?>
						
				
						<tr>
							<td><?php echo $row['marshal'];?></td>
							<td><?php echo $row['street'];?></td>							
							<td><?php echo $row['broughtback'];?></td>
							<td><?php echo $row['systemcash'];?></td>
							<td><?php echo $row['actual'];?></td>
							<td><?php echo $row['varience'];?></td>
							<td><?php echo $row['month'];?></td>
							<td><?php echo $row['year'];?></td>
						
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
						</div>
	
	
	</div>
		
		
	
	
						
	