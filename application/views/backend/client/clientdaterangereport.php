<?php 
	
	$this->db->where('createdate >=', $startdate);
	$this->db->where('createdate <=', $enddated);
	$this->db->group_start();
	$this->db->where('account_id', $account);
	$this->db->or_where('related_account_id', $account);
	$this->db->group_end();
	$this->db->from('transaction');
	$transactions = $this->db->count_all_results();

	$this->db->where('createdate >=', $startdate);
	$this->db->where('createdate <=', $enddated);
	$this->db->group_start();
	$this->db->where('account_id', $account);
	$this->db->or_where('related_account_id', $account);
	$this->db->group_end();
	$this->db->where('type','loan_disbursement');
	$this->db->select_sum('amount');
	$query = $this->db->get('transaction'); 
	$loaned = $query->row()->amount;
	if($loaned==NULL){$loaned=0;}

	$this->db->where('createdate >=', $startdate);
	$this->db->where('createdate <=', $enddated);
	$this->db->group_start();
	$this->db->where('account_id', $account);
	$this->db->or_where('related_account_id', $account);
	$this->db->group_end();
	$this->db->where('type','loan_repayment');
	$this->db->select_sum('amount');
	$query = $this->db->get('transaction'); 
	$returned = $query->row()->amount;
	if($returned==NULL){$returned=0;}

		$this->db->where('createdate >=', $startdate);
	$this->db->where('createdate <=', $enddated);
	$this->db->group_start();
	$this->db->where('account_id', $account);
	$this->db->or_where('related_account_id', $account);
	$this->db->group_end();
	$this->db->where('type','transfer');
	$this->db->select_sum('amount');
	$query = $this->db->get('transaction'); 
	$transfer = $query->row()->amount;
	if($transfer==NULL){$transfer=0;}
	
	$this->db->where('createdate >=', $startdate);
	$this->db->where('createdate <=', $enddated);
	$this->db->group_start();
	$this->db->where('account_id', $account);
	$this->db->or_where('related_account_id', $account);
	$this->db->group_end();
	$this->db->where('type','deposit');
	$this->db->select_sum('amount');
	$query = $this->db->get('transaction'); 
	$cashplus = $query->row()->amount;
	if($cashplus==NULL){$cashplus=0;}

	$this->db->where('createdate >=', $startdate);
	$this->db->where('createdate <=', $enddated);
	$this->db->group_start();
	$this->db->where('account_id', $account);
	$this->db->or_where('related_account_id', $account);
	$this->db->group_end();
	$this->db->where('type','withdrawal');
	$this->db->select_sum('amount');
	$query = $this->db->get('transaction'); 
	$cashminus =$query->row()->amount;
	if($cashminus ==NULL){$cashminus=0;};
	
	// Calculate Total Transfers
	$this->db->where('createdate >=', $startdate);
	$this->db->where('createdate <=', $enddated);
	$this->db->group_start();
	$this->db->where('account_id', $account);
	$this->db->or_where('related_account_id', $account);
	$this->db->group_end();
	$this->db->where('type', 'transfer');
	$this->db->select_sum('amount');
	$query = $this->db->get('transaction'); 
	$cashtransfer = $query->row()->amount;
	if ($cashtransfer == NULL) { $cashtransfer = 0; }

	if($transactions==NULL){
		$cashplus=0;
		$transactions=0;
		$cashminus=0;
		$percentage=0;
		$total=0;
		$variance=0;
		$cashtransfer=0;

	}else{
		//$income=$returned+$cashplus;
		//$outgoing=$loaned+$cashminus;
		$total=$cashplus+$cashminus;
		$variance = $cashplus - $cashminus;
		
		
		$percentage = ($variance / $total) * 100;
	}

	
					

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
					
					<div class="col-lg-12" data-appear-animation="bounceInLeft">
							<section class="panel">
							
							<header class="panel-heading">
									<div class="panel-actions">
									</div>
					
									<h2 class="panel-title">Transactions</h2>
								</header>	
											<div class="panel-body">
							<!-- Morris: Donut -->
										<div class="chart chart-md" id="morrisDonut"></div>

							<!-- Flot: Earning Graph -->
													<script type="text/javascript">
													    var morrisDonutData = [
												        {
												            label: "Loaned",
												            value: <?php echo number_format($loaned, 0, '.', ''); ?>
												        }, 
												        {
												            label: "Loan Repayment",
												            value: <?php echo number_format($returned, 0, '.', ''); ?>
												        }, 
												        {
												            label: "Deposits",
												            value: <?php echo number_format($cashplus, 0, '.', ''); ?>
												        }, 
												        {
												            label: "Withdrawals",
												            value: <?php echo number_format($cashminus, 0, '.', ''); ?>
												        },
												        {
												            label: "Transfers",
												            value: <?php echo number_format($transfer, 0, '.', ''); ?>
												        }
													    ];

													    // See: assets/javascripts/ui-elements/examples.charts.js for more settings.
													</script>
													
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
								
					
									<h2 class="panel-title">Tabular Transactions</h2>
								</header>
									
									<div class="row">
							<div class="col-lg-12">
							<section class="panel">
									
									<div class="panel-body">

					<table class="table table-bordered table-striped mb-none" id="datatable-tabletools" >
			<thead>
				<tr>
                                        <th>
						<div>
							<?php echo get_phrase('trans_no');?>
						</div>
					</th>
					<th>
						<div>
							<?php echo get_phrase('type');?>
						</div>
					</th>
					<th>
						<div>
							<?php echo get_phrase('account');?>
						</div>
					</th>
					<th>
						<div>
							<?php echo get_phrase('amount');?>
						</div>
					</th>
					<th>
						<div>
							<?php echo get_phrase('timestamp');?>
						</div>
					</th>
					<th>
						<div>
							<?php echo get_phrase('options');?>
						</div>
					</th>
				</tr>
			</thead>
			<tbody>
			
				<?php
				
				$status = "Active";
					$this->db->where('createdate >=', $startdate);
					$this->db->where('createdate <=', $enddated);
					$this->db->group_start();
					$this->db->where('account_id', $account);
					$this->db->or_where('related_account_id', $account);
					$this->db->group_end();
					 $query = $this->db->get( 'transaction' );
					$alltransactions = $query->result_array();
				foreach ( $alltransactions as $row ): ?>
				<tr>
                                       <td>
						<?php echo $row['id'];?>
					</td>
					<td>
						<?php echo get_phrase($row['type']);?>
					</td>
					<td>
						<?php echo $row['account_id'];?>
					</td>
					<td>
						<?php echo $row['amount'];?>
					</td>
					<td>
						<?php echo $row['timestamp'];?>
					</td>
					<td>

						<!-- VIEW CLIENT DETAILS LINK -->
						<a href="<?php echo base_url(); ?>index.php?admin/client_details/<?php echo $row['id'];?>" class="btn btn-xs btn-info" data-placement="top" data-toggle="tooltip" 
						data-original-title="<?php echo get_phrase('view_client');?>" target="_blank">
                        <i class="fa fa-eye"></i>
                        </a>


						<!-- CLIENT EDITING LINK -->

						<a href="#" class="btn btn-xs btn-success" data-placement="top" data-toggle="tooltip" 
						data-original-title="<?php echo get_phrase('edit');?>" onClick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_client_edit/<?php echo $row['id'];?>');">
                        <i class="fa fa-pencil"></i>
                        </a>
						

						<!-- CLIENT DELETION LINK -->
						<a href="#" class="btn btn-xs btn-danger" data-placement="top" data-toggle="tooltip"
						 data-original-title="<?php echo get_phrase('delete');?>" onClick="confirm_modal('<?php echo base_url();?>index.php?admin/client/delete/<?php echo $row['id'];?>');">
                        <i class="fa fa-trash"></i>
                        </a>			

					</td>
				</tr>
				<?php endforeach;

								// Get the MINIMUM transaction amount
								$this->db->where('createdate >=', $startdate);
								$this->db->where('createdate <=', $enddated);
								$this->db->group_start();
								$this->db->where('account_id', $account);
								$this->db->or_where('related_account_id', $account);
								$this->db->group_end();
															$this->db->select_min('amount');
								$query = $this->db->get('transaction'); 
								$min_amount = $query->row()->amount;
								if ($min_amount == NULL) { $min_amount = 0; }

								// Get the MAXIMUM transaction amount
								$this->db->where('createdate >=', $startdate);
								$this->db->where('createdate <=', $enddated);
								$this->db->group_start();
								$this->db->where('account_id', $account);
								$this->db->or_where('related_account_id', $account);
								$this->db->group_end();
								$this->db->select_avg('amount');
								$query = $this->db->get('transaction');  
								$avg_amount = $query->row()->amount;
								if ($avg_amount == NULL) { $avg_amount = 0; }

								// Get the AVERAGE transaction amount
								$this->db->where('createdate >=', $startdate);
								$this->db->where('createdate <=', $enddated);
								$this->db->group_start();
								$this->db->where('account_id', $account);
								$this->db->or_where('related_account_id', $account);
								$this->db->group_end();
								$this->db->select_max('amount');
								$query = $this->db->get('transaction'); 
								$max_amount = $query->row()->amount;
								if ($max_amount == NULL) { $max_amount = 0; }
				?>
			</tbody>
		</table>									
						
							<hr class="solid short mt-lg">
												<div class="row">
													<div class="col-md-4">
														<div class="h4 text-weight-bold mb-none mt-lg">E <?php echo number_format($max_amount, 2, '.', ' ') ?></div>
														<p class="text-xs text-primary mb-none">Maximum Amount </p>
													</div>




													<div class="col-md-4">
														<div class="h4 text-weight-bold mb-none mt-lg">E <?php echo number_format($min_amount, 2, '.', ' ') ?></div>
														<p class="text-xs text-primary mb-none">Minimum Amount</p>
													</div>
													<div class="col-md-4">
														<div class="h4 text-weight-bold mb-none mt-lg">E <?php echo number_format($avg_amount, 2, '.', ' ') ?></div>
														<p class="text-xs text-primary mb-none">Avarage Amount</p>
													</div>
												</div>
						
						
						
									</div>
								</section>
							</div>
					
					
				</div>
										
								</div>
								
							</section>
						</div>
					</div>
							
	