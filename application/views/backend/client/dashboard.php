<?php 
	$current_year=date("Y");
	$year=$current_year;
	$client_id=$this->session->userdata('client_id');



	$this->db->from('transaction');
	$this->db->join('account', 'account.id = transaction.account_id');
	$this->db->where('account.client_id', $client_id);
	$this->db->where('transaction.createdate >=', $year . '-01-01');
	$this->db->where('transaction.createdate <=', $year . '-12-31');
	$transactions = $this->db->count_all_results();

	$this->db->select_sum('transaction.amount');
	$this->db->from('transaction');
	$this->db->join('account', 'account.id = transaction.account_id');
	$this->db->where('account.client_id', $client_id);
	$this->db->where('transaction.createdate >=', $year . '-01-01');
	$this->db->where('transaction.createdate <=', $year . '-12-31');
	$this->db->where('transaction.type', 'loan_disbursement');

	$query = $this->db->get();
	$loaned = $query->row()->amount ?? 0;

	$this->db->select_sum('transaction.amount');
	$this->db->from('transaction');
	$this->db->join('account', 'account.id = transaction.account_id');
	$this->db->where('account.client_id', $client_id);
	$this->db->where('transaction.createdate >=', $year . '-01-01');
	$this->db->where('transaction.createdate <=', $year . '-12-31');
	$this->db->where('transaction.type', 'loan_repayment');

	$query = $this->db->get();
	$returned = $query->row()->amount;
	
	$this->db->select_sum('transaction.amount');
	$this->db->from('transaction');
	$this->db->join('account', 'account.id = transaction.account_id');
	$this->db->where('account.client_id', $client_id);
	$this->db->where('transaction.createdate >=', $year . '-01-01');
	$this->db->where('transaction.createdate <=', $year . '-12-31');
	$this->db->where('transaction.type', 'deposit');

	$query = $this->db->get();
	$cashplus = $query->row()->amount;
	if ($cashplus === NULL) {
	    $cashplus = 0;
	}

	$this->db->select_sum('transaction.amount');
	$this->db->from('transaction');
	$this->db->join('account', 'account.id = transaction.account_id');
	$this->db->where('account.client_id', $client_id);
	$this->db->where('transaction.createdate >=', $year . '-01-01');
	$this->db->where('transaction.createdate <=', $year . '-12-31');
	$this->db->where('transaction.type', 'withdrawal');

	$query = $this->db->get();
	$cashminus = $query->row()->amount;
	if ($cashminus === NULL) {
	    $cashminus = 0;
	}
	$this->db->select_sum('transaction.amount');
	$this->db->from('transaction');
	$this->db->join('account', 'account.id = transaction.account_id');
	$this->db->where('account.client_id', $client_id);
	$this->db->where('transaction.createdate >=', $year . '-01-01');
	$this->db->where('transaction.createdate <=', $year . '-12-31');
	$this->db->where('transaction.type', 'transfer');

	$query = $this->db->get();
	$cashtransfer = $query->row()->amount;
	if ($cashtransfer === NULL) {
	    $cashtransfer = 0;
	}

		//$income=$returned+$cashplus;
		//$outgoing=$loaned+$cashminus;
		$total=$cashplus+$cashminus;
		$variance = $cashplus - $cashminus;
		


?>
			
			<div class="row">
			
									
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
							<h4 class="title"><?php echo get_phrase('transactions');?></h4>
							<div class="info">
								
								<strong class="amount"><?php echo $transactions; ?></strong>
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
							<i class="fa fa-desktop"></i>
						</div>
					</div>
					<div class="widget-summary-col">
						<div class="summary">
							<h4 class="title">Money Coming In (Inflow)</h4>
							<div class="info">
								<span class="text-success text-uppercase">E</span>
								<strong class="amount"><?php echo number_format($cashplus, 2, '.', ' ') ?></strong>
								
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
							<h4 class="title">Money Going Out (Outflow)</h4>
							<div class="info">
								<span class="text-info text-uppercase">E</span>
								<strong class="amount"> <?php echo number_format($cashminus, 2, '.', ' ') ?></strong>
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
									
						
										<h2 class="panel-title">Total Revenue Chart </h2>
						
									</header>
								<div class="panel-body">
									<div class="row">
										<div class="col-lg-12" data-appear-animation="fadeInRightBig">
											
																		
											<!-- Morris: Line -->
										<div class="chart chart-md" id="morrisLine"></div>
										<script type="text/javascript">
											<?php
											$variance=0;
											$loaned=0;
											$returned=0;
											
											?>
											
											var morrisLineData = [
												<?php		for ($m=1; $m<=12; $m++): 
													$timestamp = mktime(0, 0, 0, $m, 1, $year);
														// Format the timestamp to get the month and year
														$month = date('F', $timestamp); // Full month name (e.g., "May")
														$year = date('Y', $timestamp);  // Year (e.g., "2023")

															// Format the timestamp to get the start createdate in "Y-m-d" format
														$startdated = date('Y-m-d', $timestamp);  // Start createdate (e.g., "2023-05-01")

														// Calculate the last day of the same month
														$endTimestamp = mktime(0, 0, 0, $m + 1, 0, $year);

														// Format the timestamp to get the end createdate in "Y-m-d" format
														$enddated = date('Y-m-d', $endTimestamp);  // End createdate (e.g., "2023-05-31")	 || $cashminus==NULL && $cashplus==NULL || $variance==NULL){												
														$this->db->from('transaction');
														$this->db->join('account', 'account.id = transaction.account_id');
														$this->db->where('account.client_id', $client_id);
														$this->db->where('transaction.createdate >=', $startdated);
														$this->db->where('transaction.createdate <=', $enddated);

														$transactions = $this->db->count_all_results();
														
														$this->db->select_sum('transaction.amount');
														$this->db->from('transaction');
														$this->db->join('account', 'account.id = transaction.account_id');
														$this->db->where('account.client_id', $client_id);
														$this->db->where('transaction.createdate >=', $startdated);
														$this->db->where('transaction.createdate <=', $enddated);
														$this->db->where('transaction.type', 'deposit');

														$query = $this->db->get();
														$cashplus = $query->row()->amount;
														if ($cashplus === NULL) {
														    $cashplus = 0;
														}
														$this->db->select_sum('transaction.amount');
														$this->db->from('transaction');
														$this->db->join('account', 'account.id = transaction.account_id');
														$this->db->where('account.client_id', $client_id);
														$this->db->where('transaction.createdate >=', $startdated);
														$this->db->where('transaction.createdate <=', $enddated);
														$this->db->where_in('transaction.type', ['withdrawal', '-']); // Accepts either

														$query = $this->db->get();
														$cashminus = $query->row()->amount;

														if ($cashminus === NULL) {
														    $cashminus = 0;
														}
																												
															$loaned=$loaned+$cashplus;
															$returned=$returned+$cashminus;
															$total=$cashplus+$cashminus;
															$variance = $cashplus - $cashminus;
															
															
														
													?>
      											  {
         											   y: '<?php echo $startdated; ?>',
         											   a: <?php echo $cashminus; ?>,
          											  b: <?php echo $cashplus; ?>
        											}<?php if ($m!=12) echo ','; ?>
    											<?php endfor; ?>
											];
						
											// See: assets/javascripts/ui-elements/examples.charts.js for more settings.
						
										</script>
						
										
					
					
									<hr class="solid short mt-lg">
												<div class="row">
													<div class="col-md-4">
														<div class="h4 text-weight-bold mb-none mt-lg">E <?php echo number_format($loaned, 2, '.', ' ') ?></div>
														<p class="text-xs text-primary mb-none">Income Cash </p>
													</div>
													<div class="col-md-4">
														<div class="h4 text-weight-bold mb-none mt-lg">E <?php echo number_format($returned, 2, '.', ' ') ?></div>
														<p class="text-xs text-primary mb-none">returned Cash</p>
													</div>
													<div class="col-md-4">
														<div class="h4 text-weight-bold mb-none mt-lg">E <?php echo number_format($returned-$loaned, 2, '.', ' ') ?></div>
														<p class="text-xs text-primary mb-none">Variance Cash</p>
													</div>
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
					
									<h2 class="panel-title">transaction - <?php echo $year ?></h2>
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

														// Format the timestamp to get the start createdate in "Y-m-d" format
													$startdated = date('Y-m-d', $timestamp);  // Start createdate (e.g., "2023-05-01")

													// Calculate the last day of the same month
													$endTimestamp = mktime(0, 0, 0, $m + 1, 0, $year);

													// Format the timestamp to get the end createdate in "Y-m-d" format
													$enddated = date('Y-m-d', $endTimestamp);  // End createdate (e.g., "2023-05-31")	 || $cashminus==NULL && $cashplus==NULL || $variance==NULL){												
												
													// Count all transactions with joins
													$this->db->from('transaction');
													$this->db->join('account', 'account.id = transaction.account_id');
													$this->db->where('account.client_id', $client_id);
													$this->db->where('transaction.createdate >=', $startdated);
													$this->db->where('transaction.createdate <=', $enddated);
													$transactions = $this->db->count_all_results();

													// Sum deposits
													$this->db->select_sum('transaction.amount');
													$this->db->from('transaction');
													$this->db->join('account', 'account.id = transaction.account_id');
													$this->db->where('account.client_id', $client_id);
													$this->db->where('transaction.createdate >=', $startdated);
													$this->db->where('transaction.createdate <=', $enddated);
													$this->db->where('transaction.type', 'deposit');
													$query = $this->db->get(); 
													$cashplus = $query->row()->amount;
													if ($cashplus === NULL) { $cashplus = 0; }

													// Sum withdrawals (including possible "-")
													$this->db->select_sum('transaction.amount');
													$this->db->from('transaction');
													$this->db->join('account', 'account.id = transaction.account_id');
													$this->db->where('account.client_id', $client_id);
													$this->db->where('transaction.createdate >=', $startdated);
													$this->db->where('transaction.createdate <=', $enddated);
													$this->db->where_in('transaction.type', ['withdrawal', '-']);
													$query = $this->db->get(); 
													$cashminus = $query->row()->amount;
													if ($cashminus === NULL) { $cashminus = 0; }
													
														$loaned=$loaned+$cashplus;
														$returned=$returned+$cashminus;
														$total=$cashplus+$cashminus;
														$variance = $cashplus - $cashminus;

													$transactions=$transactions+$transactions;
													
												?>
					['<?php echo substr($month,0, 3); ?>', <?php echo $transactions ?>],					
					<?php endfor; ?>
					     ],
					color: "#2baab1"
			        }];
					</script>
													
															<hr class="solid short mt-lg">
												<div class="row">
													<div class="col-md-3">
														<div class="h4 text-weight-bold mb-none mt-lg"><?php echo $transactions; ?></div>
														<p class="text-xs text-primary mb-none">All Transactions</p>
													</div>
													<!-- <div class="col-md-3">
														<div class="h4 text-weight-bold mb-none mt-lg">30145</div>
														<p class="text-xs text-primary mb-none">1 Hour</p>
													</div>
													<div class="col-md-3">
														<div class="h4 text-weight-bold mb-none mt-lg">5997</div>
														<p class="text-xs text-primary mb-none">2 Hours</p>
													</div>
													<div class="col-md-3">
														<div class="h4 text-weight-bold mb-none mt-lg">19053</div>
														<p class="text-xs text-primary mb-none">All Day</p>
													</div> -->
												</div>
												
												
											</div>
										</section>
						</div>
						
						
					<hr class="solid short mt-lg">
					
											
											
					
							
			</div>			
										
							
							
										
							
					
				
	
						<!-- start: 2023 Collections -->
					<div class="row">
						<div class="col-md-12 col-lg-12">
							<section class="panel panel-featured panel-featured-primary">
								<div class="panel-body">
								
								<header class="panel-heading panel-transparent">
								
					
									<h2 class="panel-title">Outflow / Inflow - <?php $current_year; ?></h2>
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

															// Format the timestamp to get the start createdate in "Y-m-d" format
														$startdated = date('Y-m-d', $timestamp);  // Start createdate (e.g., "2023-05-01")

														// Calculate the last day of the same month
														$endTimestamp = mktime(0, 0, 0, $m + 1, 0, $year);

														// Format the timestamp to get the end createdate in "Y-m-d" format
														$enddated = date('Y-m-d', $endTimestamp);  // End createdate (e.g., "2023-05-31")	 || $cashminus==NULL && $cashplus==NULL || $variance==NULL){												
													
														// Count all transactions (with joins)
														$this->db->from('transaction');
														$this->db->join('account', 'account.id = transaction.account_id');
														$this->db->where('account.client_id', $client_id);
														$this->db->where('transaction.createdate >=', $startdated);
														$this->db->where('transaction.createdate <=', $enddated);
														$transactions = $this->db->count_all_results();

														// Sum of deposits (with joins)
														$this->db->select_sum('transaction.amount');
														$this->db->from('transaction');
														$this->db->join('account', 'account.id = transaction.account_id');
														$this->db->where('account.client_id', $client_id);
														$this->db->where('transaction.createdate >=', $startdated);
														$this->db->where('transaction.createdate <=', $enddated);
														$this->db->where('transaction.type', 'deposit');
														$query = $this->db->get(); 
														$cashplus = $query->row()->amount;
														if ($cashplus == NULL) { $cashplus = 0; }

														// Sum of withdrawals (with joins, checking for both 'withdrawal' and '-')
														$this->db->select_sum('transaction.amount');
														$this->db->from('transaction');
														$this->db->join('account', 'account.id = transaction.account_id');
														$this->db->where('account.client_id', $client_id);
														$this->db->where('transaction.createdate >=', $startdated);
														$this->db->where('transaction.createdate <=', $enddated);
														$this->db->where_in('transaction.type', ['withdrawal', '-']);
														$query = $this->db->get(); 
														$cashminus = $query->row()->amount;
														if ($cashminus == NULL) { $cashminus = 0; }

															$loaned=$loaned+$cashplus;
															$returned=$returned+$cashminus;
															$total=$cashplus+$cashminus;
															$variance = $cashplus - $cashminus;
															

														
													?>
      											  {
         											   y: '<?php echo $startdated; ?>',
         											   a: <?php echo $cashminus; ?>,
          											  b: <?php echo $cashplus; ?>
        											}<?php if ($m!=12) echo ','; ?>
    											<?php endfor; ?>
											];
						
											// See: assets/javascripts/ui-elements/examples.charts.js for more settings.
						
										</script>
										
										
										
						
							<hr class="solid short mt-lg">
												<div class="row">
													<div class="col-md-4">
														<div class="h4 text-weight-bold mb-none mt-lg">E <?php echo number_format($loaned, 2, '.', ' ') ?></div>
														<p class="text-xs text-primary mb-none">Income Cash </p>
													</div>




													<div class="col-md-4">
														<div class="h4 text-weight-bold mb-none mt-lg">E <?php echo number_format($cashplus, 2, '.', ' ') ?></div>
														<p class="text-xs text-primary mb-none">returned Cash</p>
													</div>
													<div class="col-md-4">
														<div class="h4 text-weight-bold mb-none mt-lg">E <?php echo number_format($cashminus, 2, '.', ' ') ?></div>
														<p class="text-xs text-primary mb-none">Variance Cash</p>
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

															// Format the timestamp to get the start createdate in "Y-m-d" format
														$startdated = date('Y-m-d', $timestamp);  // Start createdate (e.g., "2023-05-01")

														// Calculate the last day of the same month
														$endTimestamp = mktime(0, 0, 0, $m + 1, 0, $year);

														// Format the timestamp to get the end createdate in "Y-m-d" format
														$enddated = date('Y-m-d', $endTimestamp);  // End createdate (e.g., "2023-05-31")	 || $cashminus==NULL && $cashplus==NULL || $variance==NULL){												
													
															// Count all transactions (with account & client join)
															$this->db->from('transaction');
															$this->db->join('account', 'account.id = transaction.account_id');
															$this->db->where('account.client_id', $client_id);
															$this->db->where('transaction.createdate >=', $startdated);
															$this->db->where('transaction.createdate <=', $enddated);
															$transactions = $this->db->count_all_results();

															// Total Deposits (with account & client join)
															$this->db->select_sum('transaction.amount');
															$this->db->from('transaction');
															$this->db->join('account', 'account.id = transaction.account_id');
															$this->db->where('account.client_id', $client_id);
															$this->db->where('transaction.createdate >=', $startdated);
															$this->db->where('transaction.createdate <=', $enddated);
															$this->db->where('transaction.type', 'deposit');
															$query = $this->db->get(); 
															$cashplus = $query->row()->amount;
															if ($cashplus == NULL) { $cashplus = 0; }

															// Total Withdrawals (with account & client join)
															$this->db->select_sum('transaction.amount');
															$this->db->from('transaction');
															$this->db->join('account', 'account.id = transaction.account_id');
															$this->db->where('account.client_id', $client_id);
															$this->db->where('transaction.createdate >=', $startdated);
															$this->db->where('transaction.createdate <=', $enddated);
															$this->db->where('transaction.type', 'withdrawal');
															$query = $this->db->get(); 
															$cashminus = $query->row()->amount;
															if ($cashminus == NULL) { $cashminus = 0; }
														
															$loaned=$loaned+$cashplus;
															$returned=$returned+$cashminus;
															$total=$cashplus+$cashminus;
															$variance = $cashplus - $cashminus;

														
													?>
											{
												label: "<?php echo $month; ?>",
												value: "<?php echo $cashminus ?>"
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
							

					
<div class="row">

    <!-- CALENDAR-->
	<div class="col-md-7" data-appear-animation="bounceIn">
		<section class="panel">
			<header class="panel-heading">
				<h2 class="panel-title">
				<?php echo get_phrase('event_schedule');?>	
				</h2>
			</header>
			<div class="panel-body">
				<div id="notice_calendar"></div>
			</div>
		</section>
	</div>
	


	
<div class="col-md-5">
	<section class="panel">
	<header class="panel-heading">
		<div class="panel-actions"></div>
			<h2 class="panel-title"><?php echo get_phrase('this_transactions_amount');?></h2>
	</header>	
		<div class="panel-body">
		
		<div class="scrollable" data-plugin-scrollable style="height: 450px;">
	<div class="scrollable-content">

	<?php
		$past7date = date('Y-m-d', strtotime('-7 days')); // Get the date from 7 days ago

		$this->db->select('transaction.*'); // You can add more fields
		$this->db->from('transaction');
		$this->db->join('account', 'account.id = transaction.account_id');
		$this->db->where('account.client_id', $client_id);
		$this->db->where('transaction.createdate >=', $past7date);
		$this->db->where('transaction.createdate <=', date('Y-m-d')); // Up to today
		$this->db->order_by('transaction.createdate', 'DESC'); // Order by recent transactions
		$query = $this->db->get();

		$transactions = $query->result_array();
   // echo $past7date . "<br>";
		foreach ($transactions as $row) {
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
							<h4 class="title"><?php echo get_phrase
							($row['type']); ?></h4>
							<div class="info">
								<span class="text-primary text-uppercase"><?php echo ucfirst($row['timestamp']); ?></span>
								<strong class="amount"><?php echo $this->db->get_where('settings' , array('type' =>'currency'))->row()->description." ".number_format($row['amount'], 2, '.', ' ') ?></strong>
								
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
	
	<div class="col-md-4" data-appear-animation="bounceInUp">
		
		<section class="panel panel-featured-left panel-featured-primary">
			<div class="panel-body">
				<div class="widget-summary widget-summary-sm">
					<div class="widget-summary-col widget-summary-col-icon">
						<div class="summary-icon bg-primary">
							<i class="fa fa-money"></i>
						</div>
					</div>
					
<?php
		$TODAY = date('Y-m-d');

		// Get total withdrawals for the client for today
		$this->db->select_sum('transaction.amount');
		$this->db->from('transaction');
		$this->db->join('account', 'account.id = transaction.account_id');
		$this->db->join('client', 'client.id = account.client_id');
		$this->db->where('client.id', $client_id);
		$this->db->where('transaction.createdate', $TODAY);
		$this->db->where('transaction.type', 'withdrawal');
		$withdrawal_query = $this->db->get();
		$cashminus = $withdrawal_query->row()->amount;
		if ($cashminus === NULL) { $cashminus = 0; }

		// Get total deposits for the client for today
		$this->db->select_sum('transaction.amount');
		$this->db->from('transaction');
		$this->db->join('account', 'account.id = transaction.account_id');
		$this->db->join('client', 'client.id = account.client_id');
		$this->db->where('client.id', $client_id);
		$this->db->where('transaction.createdate', $TODAY);
		$this->db->where('transaction.type', 'deposit');
		$deposit_query = $this->db->get();
		$cashplus = $deposit_query->row()->amount;
		if ($cashplus === NULL) { $cashplus = 0; }

   $difference=$cashplus-$cashminus;

?>						
					
					
					<div class="widget-summary-col">
						<div class="summary">
								
							<h4 class="title"><?php echo get_phrase('todays_inflow');?></h4>
							<div class="info">
								<strong class="amount">E <?php echo number_format($difference, 2, '.', ' ');?></strong><br/>
								<span class="text-primary text-uppercase"><?php echo date('Y-m-d');?></span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
	
</div>
	

<script>
	//CALENDAR SETTINGS
	$( document ).ready( function () {
		var calendar = $( '#notice_calendar' );
		$( '#notice_calendar' ).fullCalendar( {
			header: {
				left: 'title',
				right: 'prev,today,next'
			},

			//defaultView: 'basicWeek',
			displayEventTime : false,
			editable: false,
			firstDay: 1,
			height: 450,
			droppable: false,

			events: [
				<?php 
				$notices = $this->db->get('noticeboard')->result_array();
				
				foreach($notices as $row):
				?> {
					title: "<?php echo $row['notice_title'];?>",
					start: new Date( <?php echo date('Y',$row['create_timestamp']);?>, <?php echo date('m',$row['create_timestamp'])-1;?>, <?php echo date('d',$row['create_timestamp']);?> ),
					end: new Date( <?php echo date('Y',$row['create_timestamp']);?>, <?php echo date('m',$row['create_timestamp'])-1;?>, <?php echo date('d',$row['create_timestamp']);?> )
				},
				<?php 
				  endforeach
				?>
			]
		} );
	} );
</script>