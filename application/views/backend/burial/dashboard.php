<?php 
	$current_year=date("Y");
	$year=$current_year;
	
	// Total Claims count
	$this->db->where('created_at >=', $year . '-01-01');
	$this->db->where('created_at <=', $year . '-12-31');
	$this->db->from('claims');
	$total_claims = $this->db->count_all_results();

	// Total Claims Amount (sum of all claims)
	$this->db->where('created_at >=', $year . '-01-01');
	$this->db->where('created_at <=', $year . '-12-31');
	$this->db->select_sum('amount');
	$query = $this->db->get('claims'); 
	$claims_amount = $query->row()->amount;
	if($claims_amount==NULL){$claims_amount=0;}

	// Total Statements Amount
	$this->db->where('created_at >=', $year . '-01-01');
	$this->db->where('created_at <=', $year . '-12-31');
	$this->db->select_sum('amount');
	$query = $this->db->get('statements'); 
	$statements_amount = $query->row()->amount;
	if($statements_amount==NULL){$statements_amount=0;}
	
	// Approved Claims Amount
	$this->db->where('created_at >=', $year . '-01-01');
	$this->db->where('created_at <=', $year . '-12-31');
	$this->db->where('status','approved');
	$this->db->select_sum('amount');
	$query = $this->db->get('claims'); 
	$approved_claims = $query->row()->amount;
	if($approved_claims==NULL){$approved_claims=0;}

	// Pending Claims Amount
	$this->db->where('created_at >=', $year . '-01-01');
	$this->db->where('created_at <=', $year . '-12-31');
	$this->db->where('status','pending');
	$this->db->select_sum('amount');
	$query = $this->db->get('claims'); 
	$pending_claims =$query->row()->amount;
	if($pending_claims ==NULL){$pending_claims=0;};
	
	// Total Statements count
	$this->db->where('created_at >=', $year . '-01-01');
	$this->db->where('created_at <=', $year . '-12-31');
	$this->db->from('statements');
	$total_statements = $this->db->count_all_results();

	// Calculate variance
	$variance = $statements_amount-$claims_amount;

?>
			
		<div class="row">
		
								
	<div class="col-md-3" data-appear-animation="bounceInUp">
		
		<section class="panel panel-featured-left panel-featured-primary">
			<div class="panel-body">
				<div class="widget-summary widget-summary-sm">
					<div class="widget-summary-col widget-summary-col-icon">
						<div class="summary-icon bg-primary">
							<i class="fa fa-file-text"></i>
						</div>
					</div>
					<div class="widget-summary-col">
						<div class="summary">
							<h4 class="title">Claims</h4>
							<div class="info">
								
								<strong class="amount"><?php echo $total_claims; ?></strong>
								<span class="text-primary text-uppercase"><?php echo $current_year;?></span>
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
							<h4 class="title">Claims Amount</h4>
							<div class="info">
								<span class="text-success text-uppercase">E</span>
								<strong class="amount"><?php echo number_format($claims_amount, 2, '.', ' ') ?></strong>
								
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
							<h4 class="title">Subscriptions Amount</h4>
							<div class="info">
								<span class="text-info text-uppercase">E</span>
								<strong class="amount"> <?php echo number_format($statements_amount, 2, '.', ' ') ?></strong>
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
							<h4 class="title">Claims vs Subscriptions</h4>
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
			
				
					<div class="col-lg-7" data-appear-animation="bounceIn">
						
						<section class="panel">
							<header class="panel-heading">
								
					
									<h2 class="panel-title">Claims vs Subscriptions Chart </h2>
					
								</header>
							<div class="panel-body">
								<div class="row">
									<div class="col-lg-12" data-appear-animation="fadeInRightBig">
										
																	
										<!-- Morris: Line -->
									<div class="chart chart-md" id="morrisLine"></div>
									<script type="text/javascript">
										<?php
										$approved_claims=0;
										$statements_amount=0;
										$variance=0;
										
										?>
										
										var morrisLineData = [
											<?php		for ($m=1; $m<=12; $m++): 
												$timestamp = mktime(0, 0, 0, $m, 1, $year);
													// Format the timestamp to get the month and year
													$month = date('F', $timestamp); // Full month name (e.g., "May")
													$year = date('Y', $timestamp);  // Year (e.g., "2023")

														// Format the timestamp to get the start date in "Y-m-d" format
													$startdated = date('Y-m-d', $timestamp);  // Start date (e.g., "2023-05-01")

													// Calculate the last day of the same month
													$endTimestamp = mktime(0, 0, 0, $m + 1, 0, $year);

													// Format the timestamp to get the end date in "Y-m-d" format
													$enddated = date('Y-m-d', $endTimestamp);  // End date (e.g., "2023-05-31")

												$this->db->where('created_at >=',$startdated);
												$this->db->where('created_at <=',$enddated);
												$this->db->select_sum('amount');
												$query = $this->db->get('statements');
												$monthly_statements = $query->row()->amount;
												if($monthly_statements==NULL){$monthly_statements=0;}
												
												$this->db->where('created_at >=',$startdated);
												$this->db->where('created_at <=',$enddated);
												$this->db->select_sum('amount');
												$query = $this->db->get('claims'); 
												$monthly_claims = $query->row()->amount;
												if($monthly_claims==NULL){$monthly_claims=0;}

												$approved_claims=$approved_claims+$monthly_claims;
												$statements_amount=$statements_amount+$monthly_statements;
												$variance = $monthly_claims - $monthly_statements;
														
													?>
      										  {
         										   y: '<?php echo $startdated; ?>',
         										   a: <?php echo $monthly_statements; ?>,
          										  b: <?php echo $monthly_claims; ?>
        										}<?php if ($m!=12) echo ','; ?>
    										<?php endfor; ?>
										];
					
										// See: assets/javascripts/ui-elements/examples.charts.js for more settings.
					
									</script>
					
									
				
				
								<hr class="solid short mt-lg">
											<div class="row">
												<div class="col-md-4">
													<div class="h4 text-weight-bold mb-none mt-lg">E <?php echo number_format($statements_amount, 2, '.', ' ') ?></div>
													<p class="text-xs text-primary mb-none">Statements Total</p>
												</div>
												<div class="col-md-4">
													<div class="h4 text-weight-bold mb-none mt-lg">E <?php echo number_format($approved_claims, 2, '.', ' ') ?></div>
													<p class="text-xs text-primary mb-none">Claims Total</p>
												</div>
												<div class="col-md-4">
													<div class="h4 text-weight-bold mb-none mt-lg">E <?php echo number_format($approved_claims-$statements_amount, 2, '.', ' ') ?></div>
													<p class="text-xs text-primary mb-none">Variance</p>
												</div>
											</div>
											
											</div>
									</div>
				</section>
				
				</div>
				
				<div class="col-lg-5" data-appear-animation="bounceInLeft">
						<section class="panel">
						
						<header class="panel-heading">
								<div class="panel-actions">
								</div>
				
								<h2 class="panel-title">Subscriptions Count - <?php echo $year ?></h2>
							</header>	
										<div class="panel-body">
											<div class="chart chart-sm" id="flotDashSales1" style="height: 352px;"></div>

						<!-- Flot: Earning Graph -->
						<script>
							
	var flotDashSales1Data = [{
		 data: [
			<?php		for ($m=1; $m<=12; $m++):
												$timestamp = mktime(0, 0, 0, $m, 1, $year);
												// Format the timestamp to get the month and year
												$month = date('F', $timestamp); // Full month name (e.g., "May")
												$year = date('Y', $timestamp);  // Year (e.g., "2023")

													// Format the timestamp to get the start date in "Y-m-d" format
												$startdated = date('Y-m-d', $timestamp);  // Start date (e.g., "2023-05-01")

													// Calculate the last day of the same month
												$endTimestamp = mktime(0, 0, 0, $m + 1, 0, $year);

													// Format the timestamp to get the end date in "Y-m-d" format
												$enddated = date('Y-m-d', $endTimestamp);  // End date (e.g., "2023-05-31")

											$this->db->where('created_at >=',$startdated);
											$this->db->where('created_at <=',$enddated);
											$this->db->from('statements');
											$statements_count = $this->db->count_all_results();
											
											?>
				['<?php echo substr($month,0, 3); ?>', <?php echo $statements_count ?>],					
				<?php endfor; ?>
				     ],
				color: "#2baab1"
		        }];
				</script>
												
														<hr class="solid short mt-lg">
											<div class="row">
												<div class="col-md-3">
													<div class="h4 text-weight-bold mb-none mt-lg"><?php echo $total_statements; ?></div>
													<p class="text-xs text-primary mb-none">Total Statements</p>
												</div>
											</div>
											
											
										</div>
									</section>
					</div>
					
					
				<hr class="solid short mt-lg">
				
										
										
				
						
		</div>			
									
						
						
									
						
				
	
					<!-- start: Claims vs Statements -->
				<div class="row">
					<div class="col-md-12 col-lg-12">
						<section class="panel panel-featured panel-featured-primary">
							<div class="panel-body">
							
							<header class="panel-heading panel-transparent">
							
				
								<h2 class="panel-title">Claims / Subscriptions - <?php $current_year; ?></h2>
							</header>
								
								<div class="row">
						<div class="col-lg-8">
						<section class="panel">
								
								<div class="panel-body">
					
								
		
										<!-- Morris: Area -->
									<div class="chart chart-md" id="morrisStacked"></div>
									
								<script type="text/javascript">
									var morrisStackedData = [
											<?php		for ($m=1; $m<=12; $m++): 
												$timestamp = mktime(0, 0, 0, $m, 1, $year);
													// Format the timestamp to get the month and year
													$month = date('F', $timestamp); // Full month name (e.g., "May")
													$year = date('Y', $timestamp);  // Year (e.g., "2023")

														// Format the timestamp to get the start date in "Y-m-d" format
													$startdated = date('Y-m-d', $timestamp);  // Start date (e.g., "2023-05-01")

														// Calculate the last day of the same month
													$endTimestamp = mktime(0, 0, 0, $m + 1, 0, $year);

														// Format the timestamp to get the end date in "Y-m-d" format
													$enddated = date('Y-m-d', $endTimestamp);  // End date (e.g., "2023-05-31")

												$this->db->where('created_at >=',$startdated);
												$this->db->where('created_at <=',$enddated);
												$this->db->select_sum('amount');
												$query = $this->db->get('statements');
												$monthly_statements = $query->row()->amount;
												if($monthly_statements==NULL){$monthly_statements=0;}
												
												$this->db->where('created_at >=',$startdated);
												$this->db->where('created_at <=',$enddated);
												$this->db->select_sum('amount');
												$query = $this->db->get('claims'); 
												$monthly_claims = $query->row()->amount;
												if($monthly_claims==NULL){$monthly_claims=0;}

													$approved_claims=$approved_claims+$monthly_claims;
													$statements_amount=$statements_amount+$monthly_statements;
													$variance = $monthly_claims - $monthly_statements;
													

													
												?>
      										  {
         										   y: '<?php echo $startdated; ?>',
         										   a: <?php echo $monthly_statements; ?>,
          										  b: <?php echo $monthly_claims; ?>
        										}<?php if ($m!=12) echo ','; ?>
    										<?php endfor; ?>
										];
					
										// See: assets/javascripts/ui-elements/examples.charts.js for more settings.
					
									</script>
									
									
									
					
						<hr class="solid short mt-lg">
											<div class="row">
												<div class="col-md-4">
													<div class="h4 text-weight-bold mb-none mt-lg">E <?php echo number_format($statements_amount, 2, '.', ' ') ?></div>
													<p class="text-xs text-primary mb-none">Subscriptions Total</p>
												</div>
												<div class="col-md-4">
													<div class="h4 text-weight-bold mb-none mt-lg">E <?php echo number_format($approved_claims, 2, '.', ' ') ?></div>
													<p class="text-xs text-primary mb-none">Claims Total</p>
												</div>
												<div class="col-md-4">
													<div class="h4 text-weight-bold mb-none mt-lg">E <?php echo number_format($approved_claims-$statements_amount, 2, '.', ' ') ?></div>
													<p class="text-xs text-primary mb-none">Variance</p>
												</div>
											</div>
					
					
					
								</div>
							</section>
						</div>
				
					
					
					<div class="col-lg-4" data-appear-animation="bounceInLeft">
					
					<div class="panel-body">
					
						<!-- Morris: Donut -->
									<div class="chart chart-md" id="morrisDonut"></div>
									<script type="text/javascript">
					
										var morrisDonutData = [
											<?php		for ($m=1; $m<=12; $m++): 
												$timestamp = mktime(0, 0, 0, $m, 1, $year);
													// Format the timestamp to get the month and year
													$month = date('F', $timestamp); // Full month name (e.g., "May")
													$year = date('Y', $timestamp);  // Year (e.g., "2023")

														// Format the timestamp to get the start date in "Y-m-d" format
													$startdated = date('Y-m-d', $timestamp);  // Start date (e.g., "2023-05-01")

														// Calculate the last day of the same month
													$endTimestamp = mktime(0, 0, 0, $m + 1, 0, $year);

														// Format the timestamp to get the end date in "Y-m-d" format
													$enddated = date('Y-m-d', $endTimestamp);  // End date (e.g., "2023-05-31")

												$this->db->where('created_at >=',$startdated);
												$this->db->where('created_at <=',$enddated);
												$this->db->select_sum('amount');
												$query = $this->db->get('claims');
												$monthly_claims = $query->row()->amount;
												if($monthly_claims==NULL){$monthly_claims=0;}
												
													
												?>
										{
											label: "<?php echo $month; ?>",
											value: "<?php echo $monthly_claims ?>"
										}, 
    										<?php endfor; ?>
										];
					
										// See: assets/javascripts/ui-elements/examples.charts.js for more settings.
					
									</script>
					
					</div>
				</div>
				
			</div>
									
							</div>
							
						</section>
					</div>
				</div>

<?php
$past7date = date('Y-m-d', strtotime('-7 days')); // Get the date from 7 days ago

$this->db->where('created_at >=', $past7date);
$this->db->where('created_at <=', date('Y-m-d')); // Up to today
$this->db->order_by('created_at', 'DESC'); // Order by recent
$claims_query = $this->db->get('claims');
$recent_claims = $claims_query->result_array();
?>
<div class="row">
	<!-- RECENT CLAIMS -->
	<div class="col-md-7" data-appear-animation="bounceIn">
		<section class="panel">
			<header class="panel-heading">
				<h2 class="panel-title">Recent Claims (Last 7 Days)</h2>
			</header>
			<div class="panel-body">
				<div class="scrollable" data-plugin-scrollable style="height: 450px;">
					<div class="scrollable-content">
					<?php
						foreach ($recent_claims as $row) {
							$member = $this->db->get_where('members', ['id' => $row['member_id']])->row_array();
						?>
						<div class="col-md-12" data-appear-animation="bounceInUp">		
							<section class="panel panel-featured-left panel-featured-primary">
								<div class="panel-body">
									<div class="widget-summary widget-summary-sm">
										<div class="widget-summary-col widget-summary-col-icon">
											<div class="summary-icon bg-primary">
												<i class="fa fa-file-text"></i>
											</div>
										</div>
										<div class="widget-summary-col">
											<div class="summary">
												<h4 class="title"><?php echo ($member) ? $member['name'] : 'N/A'; ?></h4>
												<div class="info">
													<span class="text-primary text-uppercase"><?php echo ucfirst($row['status']); ?></span>
													<strong class="amount">E <?php echo number_format($row['amount'], 2, '.', ' ') ?></strong>
													
												</div>
											</div>
										</div>
									</div>
								</div>
							</section>
						</div>
					<?php } ?>
					</div>
				</div>
			</div>
		</section>
	</div>
	
	<div class="col-md-5">
		<section class="panel">
		<header class="panel-heading">
			<div class="panel-actions"></div>
				<h2 class="panel-title">Summary</h2>
		</header>	
			<div class="panel-body">
			
			<div class="scrollable" data-plugin-scrollable style="height: 450px;">
				<div class="scrollable-content">
					<div class="row">
						<div class="col-md-12" data-appear-animation="bounceInUp">
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
												<h4 class="title">Total Claims</h4>
												<div class="info">
													<strong class="amount">E <?php echo number_format($claims_amount, 2, '.', ' ');?></strong><br/>
													<span class="text-primary text-uppercase"><?php echo $current_year;?></span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</section>
						</div>

						<div class="col-md-12" data-appear-animation="bounceInUp">
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
												<h4 class="title">Total Subscriptions</h4>
												<div class="info">
													<strong class="amount">E <?php echo number_format($statements_amount, 2, '.', ' ');?></strong><br/>
													<span class="text-primary text-uppercase"><?php echo $current_year;?></span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</section>
						</div>

						<div class="col-md-12" data-appear-animation="bounceInUp">
							<section class="panel panel-featured-left panel-featured-secondary">
								<div class="panel-body">
									<div class="widget-summary widget-summary-sm">
										<div class="widget-summary-col widget-summary-col-icon">
											<div class="summary-icon bg-secondary">
												<i class="fa fa-exchange"></i>
											</div>
										</div>
										<div class="widget-summary-col">
											<div class="summary">
												<h4 class="title">Variance</h4>
												<div class="info">
													<strong class="amount">E <?php echo number_format($variance, 2, '.', ' ');?></strong><br/>
													<span class="text-primary text-uppercase"><?php echo $current_year;?></span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</section>
						</div>
					</div>
				</div>
			</div>
			</div>
		</section>
	</div>
</div>
