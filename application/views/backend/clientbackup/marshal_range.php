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
									<li style="float:right; color: #fff;">
										<!-- STUDENT EDITING LINK -->
								<!-- STUDENT EDITING LINK -->
									<a href="<?php echo base_url();?>index.php?admin/marshallist/" class="btn btn-primary btn-xs" data-placement="top" data-toggle="tooltip" data-original-title="<?php echo get_phrase('back_to_marshal_list');?>">
                                    <i class="fa fa-arrow-left"></i> Back
                                    </a>
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
			$systemcash = $systemcash + $rowd[ 'systemcash' ] ;
			$varience = $systemcash - $todayincome ;
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
														<strong class="amount" style="font-size:18px;"><?php echo number_format($systemcash, 2, '.', ' ') ?></strong>
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
														<strong class="amount" style="font-size:18px;"><?php echo number_format($todayincome, 2, '.', ' ') ?></strong>
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
														<strong class="amount" style="font-size:18px;"><?php echo number_format($varience, 2, '.', ' ') ?></strong>
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
	
	
	<div class="row">

			<div class="col-md-12">
							<section class="panel panel-warning">
								<header class="panel-heading">
									<div class="panel-actions">
										<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
									</div>

									<h2 class="panel-title"><?php echo $marshal; ?></h2>
									<p class="panel-subtitle">Report Per Month</p>
								</header>
								
							</section>
						</div>

	<!-- February Statistics  -->	
	 <div class="col-md-6">
	 
							<section class="panel panel-collapsed">
								<header class="panel-heading">
									<div class="panel-actions">
										<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
										<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
									</div>

									<h2 class="panel-title"><?php echo get_phrase('february');?></h2>
									<p class="panel-subtitle"><?php echo get_phrase('general_stats');?></p>
								</header>
								<div class="panel-body">
									<table class="table table-striped table-bordered  mb-none">
                
				<?php
			
				$count = $this->db->get_where( 'collections', array('marshal' => $marshal, 'month' =>'Feb' ) )->result_array();
				foreach ( $count as $rows ): 
				
				$month = $rows['month']; 
				$febbroughtback = $febbroughtback + $rows['broughtback'];
				$febsystemcash = $febsystemcash + $rows['systemcash']; 
				$febactual = $febactual + $rows['actual']; 
				$febvarience = $febactual - $febsystemcash; 
				 
				endforeach;
				
				?>
                    
                    <tr>
                        <td><?php echo get_phrase('month');?></td>
                        <td><b> <?php echo $month; ?></b></td>
                    </tr>
                	 <tr>
                        <td><?php echo get_phrase('brought_back');?></td>
                        <td><b> <?php echo $febbroughtback; ?></b></td>
                    </tr>
                    
                    <tr>
                        <td><?php echo get_phrase('system_cash');?></td>
                        <td><b> <?php echo $febsystemcash; ?></b></td>
                    </tr>
                    <tr>
                        <td><?php echo get_phrase('actual');?></td>
                        <td><b> <?php echo $febactual; ?></b></td>
                    </tr>
                    
                    <tr>
                        <td><?php echo get_phrase('varience');?></td>
                        <td><b> <?php echo $febvarience; ?></b></td>
                    </tr>
                    
                    
                </table>
								</div>
							</section>
						</div>
						
						<!-- March Statistics  -->		
						
				 <div class="col-md-6">
	 
							<section class="panel panel-collapsed">
								<header class="panel-heading">
									<div class="panel-actions">
										<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
										<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
									</div>

									<h2 class="panel-title"><?php echo get_phrase('march');?></h2>
									<p class="panel-subtitle"><?php echo get_phrase('general_stats');?></p>
								</header>
								<div class="panel-body">
									<table class="table table-striped table-bordered  mb-none">
                
				<?php
			
				$count = $this->db->get_where( 'collections', array('marshal' => $marshal, 'month' =>'Mar' ) )->result_array();
				foreach ( $count as $rows ): 
				
				$month = $rows['month']; 
				$marbroughtback = $marbroughtback + $rows['broughtback'];
				$marsystemcash = $marsystemcash + $rows['systemcash']; 
				$maractual = $maractual + $rows['actual']; 
				$marvarience = $maractual - $marsystemcash; 
				 
				endforeach;
				
				?>
                    
                    <tr>
                        <td><?php echo get_phrase('month');?></td>
                        <td><b> <?php echo $month; ?></b></td>
                    </tr>
                	 <tr>
                        <td><?php echo get_phrase('brought_back');?></td>
                        <td><b> <?php echo $marbroughtback; ?></b></td>
                    </tr>
                    
                    <tr>
                        <td><?php echo get_phrase('system_cash');?></td>
                        <td><b> <?php echo $marsystemcash; ?></b></td>
                    </tr>
                    <tr>
                        <td><?php echo get_phrase('actual');?></td>
                        <td><b> <?php echo $maractual; ?></b></td>
                    </tr>
                    
                    <tr>
                        <td><?php echo get_phrase('varience');?></td>
                        <td><b> <?php echo $marvarience; ?></b></td>
                    </tr>
                    
                    
                </table>
								</div>
							</section>
						</div>
					
	  
    
</div>	

<!-- Next Row To Display  -->

<div class="row">

<!-- April Statistics  -->
	 <div class="col-md-6">
	 
							<section class="panel panel-collapsed">
								<header class="panel-heading">
									<div class="panel-actions">
										<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
										<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
									</div>

									<h2 class="panel-title"><?php echo get_phrase('april');?></h2>
									<p class="panel-subtitle"><?php echo get_phrase('general_stats');?></p>
								</header>
								<div class="panel-body">
									<table class="table table-striped table-bordered  mb-none">
                
				<?php
			
				$count = $this->db->get_where( 'collections', array('marshal' => $marshal, 'month' =>'Apr' ) )->result_array();
				foreach ( $count as $rows ): 
				
				$month = $rows['month']; 
				$aprbroughtback = $aprbroughtback + $rows['broughtback'];
				$aprsystemcash = $aprsystemcash + $rows['systemcash']; 
				$apractual = $apractual + $rows['actual']; 
				$aprvarience = $apractual - $aprsystemcash; 
				 
				endforeach;
				
				?>
                    
                    <tr>
                        <td><?php echo get_phrase('month');?></td>
                        <td><b> <?php echo $month; ?></b></td>
                    </tr>
                	 <tr>
                        <td><?php echo get_phrase('brought_back');?></td>
                        <td><b> <?php echo $aprbroughtback; ?></b></td>
                    </tr>
                    
                    <tr>
                        <td><?php echo get_phrase('system_cash');?></td>
                        <td><b> <?php echo $aprsystemcash; ?></b></td>
                    </tr>
                    <tr>
                        <td><?php echo get_phrase('actual');?></td>
                        <td><b> <?php echo $apractual; ?></b></td>
                    </tr>
                    
                    <tr>
                        <td><?php echo get_phrase('varience');?></td>
                        <td><b> <?php echo $aprvarience; ?></b></td>
                    </tr>
                    
                    
                </table>
								</div>
							</section>
						</div>
						
				<!-- May Statistics  -->		
						
				 <div class="col-md-6">
	 
							<section class="panel panel-collapsed">
								<header class="panel-heading">
									<div class="panel-actions">
										<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
										<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
									</div>

									<h2 class="panel-title"><?php echo get_phrase('may');?></h2>
									<p class="panel-subtitle"><?php echo get_phrase('general_stats');?></p>
								</header>
								<div class="panel-body">
									<table class="table table-striped table-bordered  mb-none">
                
				<?php
			
				$count = $this->db->get_where( 'collections', array('marshal' => $marshal, 'month' =>'May' ) )->result_array();
				foreach ( $count as $rows ): 
				
				$month = $rows['month']; 
				$maybroughtback = $maybroughtback + $rows['broughtback'];
				$maysystemcash = $maysystemcash + $rows['systemcash']; 
				$mayactual = $mayactual + $rows['actual']; 
				$mayvarience = $mayactual - $maysystemcash; 
				 
				endforeach;
				
				?>
                    
                    <tr>
                        <td><?php echo get_phrase('month');?></td>
                        <td><b> <?php echo $month; ?></b></td>
                    </tr>
                	 <tr>
                        <td><?php echo get_phrase('brought_back');?></td>
                        <td><b> <?php echo $maybroughtback; ?></b></td>
                    </tr>
                    
                    <tr>
                        <td><?php echo get_phrase('system_cash');?></td>
                        <td><b> <?php echo $maysystemcash; ?></b></td>
                    </tr>
                    <tr>
                        <td><?php echo get_phrase('actual');?></td>
                        <td><b> <?php echo $mayactual; ?></b></td>
                    </tr>
                    
                    <tr>
                        <td><?php echo get_phrase('varience');?></td>
                        <td><b> <?php echo $mayvarience; ?></b></td>
                    </tr>
                    
                    
                </table>
								</div>
							</section>
						</div>
					
	  
    
</div>	
						
						
						

<!-- Next Row To Display  -->

<div class="row">

<!-- June Statistics  -->
	 <div class="col-md-6">
	 
							<section class="panel panel-collapsed">
								<header class="panel-heading">
									<div class="panel-actions">
										<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
										<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
									</div>

									<h2 class="panel-title"><?php echo get_phrase('june');?></h2>
									<p class="panel-subtitle"><?php echo get_phrase('general_stats');?></p>
								</header>
								<div class="panel-body">
									<table class="table table-striped table-bordered  mb-none">
                
				<?php
			
				$count = $this->db->get_where( 'collections', array('marshal' => $marshal, 'month' =>'Jun' ) )->result_array();
				foreach ( $count as $rows ): 
				
				$month = $rows['month']; 
				$junbroughtback = $junbroughtback + $rows['broughtback'];
				$junsystemcash = $junsystemcash + $rows['systemcash']; 
				$junactual = $junactual + $rows['actual']; 
				$junvarience = $junactual - $junsystemcash; 
				 
				endforeach;
				
				?>
                    
                    <tr>
                        <td><?php echo get_phrase('month');?></td>
                        <td><b> <?php echo $month; ?></b></td>
                    </tr>
                	 <tr>
                        <td><?php echo get_phrase('brought_back');?></td>
                        <td><b> <?php echo $junbroughtback; ?></b></td>
                    </tr>
                    
                    <tr>
                        <td><?php echo get_phrase('system_cash');?></td>
                        <td><b> <?php echo $junsystemcash; ?></b></td>
                    </tr>
                    <tr>
                        <td><?php echo get_phrase('actual');?></td>
                        <td><b> <?php echo $junactual; ?></b></td>
                    </tr>
                    
                    <tr>
                        <td><?php echo get_phrase('varience');?></td>
                        <td><b> <?php echo $junvarience; ?></b></td>
                    </tr>
                    
                    
                </table>
								</div>
							</section>
						</div>
						
				<!-- July Statistics  -->		
						
				 <div class="col-md-6">
	 
							<section class="panel panel-collapsed">
								<header class="panel-heading">
									<div class="panel-actions">
										<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
										<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
									</div>

									<h2 class="panel-title"><?php echo get_phrase('july');?></h2>
									<p class="panel-subtitle"><?php echo get_phrase('general_stats');?></p>
								</header>
								<div class="panel-body">
									<table class="table table-striped table-bordered  mb-none">
                
				<?php
			
				$count = $this->db->get_where( 'collections', array('marshal' => $marshal, 'month' =>'Jul' ) )->result_array();
				foreach ( $count as $rows ): 
				
				$month = $rows['month']; 
				$julbroughtback = $julbroughtback + $rows['broughtback'];
				$julsystemcash = $julsystemcash + $rows['systemcash']; 
				$julactual = $julactual + $rows['actual']; 
				$julvarience = $julactual - $julsystemcash; 
				 
				endforeach;
				
				?>
                    
                    <tr>
                        <td><?php echo get_phrase('month');?></td>
                        <td><b> <?php echo $month; ?></b></td>
                    </tr>
                	 <tr>
                        <td><?php echo get_phrase('brought_back');?></td>
                        <td><b> <?php echo $julbroughtback; ?></b></td>
                    </tr>
                    
                    <tr>
                        <td><?php echo get_phrase('system_cash');?></td>
                        <td><b> <?php echo $julsystemcash; ?></b></td>
                    </tr>
                    <tr>
                        <td><?php echo get_phrase('actual');?></td>
                        <td><b> <?php echo $julactual; ?></b></td>
                    </tr>
                    
                    <tr>
                        <td><?php echo get_phrase('varience');?></td>
                        <td><b> <?php echo $julvarience; ?></b></td>
                    </tr>
                    
                    
                </table>
								</div>
							</section>
						</div>
					
	  
    
</div>	


<!-- Next Row To Display  -->

<div class="row">

<!-- August Statistics  -->
	 <div class="col-md-6">
	 
							<section class="panel panel-collapsed">
								<header class="panel-heading">
									<div class="panel-actions">
										<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
										<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
									</div>

									<h2 class="panel-title"><?php echo get_phrase('August');?></h2>
									<p class="panel-subtitle"><?php echo get_phrase('general_stats');?></p>
								</header>
								<div class="panel-body">
									<table class="table table-striped table-bordered  mb-none">
                
				<?php
			
				$count = $this->db->get_where( 'collections', array('marshal' => $marshal, 'month' =>'Aug' ) )->result_array();
				foreach ( $count as $rows ): 
				
				$month = $rows['month']; 
				$augbroughtback = $augbroughtback + $rows['broughtback'];
				$augsystemcash = $augsystemcash + $rows['systemcash']; 
				$augactual = $augactual + $rows['actual']; 
				$augvarience = $augactual - $augsystemcash; 
				 
				endforeach;
				
				?>
                    
                    <tr>
                        <td><?php echo get_phrase('month');?></td>
                        <td><b> <?php echo $month; ?></b></td>
                    </tr>
                	 <tr>
                        <td><?php echo get_phrase('brought_back');?></td>
                        <td><b> <?php echo $augbroughtback; ?></b></td>
                    </tr>
                    
                    <tr>
                        <td><?php echo get_phrase('system_cash');?></td>
                        <td><b> <?php echo $augsystemcash; ?></b></td>
                    </tr>
                    <tr>
                        <td><?php echo get_phrase('actual');?></td>
                        <td><b> <?php echo $augactual; ?></b></td>
                    </tr>
                    
                    <tr>
                        <td><?php echo get_phrase('varience');?></td>
                        <td><b> <?php echo $augvarience; ?></b></td>
                    </tr>
                    
                    
                </table>
								</div>
							</section>
						</div>
						
				<!-- September Statistics  -->		
						
				 <div class="col-md-6">
	 
							<section class="panel panel-collapsed">
								<header class="panel-heading">
									<div class="panel-actions">
										<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
										<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
									</div>

									<h2 class="panel-title"><?php echo get_phrase('September');?></h2>
									<p class="panel-subtitle"><?php echo get_phrase('general_stats');?></p>
								</header>
								<div class="panel-body">
									<table class="table table-striped table-bordered  mb-none">
                
				<?php
			
				$count = $this->db->get_where( 'collections', array('marshal' => $marshal, 'month' =>'Sep' ) )->result_array();
				foreach ( $count as $rows ): 
				
				$month = $rows['month']; 
				$sepbroughtback = $sepbroughtback + $rows['broughtback'];
				$sepsystemcash = $sepsystemcash + $rows['systemcash']; 
				$sepactual = $sepactual + $rows['actual']; 
				$sepvarience = $sepactual - $sepsystemcash; 
				 
				endforeach;
				
				?>
                    
                    <tr>
                        <td><?php echo get_phrase('month');?></td>
                        <td><b> <?php echo $month; ?></b></td>
                    </tr>
                	 <tr>
                        <td><?php echo get_phrase('brought_back');?></td>
                        <td><b> <?php echo $sepbroughtback; ?></b></td>
                    </tr>
                    
                    <tr>
                        <td><?php echo get_phrase('system_cash');?></td>
                        <td><b> <?php echo $sepsystemcash; ?></b></td>
                    </tr>
                    <tr>
                        <td><?php echo get_phrase('actual');?></td>
                        <td><b> <?php echo $sepactual; ?></b></td>
                    </tr>
                    
                    <tr>
                        <td><?php echo get_phrase('varience');?></td>
                        <td><b> <?php echo $sepvarience; ?></b></td>
                    </tr>
                    
                    
                </table>
								</div>
							</section>
						</div>
					
	  
    
</div>	
	
	
	
	<!-- Next Row To Display  -->

<div class="row">

<!-- October Statistics  -->
	 <div class="col-md-6">
	 
							<section class="panel panel-collapsed">
								<header class="panel-heading">
									<div class="panel-actions">
										<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
										<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
									</div>

									<h2 class="panel-title"><?php echo get_phrase('October');?></h2>
									<p class="panel-subtitle"><?php echo get_phrase('general_stats');?></p>
								</header>
								<div class="panel-body">
									<table class="table table-striped table-bordered  mb-none">
                
				<?php
			
				$count = $this->db->get_where( 'collections', array('marshal' => $marshal, 'month' =>'Oct' ) )->result_array();
				foreach ( $count as $rows ): 
				
				$month = $rows['month']; 
				$octbroughtback = $octbroughtback + $rows['broughtback'];
				$octsystemcash = $octsystemcash + $rows['systemcash']; 
				$octactual = $octactual + $rows['actual']; 
				$octvarience = $octactual - $octsystemcash; 
				 
				endforeach;
				
				?>
                    
                    <tr>
                        <td><?php echo get_phrase('month');?></td>
                        <td><b> <?php echo $month; ?></b></td>
                    </tr>
                	 <tr>
                        <td><?php echo get_phrase('brought_back');?></td>
                        <td><b> <?php echo $octbroughtback; ?></b></td>
                    </tr>
                    
                    <tr>
                        <td><?php echo get_phrase('system_cash');?></td>
                        <td><b> <?php echo $octsystemcash; ?></b></td>
                    </tr>
                    <tr>
                        <td><?php echo get_phrase('actual');?></td>
                        <td><b> <?php echo $octactual; ?></b></td>
                    </tr>
                    
                    <tr>
                        <td><?php echo get_phrase('varience');?></td>
                        <td><b> <?php echo $octvarience; ?></b></td>
                    </tr>
                    
                    
                </table>
								</div>
							</section>
						</div>
						
				<!-- November Statistics  -->		
						
				 <div class="col-md-6">
	 
							<section class="panel panel-collapsed">
								<header class="panel-heading">
									<div class="panel-actions">
										<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
										<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
									</div>

									<h2 class="panel-title"><?php echo get_phrase('November');?></h2>
									<p class="panel-subtitle"><?php echo get_phrase('general_stats');?></p>
								</header>
								<div class="panel-body">
									<table class="table table-striped table-bordered  mb-none">
                
				<?php
			
				$count = $this->db->get_where( 'collections', array('marshal' => $marshal, 'month' =>'Nov' ) )->result_array();
				foreach ( $count as $rows ): 
				
				$month = $rows['month']; 
				$novbroughtback = $novbroughtback + $rows['broughtback'];
				$novsystemcash = $novsystemcash + $rows['systemcash']; 
				$novactual = $novactual + $rows['actual']; 
				$novvarience = $novactual - $novsystemcash; 
				 
				endforeach;
				
				?>
                    
                    <tr>
                        <td><?php echo get_phrase('month');?></td>
                        <td><b> <?php echo $month; ?></b></td>
                    </tr>
                	 <tr>
                        <td><?php echo get_phrase('brought_back');?></td>
                        <td><b> <?php echo $novbroughtback; ?></b></td>
                    </tr>
                    
                    <tr>
                        <td><?php echo get_phrase('system_cash');?></td>
                        <td><b> <?php echo $novsystemcash; ?></b></td>
                    </tr>
                    <tr>
                        <td><?php echo get_phrase('actual');?></td>
                        <td><b> <?php echo $novactual; ?></b></td>
                    </tr>
                    
                    <tr>
                        <td><?php echo get_phrase('varience');?></td>
                        <td><b> <?php echo $novvarience; ?></b></td>
                    </tr>
                    
                    
                </table>
								</div>
							</section>
						</div>
					
	  
    
</div>	
					

<!-- Next Row To Display  -->

<div class="row">

<!-- Dec Statistics  -->
	 <div class="col-md-6">
	 
							<section class="panel panel-collapsed">
								<header class="panel-heading">
									<div class="panel-actions">
										<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
										<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
									</div>

									<h2 class="panel-title"><?php echo get_phrase('December');?></h2>
									<p class="panel-subtitle"><?php echo get_phrase('general_stats');?></p>
								</header>
								<div class="panel-body">
									<table class="table table-striped table-bordered  mb-none">
                
				<?php
			
				$count = $this->db->get_where( 'collections', array('marshal' => $marshal, 'month' =>'Dec' ) )->result_array();
				foreach ( $count as $rows ): 
				
				$month = $rows['month']; 
				$decbroughtback = $decbroughtback + $rows['broughtback'];
				$decsystemcash = $decsystemcash + $rows['systemcash']; 
				$decactual = $decactual + $rows['actual']; 
				$decvarience = $decactual - $decsystemcash; 
				 
				endforeach;
				
				?>
                    
                    <tr>
                        <td><?php echo get_phrase('month');?></td>
                        <td><b> <?php echo $month; ?></b></td>
                    </tr>
                	 <tr>
                        <td><?php echo get_phrase('brought_back');?></td>
                        <td><b> <?php echo $decbroughtback; ?></b></td>
                    </tr>
                    
                    <tr>
                        <td><?php echo get_phrase('system_cash');?></td>
                        <td><b> <?php echo $decsystemcash; ?></b></td>
                    </tr>
                    <tr>
                        <td><?php echo get_phrase('actual');?></td>
                        <td><b> <?php echo $decactual; ?></b></td>
                    </tr>
                    
                    <tr>
                        <td><?php echo get_phrase('varience');?></td>
                        <td><b> <?php echo $decvarience; ?></b></td>
                    </tr>
                    
                    
                </table>
								</div>
							</section>
						</div>
						
				<!-- November Statistics  -->		
						
				 <div class="col-md-6">
	 
						
						</div>
					
	  
    
</div>					
						
						
						
				</div>	
	
	
	
	</div>
	</div>
</div>

	
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

						<!-- Flot: Earning Graph -->
						<script>
							var flotDashSales1Data = [{
								data: [
								
									 ["Feb", <?php echo $febactual ?>],
									 ["Mar", <?php echo $maractual ?>],
									 ["Apr", <?php echo $apractual ?>],
									 ["May", <?php echo $mayactual ?>],
									 ["Jun", <?php echo $junactual ?>],
									 ["Jul", <?php echo $julactual ?>],
									 ["Aug", <?php echo $augactual ?>],
									 ["Sep", <?php echo $sepactual ?>],
									 ["Oct", <?php echo $octactual ?>],
									 ["Nov", <?php echo $novactual ?>],
									 ["Dec", <?php echo $decactual ?>],

									
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
				
				
				
			<div class="col-lg-12 col-md-12">
							<section class="panel">
								<header class="panel-heading panel-heading-transparent">
									<div class="panel-actions">
										<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
										<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
									</div>
					
									<h2 class="panel-title">Perfomance Stats</h2>
								</header>
								<div class="panel-body">
									<div class="table-responsive" style="font-size:14px;">
										<table class="table table-striped mb-none">
											<thead>
												<tr>
													<th>#</th>
													<th>Month</th>
													<th>Brought Back</th>
													<th>System Cash</th>
													<th>Actual</th>
													<th>Variance</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>1</td>
													<td>Feb</td>
													<td><span class="label" style="padding: 5px; font-size:14px;"><?php echo  number_format($febbroughtback, 2, '.', ' ') ?></span></td>
													<td><span class="label" style="padding: 5px; font-size:14px;"><?php echo number_format($febsystemcash, 2, '.', ' ')?></span></td>
													<td><span class="label"  style="padding: 5px; font-size:14px;"><?php echo number_format($febactual, 2, '.', ' ') ?></span></td>
													<td><span class="label" style="padding: 5px; font-size:14px; color:#fe0000"><?php echo number_format($febvarience, 2, '.', ' ') ?></span></td>
												</tr>
													<tr>
													<td>2</td>
													<td>Mar</td>
														<td><span class="label" style="padding: 5px; font-size:14px;"><?php echo  number_format($marbroughtback, 2, '.', ' ') ?></span></td>
													<td><span class="label" style="padding: 5px; font-size:14px;"><?php echo number_format($marsystemcash, 2, '.', ' ')?></span></td>
													<td><span class="label"  style="padding: 5px; font-size:14px;"><?php echo number_format($maractual, 2, '.', ' ') ?></span></td>
													<td><span class="label" style="padding: 5px; font-size:14px; color:#fe0000;"><?php echo number_format($marvarience, 2, '.', ' ') ?></span></td>
												</tr>
													<tr>
													<td>3</td>
													<td>Apr</td>
														<td><span class="label" style="padding: 5px; font-size:14px;"><?php echo  number_format($aprbroughtback, 2, '.', ' ') ?></span></td>
													<td><span class="label" style="padding: 5px; font-size:14px;"><?php echo number_format($aprsystemcash, 2, '.', ' ')?></span></td>
													<td><span class="label"  style="padding: 5px; font-size:14px;"><?php echo number_format($apractual, 2, '.', ' ') ?></span></td>
													<td><span class="label" style="padding: 5px; font-size:14px; color:#fe0000"><?php echo number_format($aprvarience, 2, '.', ' ') ?></span></td>
												</tr>
													<tr>
													<td>4</td>
													<td>May</td>
														<td><span class="label" style="padding: 5px; font-size:14px;"><?php echo  number_format($maybroughtback, 2, '.', ' ') ?></span></td>
													<td><span class="label" style="padding: 5px; font-size:14px;"><?php echo number_format($maysystemcash, 2, '.', ' ')?></span></td>
													<td><span class="label"  style="padding: 5px; font-size:14px;"><?php echo number_format($mayactual, 2, '.', ' ') ?></span></td>
													<td><span class="label" style="padding: 5px; font-size:14px;color:#fe0000"><?php echo number_format($mayvarience, 2, '.', ' ') ?></span></td>
												</tr>
												
													<tr>
													<td>5</td>
													<td>Jun</td>
													<td><span class="label" style="padding: 5px; font-size:14px;"><?php echo  number_format($junbroughtback, 2, '.', ' ') ?></span></td>
													<td><span class="label" style="padding: 5px; font-size:14px;"><?php echo number_format($junsystemcash, 2, '.', ' ')?></span></td>
													<td><span class="label"  style="padding: 5px; font-size:14px;"><?php echo number_format($junactual, 2, '.', ' ') ?></span></td>
													<td><span class="label" style="padding: 5px; font-size:14px;color:#fe0000"><?php echo number_format($junvarience, 2, '.', ' ') ?></span></td>
												</tr>
													<tr>
													<td>6</td>
													<td>Jul</td>
													<td><span class="label" style="padding: 5px; font-size:14px;"><?php echo  number_format($julbroughtback, 2, '.', ' ') ?></span></td>
													<td><span class="label" style="padding: 5px; font-size:14px;"><?php echo number_format($julsystemcash, 2, '.', ' ')?></span></td>
													<td><span class="label"  style="padding: 5px; font-size:14px;"><?php echo number_format($julactual, 2, '.', ' ') ?></span></td>
													<td><span class="label" style="padding: 5px; font-size:14px;color:#fe0000"><?php echo number_format($julvarience, 2, '.', ' ') ?></span></td>
												</tr>
													<tr>
													<td>7</td>
													<td>Aug</td>
													<td><span class="label" style="padding: 5px; font-size:14px;"><?php echo  number_format($augbroughtback, 2, '.', ' ') ?></span></td>
													<td><span class="label" style="padding: 5px; font-size:14px;"><?php echo number_format($augsystemcash, 2, '.', ' ')?></span></td>
													<td><span class="label"  style="padding: 5px; font-size:14px;"><?php echo number_format($augactual, 2, '.', ' ') ?></span></td>
													<td><span class="label" style="padding: 5px; font-size:14px;color:#fe0000"><?php echo number_format($augvarience, 2, '.', ' ') ?></span></td>
												</tr>
													<tr>
													<td>8</td>
													<td>Sep</td>
													<td><span class="label" style="padding: 5px; font-size:14px;"><?php echo  number_format($sepbroughtback, 2, '.', ' ') ?></span></td>
													<td><span class="label" style="padding: 5px; font-size:14px;"><?php echo number_format($sepsystemcash, 2, '.', ' ')?></span></td>
													<td><span class="label"  style="padding: 5px; font-size:14px;"><?php echo number_format($sepactual, 2, '.', ' ') ?></span></td>
													<td><span class="label" style="padding: 5px; font-size:14px;color:#fe0000"><?php echo number_format($sepvarience, 2, '.', ' ') ?></span></td>
												</tr>
													<tr>
													<td>9</td>
													<td>Oct</td>
													<td><span class="label" style="padding: 5px; font-size:14px;"><?php echo  number_format($octbroughtback, 2, '.', ' ') ?></span></td>
													<td><span class="label" style="padding: 5px; font-size:14px;"><?php echo number_format($octsystemcash, 2, '.', ' ')?></span></td>
													<td><span class="label"  style="padding: 5px; font-size:14px;"><?php echo number_format($octactual, 2, '.', ' ') ?></span></td>
													<td><span class="label" style="padding: 5px; font-size:14px;color:#fe0000"><?php echo number_format($octvarience, 2, '.', ' ') ?></span></td>
												</tr>
													<tr>
													<td>10</td>
													<td>Nov</td>
													<td><span class="label" style="padding: 5px; font-size:14px;"><?php echo  number_format($novbroughtback, 2, '.', ' ') ?></span></td>
													<td><span class="label" style="padding: 5px; font-size:14px;"><?php echo number_format($novsystemcash, 2, '.', ' ')?></span></td>
													<td><span class="label"  style="padding: 5px; font-size:14px;"><?php echo number_format($novactual, 2, '.', ' ') ?></span></td>
													<td><span class="label" style="padding: 5px; font-size:14px;color:#fe0000"><?php echo number_format($novvarience, 2, '.', ' ') ?></span></td>
												</tr>
													<tr>
													<td>11</td>
													<td>Dec</td>
												<td><span class="label" style="padding: 5px; font-size:14px;"><?php echo  number_format($decbroughtback, 2, '.', ' ') ?></span></td>
													<td><span class="label" style="padding: 5px; font-size:14px;"><?php echo number_format($decsystemcash, 2, '.', ' ')?></span></td>
													<td><span class="label"  style="padding: 5px; font-size:14px;"><?php echo number_format($decactual, 2, '.', ' ') ?></span></td>
													<td><span class="label" style="padding: 5px; font-size:14px;color:#fe0000"><?php echo number_format($decvarience, 2, '.', ' ') ?></span></td>
												</tr>
												
											</tbody>
										</table>
									</div>
								</div>
							</section>
						</div>
					</div>
					<!-- end: page -->
				</section>
			</div>	
				
				
				
				
				
			</div>
				
			</div>
		</div>

	
	
						
	