<?php 
		

/*returning static of number of parking per sensor on current  date 
and this one works 
*/
 $sub_query_from = '(SELECT `wpsdid`,`Occupied_Time`, `Vacant_time_status` , TIMEDIFF(`Vacant_time_status`,`Occupied_Time`)
FROM `scanner_data` WHERE `capturedate`=CURDATE() GROUP BY `Vacant_time_status`,`Vacant_time_status`) as results_q';
$select =   array(
                'wpsdid',
                'count(*) as total'
            );
$this->db->select($select);
//$this->db->count_all_results();
$this->db->from($sub_query_from);
$this->db->group_by('wpsdid');
$query = $this->db->get();
$result = $query->result_array();



/* Calculating Avarage time spent*/

 $inner_query = '(SELECT `wpsdid`,`Occupied_Time`, `Vacant_time_status` , TIMEDIFF(`Vacant_time_status`,`Occupied_Time`)
FROM `scanner_data` WHERE `capturedate`=CURDATE() GROUP BY `Vacant_time_status`,`Vacant_time_status`) as results_q';

$this->db->select('SEC_TO_TIME(AVG(TIME_TO_SEC(TIMEDIFF(`Vacant_time_status`,`Occupied_Time`)))) as Avarage');
$this->db->from($inner_query);
$query3 = $this->db->get();
$result3 = $query3->result_array();

/* longest time spent*/

$this->db->select('MAX(TIMEDIFF(`Vacant_time_status`,`Occupied_Time`))  as Maximum');
$this->db->from($inner_query);
$query4 = $this->db->get();
$result4 = $query4->result_array();


/*
Todays parking with time spent on each bay/sensor

 we could use the results of this query to a table.
*/

$today=date('Y-m-d');
$where="";

$this->db->select("wpsdid,Occupied_Time,Vacant_time_status , TIMEDIFF(Vacant_time_status,Occupied_Time) as 'Total' ");

$this->db->from('scanner_data');
$this->db->where('capturedate=CURDATE()');
$this->db->group_by('`Vacant_time_status`');
$query2 = $this->db->get();
$result2 = $query2->result_array();


/*Total car parked today*/

$total = array_sum(array_column($result, 'total'));


/* Total cars parked group by month */
 $inner="(SELECT wpsdid,Occupied_Time, Vacant_time_status , TIMEDIFF(Vacant_time_status,Occupied_Time),DATE_FORMAT(capturedate,'%M' ) as month,DATE_FORMAT(capturedate,'%m' ) as small_month,DATE_FORMAT(capturedate,'%Y') as year FROM scanner_data GROUP by Vacant_time_status) as result_query";
 
 $params =   array(
                'month',
                'count(*) as total','small_month'
            );
            
//currnt year
$year=date('Y');

$this->db->select($params);
//$this->db->count_all_results();
$this->db->from($inner);
$this->db->where('year='.$year);
$this->db->group_by('month');
$this->db->order_by('small_month');
$query6 = $this->db->get();
$result6 = $query6->result_array();





/*Getting total made on a street per week*/

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
$this->db->where('d.week=29');
$this->db->group_by('street_name');
$query7 = $this->db->get();
$result7 = $query7->result_array();





?>

<!-- start: page -->
			<?php
			
	
				
				?>
	
			
			
			<div class="row">
			
									

					<div class="row">
				
					
						<div class="col-lg-12" data-appear-animation="bounceIn">
							
							<section class="panel">
								<header class="panel-heading">
									
						
										<h2 class="panel-title">Parked Cars Today</h2>
						
									</header>
								<div class="panel-body">
									<div class="row">
										<div class="col-lg-12" data-appear-animation="fadeInRightBig">
											<!-- Morris: Line -->
										<div class="chart chart-md" id="morrisLine">
										    
										    
										    	<div class="tab-content">
		
			
		
		<br>
			<!--TABLE LISTING STARTS-->
			<div class="tab-pane box active" id="list">
			
			<table class="table table-bordered table-striped table-condensed mb-none" id="datatable-tabletools">
					<thead>
						<tr>
							<th><div><?php echo get_phrase('Bay');?></div></th>
							<th><div><?php echo get_phrase('time_in');?></div></th>
							<th><div><?php echo get_phrase('time_out');?></div></th>
							<th><div><?php echo get_phrase('Duration');?></div></th>
							
						</tr>
					</thead>
					<tbody>
						<?php 
						
						
						$count = 1;
				
				foreach($result2 as $res):
				$occ_time=$res['Occupied_Time'];
                $vacant_time=$res['Vacant_time_status'];
				$time_in=substr($occ_time,11);
                $time_out=substr($vacant_time,11);
				?>
						
				
						<tr>
							<td>	<?php echo $this->db->get_where('sensor' , array(
                                        'wpsdid' => $res['wpsdid']
                                    ))->row()->slot;
                                ?></td>
							<td><?php echo $time_in;?></td>							
							<td><?php echo $time_out;?></td>
							<td><?php echo $res['Total'];?></td>
							
						
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			
			
			</div>
										</div>
										<script type="text/javascript">
						
											var morrisLineData = [{
												y: '2023-01-01',
												a:  <?php echo  $jan2023 ?>,
												b:  <?php echo  $jana2023 ?>
											}, {
												y: '2023-02-01',
												a:  <?php echo  $feb2023 ?>,
												b:  <?php echo  $feba2023 ?>
											}, {
												y: '2023-03-01',
												a:  <?php echo  $mar2023 ?>,
												b:  <?php echo  $mara2023 ?>
											}, {
												y: '2023-04-01',
												a:  <?php echo  $apr2023 ?>,
												b:  <?php echo  $apra2023 ?>
											}, {
												y: '2023-05-01',
												a:  <?php echo  $may2023 ?>,
												b:  <?php echo  $maya2023 ?>
											}, {
												y: '2023-06-01',
												a:  <?php echo  $jun2023 ?>,
												b:  <?php echo  $juna2023 ?>
											}, {
												y: '2023-07-01',
												a:  <?php echo  $jul2023 ?>,
												b:  <?php echo  $jula2023 ?>
											}, {
												y: '2023-08-01',
												a:  <?php echo  $aug2023 ?>,
												b:  <?php echo  $auga2023 ?>
											}, {
												y: '2023-09-01',
												a:  <?php echo  $sep2023 ?>,
												b:  <?php echo  $sepa2023 ?>
											},{
												y: '2023-10-01',
												a:  <?php echo  $oct2023 ?>,
												b:  <?php echo  $octa2023 ?>
											},{
												y: '2023-11-01',
												a:  <?php echo  $nov2023 ?>,
												b:  <?php echo  $nova2023 ?>
											},{
												y: '2023-12-01',
												a: <?php echo  $dec2023 ?>,
												b: <?php echo  $deca2023 ?>
											}];
						
											// See: assets/javascripts/ui-elements/examples.charts.js for more settings.
						
										</script>
					
									<hr class="solid short mt-lg">
												<div class="row">
													<div class="col-md-4">
														<div class="h4 text-weight-bold mb-none mt-lg"> <?php 
														
														foreach($result3 as $avg):
											
														$avarage=			    substr($avg['Avarage'],0,-5);
														echo $avarage;
													endforeach;	?></div>
														<p class="text-xs text-primary mb-none">Avarage Time Spent </p>
													</div>
													<div class="col-md-4">
														<div class="h4 text-weight-bold mb-none mt-lg"><?php foreach($result4 as $max):
											
										$Maximum = $max['Maximum'];
										echo $Maximum;
													endforeach; ?></div>
														<p class="text-xs text-primary mb-none">Maximum Time Spent</p>
													</div>
													<div class="col-md-4">
														<div class="h4 text-weight-bold mb-none mt-lg"><?php echo $total; ?></div>
														<p class="text-xs text-primary mb-none">Total Cars Parked Today</p>
													</div>
												</div>
												
												</div>
										</div>
									</div>
					</section>
					
					</div>
					
					<div class="col-lg-12" data-appear-animation="bounceInLeft">
							<section class="panel">
							
							<header class="panel-heading">
									<div class="panel-actions">
									</div>
					
		<h2 class="panel-title"> <?php echo date('Y'); ?> Monthly Parking</h2>
								</header>	
											<div class="panel-body">
												<div class="chart chart-sm" id="flotDashSales1" style="height: 352px;"></div>

						<!-- Flot: Earning Graph -->
							<script>
								
	var flotDashSales1Data = [{
		 data: [
	
						
						<?php 
						$total=0;
						
						    foreach($result6 as $data ):
						        $month=$data['month'];
						        $total=$data['total'];
						 // echo $month.",".$total;
						?>
						
				    ['<?php echo $month?>', <?php echo $total;?>],
				
					<?php
				       endforeach;
					?> 
				
					    
					     ],
					color: "#2baab1"
			        }];
					</script>
						    
													
					<hr class="solid short mt-lg">
							<div class="row">
							    <?php 
						   foreach($result6 as $data ):
						        $month=$data['month'];
						        $total=$data['total'];
							   // echo $inyanga;
							    ?>
							<div class="col-md-1">
							<div class="h4 text-weight-bold mb-none mt-lg"><?php echo $total;?></div>
								<p class="text-xs text-primary mb-none">
								    <?php echo $month;?>
								</p>
							</div>
													
							<?php endforeach;?>
												</div>
												
												
											</div>
										</section>
						</div>
						
						
					<hr class="solid short mt-lg">
					
											
											
					
							
			</div>			
					
					
											
										
									
								
					
						
						
	
						<!-- start: page -->
					<div class="row">
						<div class="col-md-12 col-lg-12 col-xl-6">
							<section class="panel panel-featured panel-featured-primary">
								<div class="panel-body">
								
								<header class="panel-heading panel-transparent">
								
					
									<h2 class="panel-title">System / Income - 2018</h2>
								</header>
									
									<div class="row">
							<div class="col-lg-8">
							<section class="panel">
									
									<div class="panel-body">
						
									
										
										
											<?php
			
												$incount = $this->db->get_where( 'incomes', array('year' =>'2018' ) )->result_array();
												foreach ( $incount as $rows ): 
												
											$month = $rows['month']; 												
											 if($month == 'Jan')
											 $njan = $rows['system'];
											 else if ($month == 'Feb')
											 $nfeb = $rows['system'];
											 else if ($month == 'Mar')
											 $nmar = $rows['system'];
											 else if ($month == 'Apr')
											 $napr = $rows['system'];
											 else if ($month == 'May')
											 $nmay = $rows['system'];
											 else if ($month == 'Jun')
											 $njun = $rows['system']; 
											 else if ( $month == 'Jul' )
											 $njul = $rows['system'];
											 else if ( $month == 'Aug' )
											 $naug = $rows['system'];
											 else if ( $month == 'Sep' )
											 $nsep = $rows['system'];
											 else if ( $month == 'Oct' )
											 $noct = $rows['system'];
											 else if ( $month == 'Nov' )
											 $nnov = $rows['system'];
											 else if ( $month == 'Dec' )
											 $ndec = $rows['system'];
											 
											 $month = $rows['month']; 												
											 if($month == 'Jan')
											 $njan2 = $rows['actual'];
											 else if ($month == 'Feb')
											 $nfeb2 = $rows['actual'];
											 else if ($month == 'Mar')
											 $nmar2 = $rows['actual'];
											 else if ($month == 'Apr')
											 $napr2 = $rows['actual'];
											 else if ($month == 'May')
											 $nmay2 = $rows['actual'];
											 else if ($month == 'Jun')
											 $njun2 = $rows['actual']; 
											 else if ( $month == 'Jul' )
											 $njul2 = $rows['actual'];
											 else if ( $month == 'Aug' )
											 $naug2 = $rows['actual'];
											 else if ( $month == 'Sep' )
											 $nsep2 = $rows['actual'];
											 else if ( $month == 'Oct' )
											 $noct2 = $rows['actual'];
											 else if ( $month == 'Nov' )
											 $nnov2 = $rows['actual'];
											 else if ( $month == 'Dec' )
											 $ndec2 = $rows['actual'];
									
											endforeach;
												$insystem = $njan + $nfeb + $nmar + $napr + $nmay + $njun + $njul + $naug + $nsep
															+ $noct + $nnov + $ndec; 
												?>
											<!-- Morris: Area -->
										<div class="chart chart-md" id="morrisStacked"></div>
												
												<script type="text/javascript">
						
											var morrisStackedData = [{
												y: 'Jan',
												a:  <?php echo  $njan ?>,
												b: <?php echo  $njan2 ?>
											}, {
												y: 'Feb',
												a:  <?php echo  $nfeb ?>,
												b:  <?php echo  $nfeb2 ?>
											}, {
												y: 'Mar',
												a:  <?php echo  $nmar ?>,
												b:  <?php echo  $nmar2 ?>
											}, {
												y: 'Apr',
												a:  <?php echo  $napr ?>,
												b:  <?php echo  $napr2 ?>
											}, {
												y: 'May',
												a:  <?php echo  $nmay ?>,
												b:  <?php echo  $nmay2 ?>
											}, {
												y: 'Jun',
												a:  <?php echo  $njun ?>,
												b:  <?php echo  $njun2 ?>
											}, {
												y: 'Jul',
												a:  <?php echo  $njul ?>,
												b:  <?php echo  $njul2 ?>
											}, {
												y: 'Aug',
												a:  <?php echo  $naug ?>,
												b:  <?php echo  $naug2 ?>
											}, {
												y: 'Sep',
												a:  <?php echo  $nsep ?>,
												b:  <?php echo  $nsep2 ?>
											}, {
												y: 'Oct',
												a:  <?php echo  $noct ?>,
												b:  <?php echo  $noct2 ?>
											}, {
												y: 'Nov',
												a:  <?php echo  $nnov ?>,
												b:  <?php echo  $nnov2 ?>
											}, {
												y: 'Dec',
												a:  <?php echo  $ndec ?>,
												b:  <?php echo  $ndec ?>
											}];
						
											// See: assets/javascripts/ui-elements/examples.charts.js for more settings.
						
										</script>
						
							<hr class="solid short mt-lg">
												<div class="row">
													<div class="col-md-4">
														<div class="h4 text-weight-bold mb-none mt-lg">E <?php echo number_format($cash2018, 2, '.', ' ') ?></div>
														<p class="text-xs text-primary mb-none">System Cash </p>
													</div>




													<div class="col-md-4">
														<div class="h4 text-weight-bold mb-none mt-lg">E <?php echo number_format($actuals2023, 2, '.', ' ') ?></div>
														<p class="text-xs text-primary mb-none">Actual Cash</p>
													</div>
													<div class="col-md-4">
														<div class="h4 text-weight-bold mb-none mt-lg">E <?php echo number_format($variance2023, 2, '.', ' ') ?></div>
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
						
											var morrisDonutData = [{
												label: "Jan",
												value: <?php echo $njan ?>
											}, {
												label: "Feb",
												value: <?php echo $nfeb ?>
											}, {
												label: "Mar",
												value: <?php echo $nmar ?>
											},
											{
												label: "Apr",
												value: <?php echo $napr ?>
											},
											{
												label: "May",
												value: <?php echo $nmay ?>
											},
											{
												label: "Jun",
												value: <?php echo $njun ?>
											},
											{
												label: "Jul",
												value: <?php echo $njul ?>
											},
											{
												label: "Aug",
												value: <?php echo $naug ?>
											},
											{
												label: "Sep",
												value: <?php echo $nsep ?>
											},
											{
												label: "Oct",
												value: <?php echo $noct ?>
											},
											{
												label: "Nov",
												value: <?php echo $nnov ?>
											},
											{
												label: "Dec",
												value: <?php echo $ndec ?>
											}];
						
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
						                  
			</div>			
						
	

	</div>
					
