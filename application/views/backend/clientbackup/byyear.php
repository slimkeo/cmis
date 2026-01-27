<?php
    $this->db->select("*");
    $this->db->where('year', $year);
    $this->db->from('dailyrecon');
    $query   = $this->db->get();
    $results = $query->result_array();
    
    
    /* $this->db->where('month',$row['month']);
    $this->db->select_sum('total');
    $query = $this->db->get('dailyrecon'); 
    $result6 = $query->row()->total;*/
    
    foreach ($results as $rows):
        $actuals  = $actuals + $rows['actual'];
        $total    = $total + $rows['total'];
        $variance = $variance + $rows['variance'];
        $street_id = $rows['street_id'];
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
                            <h4 class="title"><?php
                                echo get_phrase('total_system');
                                ?></h4>
                            <div class="info">
                                <span class="text-success text-uppercase">E</span>
                                <strong class="amount"><?php
                                    echo number_format($total, 2, '.', ' ');
                                    ?></strong>
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
                            <h4 class="title"><?php
                                echo get_phrase('total_actual');
                                ?></h4>
                            <div class="info">
                                <span class="text-info text-uppercase">E</span>
                                <strong class="amount"> <?php
                                    echo number_format($actuals, 2, '.', ' ');
                                    ?></strong>
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
                            <h4 class="title"><?php
                                echo get_phrase('total_variance');
                                ?></h4>
                            <div class="info">
                                <span class="text-secondary text-uppercase">E</span>
                                <strong class="amount"><?php
                                    echo number_format($variance, 2, '.', ' ');
                                    ?></strong>
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
                        <?php
                            $this->db->select_sum('cash');
                            $gwa = $this->db->get_where('dailybyyear', array(
                                'street_id' => 1,
                                'year' => $year
                            ))->row()->cash;
                            
                            $this->db->select_sum('actual');
                            $gwa2 = $this->db->get_where('dailybyyear', array(
                                'street_id' => 1,
                                'year' => $year
                            ))->row()->actual;
                            
                            $this->db->select_sum('cash');
                            $dze = $this->db->get_where('dailybyyear', array(
                                'street_id' => 2,
                                'year' => $year
                            ))->row()->cash;
                            
                            $this->db->select_sum('actual');
                            $dze2 = $this->db->get_where('dailybyyear', array(
                                'street_id' => 2,
                                'year' => $year
                            ))->row()->actual;
                            
                            
                            $this->db->select_sum('cash');
                            $zwi = $this->db->get_where('dailybyyear', array(
                                'street_id' => 12,
                                'year' => $year
                            ))->row()->cash;
                            
                            $this->db->select_sum('actual');
                            $zwi2 = $this->db->get_where('dailybyyear', array(
                                'street_id' => 12,
                                'year' => $year
                            ))->row()->actual;
                            
                            $this->db->select_sum('cash');
                            $bet = $this->db->get_where('dailybyyear', array(
                                'street_id' => 4,
                                'year' => $year
                            ))->row()->cash;
                            
                            $this->db->select_sum('actual');
                            $bet2 = $this->db->get_where('dailybyyear', array(
                                'street_id' => 4,
                                'year' => $year
                            ))->row()->actual;
                            
                            $this->db->select_sum('cash');
                            $msa = $this->db->get_where('dailybyyear', array(
                                'street_id' => 9,
                                'year' => $year
                            ))->row()->cash;
                            
                            $this->db->select_sum('actual');
                            $msa2 = $this->db->get_where('dailybyyear', array(
                                'street_id' => 9,
                                'year' => $year
                            ))->row()->actual;
                            
                            
                            $this->db->select_sum('cash');
                            $mda = $this->db->get_where('dailybyyear', array(
                                'street_id' => 8,
                                'year' => $year
                            ))->row()->cash;
                            
                            $this->db->select_sum('actual');
                            $mda2 = $this->db->get_where('dailybyyear', array(
                                'street_id' => 8,
                                'year' => $year
                            ))->row()->actual;
                            
                            $this->db->select_sum('cash');
                            $mah = $this->db->get_where('dailybyyear', array(
                                'street_id' => 7,
                                'year' => $year
                            ))->row()->cash;
                            
                            $this->db->select_sum('actual');
                            $mah2 = $this->db->get_where('dailybyyear', array(
                                'street_id' => 7,
                                'year' => $year
                            ))->row()->actual;
                            
                            $this->db->select_sum('cash');
                            $lib = $this->db->get_where('dailybyyear', array(
                                'street_id' => 6,
                                'year' => $year
                            ))->row()->cash;
                            
                            $this->db->select_sum('actual');
                            $lib2 = $this->db->get_where('dailybyyear', array(
                                'street_id' => 6,
                                'year' => $year
                            ))->row()->actual;
                            
                            $this->db->select_sum('cash');
                            $mcc = $this->db->get_where('dailybyyear', array(
                                'street_id' => 17,
                                'year' => $year
                            ))->row()->cash;
                            
                            $this->db->select_sum('actual');
                            $mcc2 = $this->db->get_where('dailybyyear', array(
                                'street_id' => 17,
                                'year' => $year
                            ))->row()->actual;
                            
                            $this->db->select_sum('cash');
                            $obr = $this->db->get_where('dailybyyear', array(
                                'street_id' => 16,
                                'year' => $year
                            ))->row()->cash;
                            
                            $this->db->select_sum('actual');
                            $obr2 = $this->db->get_where('dailybyyear', array(
                                'street_id' => 16,
                                'year' => $year
                            ))->row()->actual;
                            
                            $this->db->select_sum('cash');
                            $nju = $this->db->get_where('dailybyyear', array(
                                'street_id' => 15,
                                'year' => $year
                            ))->row()->cash;
                            
                            $this->db->select_sum('actual');
                            $nju = $this->db->get_where('dailybyyear', array(
                                'street_id' => 15,
                                'year' => $year
                            ))->row()->actual;
                            
                            $this->db->select_sum('cash');
                            $rel = $this->db->get_where('dailybyyear', array(
                                'street_id' => 22,
                                'year' => $year
                            ))->row()->cash;
                            
                            $this->db->select_sum('actual');
                            $rel2 = $this->db->get_where('dailybyyear', array(
                                'street_id' => 22,
                                'year' => $year
                            ))->row()->actual;
                            
                            
                            $this->db->select_sum('cash');
                            $enf = $this->db->get_where('dailybyyear', array(
                                'street_id' => 23,
                                'year' => $year
                            ))->row()->cash;
                            
                            $this->db->select_sum('actual');
                            $enf2 = $this->db->get_where('dailybyyear', array(
                                'street_id' => 23,
                                'year' => $year
                            ))->row()->actual;
                            
                            
                            
                            ?>
                        <!-- Morris: Line -->
                        <div class="chart chart-md" id="morrisBar"></div>
                        <script type="text/javascript">
                            var morrisBarData = [{
                                y: 'GWA',
                                a:  <?php
                                echo $gwa;
                                ?>,
                                b: <?php
                                echo $gwa2;
                                ?>
                            },{
                                y: 'DZE',
                                a:  <?php
                                echo $dze;
                                ?>,
                                b: <?php
                                echo $dze2;
                                ?>
                            },{
                                y: 'ZWI',
                                a:  <?php
                                echo $zwi;
                                ?>,
                                b: <?php
                                echo $zwi2;
                                ?>
                            },{
                                y: 'BET',
                                a:  <?php
                                echo $bet;
                                ?>,
                                b: <?php
                                echo $bet2;
                                ?>
                            },{
                                y: 'MSA',
                                a:  <?php
                                echo $msa;
                                ?>,
                                b: <?php
                                echo $msa2;
                                ?>
                            },{
                                y: 'MDA',
                                a:  <?php
                                echo $mda;
                                ?>,
                                b: <?php
                                echo $mda2;
                                ?>
                            },{
                                y: 'MAH',
                                a:  <?php
                                echo $mah;
                                ?>,
                                b: <?php
                                echo $mah2;
                                ?>
                            }, {
                                y: 'LIB',
                                a:  <?php
                                echo $lib;
                                ?>,
                                b: <?php
                                echo $lib2;
                                ?>
                            }, {
                                y: 'MCC',
                                a:  <?php
                                echo $mcc;
                                ?>,
                                b: <?php
                                echo $mcc2;
                                ?>
                            }, {
                                y: 'OBR',
                                a:  <?php
                                echo $obr;
                                ?>,
                                b: <?php
                                echo $obr2;
                                ?>
                            }, {
                                y: 'REL',
                                a:  <?php
                                echo $rel;
                                ?>,
                                b: <?php
                                echo $rel2;
                                ?>
                            }];
                            
                            // See: js/examples/examples.charts.js for more settings.
                            
                        </script>
                        <hr class="solid short mt-lg">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="h4 text-weight-bold mb-none mt-lg">E <?php
                                    echo number_format($total, 2, '.', ' ');
                                    ?></div>
                                <p class="text-xs text-primary mb-none">System Cash </p>
                            </div>
                            <div class="col-md-4">
                                <div class="h4 text-weight-bold mb-none mt-lg">E <?php
                                    echo number_format($actuals, 2, '.', ' ');
                                    ?></div>
                                <p class="text-xs text-primary mb-none">Actual Cash</p>
                            </div>
                            <div class="col-md-4">
                                <div class="h4 text-weight-bold mb-none mt-lg">E <?php
                                    echo number_format($variance, 2, '.', ' ');
                                    ?></div>
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
                    <h2 class="panel-title">Money Brought in Report - <?php
                        echo $year;
                        ?></h2>
                    <?php
                        $streetlist = $this->db->get('street')->result_array();
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
                                    foreach ($streetlist as $str):
                                        if ($str['street_id'] == 1):
                                            $first = 'GWA';
                                            $this->db->select_sum('actual');
                                            $actualcash = $this->db->get_where('dailybyyear', array(
                                                'street_id' => $str['street_id'],
                                                'year' => $year
                                            ))->row()->actual;
                                        endif;
                                        if ($str['street_id'] == 2):
                                            $first = 'DZE';
                                            $this->db->select_sum('actual');
                                            $actualcash = $this->db->get_where('dailybyyear', array(
                                                'street_id' => $str['street_id'],
                                                'year' => $year
                                            ))->row()->actual;
                                        endif;
                                        
                                        if ($str['street_id'] == 12):
                                            $first = 'ZWI';
                                            $this->db->select_sum('actual');
                                            $actualcash = $this->db->get_where('dailybyyear', array(
                                                'street_id' => $str['street_id'],
                                                'year' => $year
                                            ))->row()->actual;
                                        endif;
                                        
                                        if ($str['street_id'] == 4):
                                            $first = 'BET';
                                            $this->db->select_sum('actual');
                                            $actualcash = $this->db->get_where('dailybyyear', array(
                                                'street_id' => $str['street_id'],
                                                'year' => $year
                                            ))->row()->actual;
                                        endif;
                                        
                                        if ($str['street_id'] == 9):
                                            $first = 'MSA';
                                            $this->db->select_sum('actual');
                                            $actualcash = $this->db->get_where('dailybyyear', array(
                                                'street_id' => $str['street_id'],
                                                'year' => $year
                                            ))->row()->actual;
                                        endif;
                                        
                                        if ($str['street_id'] == 8):
                                            $first = 'MDA';
                                            $this->db->select_sum('actual');
                                            $actualcash = $this->db->get_where('dailybyyear', array(
                                                'street_id' => $str['street_id'],
                                                'year' => $year
                                            ))->row()->actual;
                                        endif;
                                        
                                        if ($str['street_id'] == 7):
                                            $first = 'MAH';
                                            $this->db->select_sum('actual');
                                            $actualcash = $this->db->get_where('dailybyyear', array(
                                                'street_id' => $str['street_id'],
                                                'year' => $year
                                            ))->row()->actual;
                                        endif;
                                        
                                        if ($str['street_id'] == 6):
                                            $first = 'LIB';
                                            $this->db->select_sum('actual');
                                            $actualcash = $this->db->get_where('dailybyyear', array(
                                                'street_id' => $str['street_id'],
                                                'year' => $year
                                            ))->row()->actual;
                                        endif;
                                        
                                        if ($str['street_id'] == 17):
                                            $first = 'MCC';
                                            $this->db->select_sum('actual');
                                            $actualcash = $this->db->get_where('dailybyyear', array(
                                                'street_id' => $str['street_id'],
                                                'year' => $year
                                            ))->row()->actual;
                                        endif;
                                        
                                        if ($str['street_id'] == 16):
                                            $first = 'OBR';
                                            $this->db->select_sum('actual');
                                            $actualcash = $this->db->get_where('dailybyyear', array(
                                                'street_id' => $str['street_id'],
                                                'year' => $year
                                            ))->row()->actual;
                                        endif;
                                        
                                        if ($str['street_id'] == 15):
                                            $first = 'NJU';
                                            $this->db->select_sum('actual');
                                            $actualcash = $this->db->get_where('dailybyyear', array(
                                                'street_id' => $str['street_id'],
                                                'year' => $year
                                            ))->row()->actual;
                                        endif;
                                        
                                        if ($str['street_id'] == 22):
                                            $first = 'REL';
                                            $this->db->select_sum('actual');
                                            $actualcash = $this->db->get_where('dailybyyear', array(
                                                'street_id' => $str['street_id'],
                                                'year' => $year
                                            ))->row()->actual;
                                        endif;
                                        
                                        if ($str['street_id'] == 23):
                                            $first = 'ENF';
                                            $this->db->select_sum('actual');
                                            $actualcash = $this->db->get_where('dailybyyear', array(
                                                'street_id' => $str['street_id'],
                                                'year' => $year
                                            ))->row()->actual;
                                        endif;
                                        
                                        if ($str['street_id'] == 18):
                                            $first = 'TEB';
                                            $this->db->select_sum('actual');
                                            $actualcash = $this->db->get_where('dailybyyear', array(
                                                'street_id' => $str['street_id'],
                                               'year' => $year
                                            ))->row()->actual;
                                        endif;
                                        
                                        if ($str['street_id'] == 14):
                                            $first = 'SIY';
                                            $this->db->select_sum('actual');
                                            $actualcash = $this->db->get_where('dailybyyear', array(
                                                'street_id' => $str['street_id'],
                                                'year' => $year
                                            ))->row()->actual;
                                        endif;
                                        
                                    ?>
                                
                                    
                                
                                         ["<?php
                                    echo $first;
                                    ?>", <?php
                                    echo $actualcash;
                                    ?>],
                                
                                        <?php
                                    endforeach;
                                    ?>
                                ],
                                 color: "#2baab1"
                                }];
                                // See: assets/javascripts/dashboard/custom_dashboard.js for more settings.
                            </script>
                        </div>
                    </div>
            </section>
            <div class="col-lg-8" data-appear-animation="bounceIn">
            <section class="panel">
            <header class="panel-heading">
            <h2 class="panel-title">Total Revenue Per Street</h2>
            </header>
            <div class="panel-body">
            <div class="row">
            <div class="col-lg-12" data-appear-animation="fadeInRightBig">
            <table class="table table-bordered table-striped table-condensed mb-none" id="datatable-tabletools">
            <thead>
            <tr>
            <th><div><?php echo get_phrase('street');?></div></th>
            <th><div><?php echo get_phrase('total'); ?></div></th>
            <th><div><?php  echo get_phrase('actual'); ?></div></th>
            <th><div><?php echo get_phrase('variance'); ?></div></th>
            <th><div><?php echo get_phrase('loss/gain');?></div></th>
            </tr>
            </thead>
            <tbody>
            <?php
                $count = 1;
                foreach ($streetlist as $str):
				$street_name = $str['street_name'];
                $this->db->select_sum('actual');
                $actualcash = $this->db->get_where('dailybyyear', array('street_id' => $str['street_id'],'year' => $year))->row()->actual;
                
				
				$this->db->select_sum('cash');
                $totalcash = $this->db->get_where('dailybyyear', array('street_id' => $str['street_id'],'year' => $year))->row()->cash;                 
				$this->db->select_sum('variance');
                $variancecash = $this->db->get_where('dailybyyear', array('street_id' => $str['street_id'],'year' => $year))->row()->variance;
                
                
                $percentage = ($variancecash / $totalcash) * 100;
							
							if($percentage > 1){
							   
							  $ciklasi = 'text-danger'; 
							    
							}else{
							    
							    $ciklasi = 'text-success'; 
							}
				
                ?>
            <tr>
            <td><?php echo $street_name; ?></td>
            <td><?php echo number_format($actualcash, 2, '.', ' ') ?></td>                            
            <td><?php echo number_format($totalcash, 2, '.', ' ') ?></td>
            <td><?php echo number_format($variancecash, 2, '.', ' ') ?></td>
            <td class='<?php echo $ciklasi; ?>'><?php echo number_format($percentage, 2, '.', ' '). ' %' ?></td>
            </tr>
            <?php
                endforeach;
                ?>
            </tbody>
            </table>
            </div>
            </div>
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
												label: "Gwamile",
												data: [
													[1, <?php echo number_format($gwa2); ?>]
												],
												color: '#F39C12'
											}, {
												label: "Dzeliwe",
												data: [
													[1, <?php echo number_format($dze); ?>]
												],
												color: '#8E44AD'
											}, {
												label: "Betfusile",
												data: [
													[1, <?php echo number_format($bet); ?>]
												],
												color: '#283747'
											}, {
												label: "OBR",
												data: [
													[1, <?php echo number_format($obr); ?>]
												],
												color: '#E74C3C'
											}, {
												label: "Mahlokohla",
												data: [
													[1, <?php echo number_format($mah); ?>]
												],
												color: '#4A235A'
											}, {
												label: "Mdada",
												data: [
													[1, <?php echo number_format($mda); ?>]
												],
												color: '#16A085'
											}, {
												label: "MCC",
												data: [
													[1, <?php echo number_format($mcc); ?>]
												],
												color: '#F35703'
											}];
						
											// See: assets/javascripts/ui-elements/examples.charts.js for more settings.
						
										</script>
									
									</div>
								</section>
								
							</div>
							
						</div>
          
           
            </div>
        </div>
        <!-- end: page -->
    </div>
    </section>
</div>
</div>