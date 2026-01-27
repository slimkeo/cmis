<section class="panel">



<div class="panel-body">
	<div class="row">
		<div class="col-md-4"></div>
		<div class="col-md-4">
			<div class="form_group">
				<label class="control-label mb-xs"><?php echo get_phrase('Select Date');?> <span class="required">*</span></label>
	
				
				<?php
		$query = $this->db->get( 'dates' );
		$ticketsmarch = $query->result_array();
		?>
				<select data-plugin-selectTwo class="form-control populate" id="date" name="date" onchange="class_section(this.value)" style="width: 100%">
					
					
					<option value=""><?php echo get_phrase('select_date'); ?></option>
					<?php foreach ($ticketsmarch as $row): ?>
					<option value="<?php echo $row['date']; ?>" <?php if ($date == $row[ 'date']) echo 'selected'; ?> ><?php echo $row['date']; ?></option>
					<?php endforeach; ?>
				</select>
				
				
				
			</div>
		</div>


	<br><br>

		<?php
		$query = $this->db->get_where( 'dates', array( 'date' => $date ) );
		if ( $query->num_rows() > 0 && $date != '' ):
			$capture = $query->result_array();
		foreach ( $capture as $row ):
		
	
			?>
	

<div class="row">
	<div class="col-md-12">
	
			<?php
			$dayincome = $this->db->get_where( 'tickets', array('indate' => $date) )->result_array();
			$todayincome = 0;
			foreach ( $dayincome as $rowd ):
			$todayincome = $todayincome + $rowd[ 'parkingAmount' ] ;
			endforeach;
		 ?>
	

		<!---CONTROL TABS START-->
		<div class="tabs">
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#list" data-toggle="tab"><i class="fa fa-list"></i> 
					<?php echo get_phrase('report_by_date');?>
					
					<?php - 
  $currentDateTime = $row['date'];
  echo $currentDateTime;
 ?>
						</a></li>
						
					
			
		</ul>
		<!---CONTROL TABS END-->

		<div class="tab-content">
		
			
		
		<br>
			<!--TABLE LISTING STARTS-->
			<div class="tab-pane box active" id="list">
				<table class="table table-bordered table-striped table-condensed mb-none" id="datatable-tabletools">
					<thead>
						<tr>
						<th>#</th>
							
							<th><div><?php echo get_phrase('marshal');?></div></th>
							<th><div><?php echo get_phrase('parking');?></div></th>
							<th><div><?php echo get_phrase('overstay');?></div></th>
							<th><div><?php echo get_phrase('clampings');?></div></th>
							<th><div><?php echo get_phrase('total');?></div></th>
							<th><div><?php echo get_phrase('actual');?></div></th>
							<th><div><?php echo get_phrase('variance');?></div></th>
							<th><div><?php echo get_phrase('signature');?></div></th>
						</tr>
					</thead>
					<tbody>
					
					
					<?php 
					
						$count = 1;
						
						 $assignment = $this->db->get_where('assignment')->result_array();
                                foreach($assignment as $row):?>
						<?php ?>
						<tr>
							<th><?php echo $row['assignment_id']; ?></th>
							
							<td>	
							<?php echo $this->db->get_where('marshal' , array(
                                        'marshal_id' => $row['marshal_id']
                                    ))->row()->name;
                                ?>
							</td>	
							<?php 
							
		 $timestamp = $this->db->get_where('ticketsmarch' , array('indate' => $currentDateTime, 'assignment_id' => $row['assignment_id']))->result_array();
				 
                  $allmoney = $allmoney + $timestamp['parkingAmount']; 

				   foreach($timestamp as $times):
				   
				   $newTime = $times['indate'];
				   $descript = $times['ticket_description'];
				   
				   $assignmentID = $times['assignment_id'];

									
							if($descript == 'park')	{	
							
									
									if($assignmentID == 30){
									$parkcash1 = $parkcash1 + $times['parkingAmount'];
									}elseif($assignmentID == 31){
									$parkcash2 = $parkcash2 + $times['parkingAmount'];
									}elseif($assignmentID == 32){
									$parkcash3 = $parkcash3 + $times['parkingAmount'];
									}elseif($assignmentID == 33){
									$parkcash4 = $parkcash4 + $times['parkingAmount'];
									}elseif($assignmentID == 34){
									$parkcash5 = $parkcash5 + $times['parkingAmount'];
									}elseif($assignmentID == 35){
									$parkcash6 = $parkcash6 + $times['parkingAmount'];
									}elseif($assignmentID == 36){
									$parkcash7 = $parkcash7 + $times['parkingAmount'];
									}elseif($assignmentID == 37){
									$parkcash8 = $parkcash8 + $times['parkingAmount'];
									}elseif($assignmentID == 38){
									$parkcash9 = $parkcash9 + $times['parkingAmount'];
									}elseif($assignmentID == 39){
									$parkcash10 = $parkcash10 + $times['parkingAmount'];
									}elseif($assignmentID == 40){
									$parkcash11 = $parkcash11 + $times['parkingAmount'];
									}elseif($assignmentID == 41){
									$parkcash12 = $parkcash12 + $times['parkingAmount'];
									}elseif($assignmentID == 42){
									$parkcash13 = $parkcash13 + $times['parkingAmount'];
									}elseif($assignmentID == 43){
									$parkcash14 = $parkcash14 + $times['parkingAmount'];
									}elseif($assignmentID == 44){
									$parkcash15 = $parkcash15 + $times['parkingAmount'];
									}elseif($assignmentID == 45){
									$parkcash16 = $parkcash16 + $times['parkingAmount'];
									}elseif($assignmentID == 46){
									$parkcash17 = $parkcash17 + $times['parkingAmount'];
									}elseif($assignmentID == 47){
									$parkcash18 = $parkcash18 + $times['parkingAmount'];
									}elseif($assignmentID == 48){
									$parkcash19 = $parkcash19 + $times['parkingAmount'];
									}elseif($assignmentID == 49){
									$parkcash20 = $parkcash20 + $times['parkingAmount'];
									}elseif($assignmentID == 50){
									$parkcash21 = $parkcash21 + $times['parkingAmount'];
									}elseif($assignmentID == 51){
									$parkcash22 = $parkcash22 + $times['parkingAmount'];
									}elseif($assignmentID == 52){
									$parkcash23 = $parkcash23 + $times['parkingAmount'];
									}elseif($assignmentID == 53){
									$parkcash24 = $parkcash24 + $times['parkingAmount'];
									}elseif($assignmentID == 54){
									$parkcash25 = $parkcash25 + $times['parkingAmount'];
									}elseif($assignmentID == 55){
									$parkcash26 = $parkcash26 + $times['parkingAmount'];
									}elseif($assignmentID == 56){
									$parkcash27 = $parkcash27 + $times['parkingAmount'];
                                    }elseif($assignmentID == 57){
									$parkcash28 = $parkcash28 + $times['parkingAmount'];
				                    }elseif($assignmentID == 59){
									$parkcash29 = $parkcash29 + $times['parkingAmount'];
									}elseif($assignmentID == 60){
									$parkcash30 = $parkcash30 + $times['parkingAmount'];
                                    }elseif($assignmentID == 63){
									$parkcash31 = $parkcash31 + $times['parkingAmount'];
								    }elseif($assignmentID == 66){
									$parkcash34 = $parkcash34 + $times['parkingAmount'];
                                    }elseif($assignmentID == 70){
									$parkcash35 = $parkcash35 + $times['parkingAmount'];
                                    }elseif($assignmentID == 71){
									$parkcash36 = $parkcash36 + $times['parkingAmount'];
                                    }elseif($assignmentID == 72){
									$parkcash37 = $parkcash37 + $times['parkingAmount'];
                                    }elseif($assignmentID == 73){
									$parkcash38 = $parkcash38 + $times['parkingAmount'];
                                    }
								}
				   endforeach;
				   
						
						?>						
							<td>
							<?php
							
							if($assignmentID == 30 ){
							$cash = $parkcash1; 
							if($cash != ''){
									echo $parkcash1;  
								}else{	
								echo "0";
							}
							
								 }elseif($assignmentID == 31 ){
								 echo $cash = $parkcash2; 
								 }elseif($assignmentID == 32 ){
								 echo $cash = $parkcash3; 
								 }elseif($assignmentID == 33 ){
								 echo $cash = $parkcash4; 
								 }elseif($assignmentID == 34 ){
								 echo $cash = $parkcash5; 
								 }elseif($assignmentID == 35 ){
								 echo $cash = $parkcash6; 
								 }elseif($assignmentID == 36 ){
								 echo $cash = $parkcash7; 
								 }elseif($assignmentID == 37 ){
								 echo $cash = $parkcash8; 
								 }elseif($assignmentID == 38 ){
								 echo $cash = $parkcash9; 
								 }elseif($assignmentID == 39 ){
								 echo $cash = $parkcash10; 
								 }elseif($assignmentID == 40 ){
								 echo $cash = $parkcash11; 
								 }elseif($assignmentID == 41 ){
								 echo $cash = $parkcash12; 
								 }elseif($assignmentID == 42 ){
								 echo $cash = $parkcash13; 
								 }elseif($assignmentID == 43 ){
								 echo $cash = $parkcash14; 
								 }elseif($assignmentID == 44 ){
								 echo $cash = $parkcash15; 
								 }elseif($assignmentID == 45 ){
								 echo $cash = $parkcash16; 
								 }elseif($assignmentID == 46 ){
								 echo $cash = $parkcash17; 
								 }elseif($assignmentID == 47 ){
								 echo $cash = $parkcash18; 
								 }elseif($assignmentID == 48 ){
								 echo $cash = $parkcash19; 
								 }elseif($assignmentID == 49 ){
								 echo $cash = $parkcash20; 
								 }elseif($assignmentID == 50 ){
								 echo $cash = $parkcash21; 
								 }elseif($assignmentID == 51 ){
								 echo $cash = $parkcash22; 
								 }elseif($assignmentID == 52 ){
								 echo $cash = $parkcash23; 
								 }elseif($assignmentID == 53 ){
								 echo $cash = $parkcash24; 
								 }elseif($assignmentID == 54 ){
								 echo $cash = $parkcash25; 
								 }elseif($assignmentID == 55 ){
								 echo $cash = $parkcash26; 
								 }elseif($assignmentID == 56 ){
								 echo $cash = $parkcash27; 
								 }elseif($assignmentID == 57 ){
								 echo $cash = $parkcash28; 
								 }elseif($assignmentID == 59 ){
								 echo $cash = $parkcash29; 
								 }elseif($assignmentID == 60 ){
								 echo $cash = $parkcash30; 
								 }elseif($assignmentID == 63 ){
								 echo $cash = $parkcash31; 
								 }elseif($assignmentID == 66 ){
								 echo $cash = $parkcash34; 
								 }elseif($assignmentID == 70 ){
								 echo $cash = $parkcash35; 
								 }elseif($assignmentID == 71 ){
								 echo $cash = $parkcash36; 
								 }elseif($assignmentID == 72 ){
								 echo $cash = $parkcash37; 
								 }elseif($assignmentID == 73 ){
								 echo $cash = $parkcash38; 
								 }
								
								
								 ?>
							</td>
									<?php 
								
                                foreach($timestamp as $overs):
				   
				   $newTime = $overs['indate'];
				   $description = $overs['ticket_description'];
				   
				   $assignmentID = $overs['assignment_id'];
									
							if($description == 'Overstay')	{	 
									
									if($assignmentID == 30){
									$overcash1 = $overcash1 + $overs['parkingAmount'];
									}elseif($assignmentID == 31){
									$overcash2 = $overcash2 + $overs['parkingAmount'];
									}elseif($assignmentID == 32){
									$overcash3 = $overcash3 + $overs['parkingAmount'];
									}elseif($assignmentID == 33){
									$overcash4 = $overcash4 + $overs['parkingAmount'];
									}elseif($assignmentID == 34){
									$overcash5 = $overcash5 + $overs['parkingAmount'];
									}elseif($assignmentID == 35){
									$overcash6 = $overcash6 + $overs['parkingAmount'];
									}elseif($assignmentID == 36){
									$overcash7 = $overcash7 + $overs['parkingAmount'];
									}elseif($assignmentID == 37){
									$overcash8 = $overcash8 + $overs['parkingAmount'];
									}elseif($assignmentID == 38){
									$overcash9 = $overcash9 + $overs['parkingAmount'];
									}elseif($assignmentID == 39){
									$overcash10 = $overcash10 + $overs['parkingAmount'];
									}elseif($assignmentID == 40){
									$overcash11 = $overcash11 + $overs['parkingAmount'];
									}elseif($assignmentID == 41){
									$overcash12 = $overcash12 + $overs['parkingAmount'];
									}elseif($assignmentID == 42){
									$overcash13 = $overcash13 + $overs['parkingAmount'];
									}elseif($assignmentID == 43){
									$overcash14 = $overcash14 + $overs['parkingAmount'];
									}elseif($assignmentID == 44){
									$overcash15 = $overcash15 + $overs['parkingAmount'];
									}elseif($assignmentID == 45){
									$overcash16 = $overcash16 + $overs['parkingAmount'];
									}elseif($assignmentID == 46){
									$overcash17 = $overcash17 + $overs['parkingAmount'];
									}elseif($assignmentID == 47){
									$overcash18 = $overcash18 + $overs['parkingAmount'];
									}elseif($assignmentID == 48){
									$overcash19 = $overcash19 + $overs['parkingAmount'];
									}elseif($assignmentID == 49){
									$overcash20 = $overcash20 + $overs['parkingAmount'];
									}elseif($assignmentID == 50){
									$overcash21 = $overcash21 + $overs['parkingAmount'];
									}elseif($assignmentID == 51){
									$overcash22 = $overcash22 + $overs['parkingAmount'];
									}elseif($assignmentID == 52){
									$overcash23 = $overcash23 + $overs['parkingAmount'];
									}elseif($assignmentID == 53){
									$overcash24 = $overcash24 + $overs['parkingAmount'];
									}elseif($assignmentID == 54){
									$overcash25 = $overcash25 + $overs['parkingAmount'];
									}elseif($assignmentID == 55){
									$overcash26 = $overcash26 + $overs['parkingAmount'];
									}elseif($assignmentID == 56){
									$overcash27 = $overcash27 + $overs['parkingAmount'];
                                    }elseif($assignmentID == 57){
									$overcash28 = $overcash28 + $overs['parkingAmount'];
				                    }elseif($assignmentID == 59){
									$overcash29 = $overcash29 + $overs['parkingAmount'];
									}elseif($assignmentID == 60){
									$overcash30 = $overcash30 + $overs['parkingAmount'];
                                    }elseif($assignmentID == 63){
									$overcash31 = $overcash31 + $overs['parkingAmount'];
								    }elseif($assignmentID == 66){
									$overcash34 = $overcash34 + $overs['parkingAmount'];
                                    }elseif($assignmentID == 68){
									$overcash35 = $overcash35 + $overs['parkingAmount'];
                                    }elseif($assignmentID == 70){
									$overcash36 = $overcash36 + $overs['parkingAmount'];
                                    }elseif($assignmentID == 71){
									$overcash37 = $overcash37 + $overs['parkingAmount'];
                                    }elseif($assignmentID == 72){
									$overcash38 = $overcash38 + $overs['parkingAmount'];
                                    }elseif($assignmentID == 73){
									$overcash39 = $overcash39 + $overs['parkingAmount'];
                                    }
								}
				   endforeach;
				   
						
						?>						
												
							<td><?php
									if($assignmentID == 30 ){
								 echo $cashs = $overcash1; 
								 }elseif($assignmentID == 31 ){
								 echo $cashs = $overcash2; 
								 }elseif($assignmentID == 32 ){
								 echo $cashs = $overcash3; 
								 }elseif($assignmentID == 33 ){
								 echo $cashs = $overcash4; 
								 }elseif($assignmentID == 34 ){
								 echo $cashs = $overcash5; 
								 }elseif($assignmentID == 35 ){
								 echo $cashs = $overcash6; 
								 }elseif($assignmentID == 36 ){
								 echo $cashs = $overcash7; 
								 }elseif($assignmentID == 37 ){
								 echo $cashs = $overcash8; 
								 }elseif($assignmentID == 38 ){
								 echo $cashs = $overcash9; 
								 }elseif($assignmentID == 39 ){
								 echo $cashs = $overcash10; 
								 }elseif($assignmentID == 40 ){
								 echo $cashs = $overcash11; 
								 }elseif($assignmentID == 41 ){
								 echo $cashs = $overcash12; 
								 }elseif($assignmentID == 42 ){
								 echo $cashs = $overcash13; 
								 }elseif($assignmentID == 43 ){
								 echo $cashs = $overcash14; 
								 }elseif($assignmentID == 44 ){
								 echo $cashs = $overcash15; 
								 }elseif($assignmentID == 45 ){
								 echo $cashs = $overcash16; 
								 }elseif($assignmentID == 46 ){
								 echo $cashs = $overcash17; 
								 }elseif($assignmentID == 47 ){
								 echo $cashs = $overcash18; 
								 }elseif($assignmentID == 48 ){
								 echo $cashs = $overcash19; 
								 }elseif($assignmentID == 49 ){
								 echo $cashs = $overcash20; 
								 }elseif($assignmentID == 50 ){
								 echo $cashs = $overcash21; 
								 }elseif($assignmentID == 51 ){
								 echo $cashs = $overcash22; 
								 }elseif($assignmentID == 52 ){
								 echo $cashs = $overcash23; 
								 }elseif($assignmentID == 53 ){
								 echo $cashs = $overcash24; 
								 }elseif($assignmentID == 54 ){
								 echo $cashs = $overcash25; 
								 }elseif($assignmentID == 55 ){
								 echo $cashs = $overcash26; 
								 }elseif($assignmentID == 56 ){
								 echo $cashs = $overcash27; 
								 }elseif($assignmentID == 57 ){
								 echo $cashs = $overcash28; 
								 }elseif($assignmentID == 59 ){
								 echo $cashs = $overcash29; 
								 }elseif($assignmentID == 60 ){
								 echo $cashs = $overcash30; 
								 }elseif($assignmentID == 63 ){
								 echo $cashs = $overcash31; 
								 }elseif($assignmentID == 66 ){
								 echo $cashs = $overcash34; 
								 }elseif($assignmentID == 68 ){
								 echo $cashs = $overcash35; 
								 }elseif($assignmentID == 70 ){
								 echo $cashs = $overcash36; 
								 }elseif($assignmentID == 71 ){
								 echo $cashs = $overcash37; 
								 }elseif($assignmentID == 72 ){
								 echo $cashs = $overcash38; 
								 }elseif($assignmentID == 73 ){
								 echo $cashs = $overcash39; 
								 }
								
																 
								 ?>
							</td>
							
							
							<?php
							       foreach($timestamp as $clamp):
				   
				   $newdate = $clamp['indate'];
				   $descriptions = $clamp['ticket_description'];
				   
				   $assignmentID = $clamp['assignment_id'];
									
							if($descriptions == 'clamp')	{	 
									
									if($assignmentID == 30){
									$clampcash1 = $clampcash1 + $clamp['parkingAmount'];
									}elseif($assignmentID == 31){
									$clampcash2 = $clampcash2 + $clamp['parkingAmount'];
									}elseif($assignmentID == 32){
									$clampcash3 = $clampcash3 + $clamp['parkingAmount'];
									}elseif($assignmentID == 33){
									$clampcash4 = $clampcash4 + $clamp['parkingAmount'];
									}elseif($assignmentID == 34){
									$clampcash5 = $clampcash5 + $clamp['parkingAmount'];
									}elseif($assignmentID == 35){
									$clampcash6 = $clampcash6 + $clamp['parkingAmount'];
									}elseif($assignmentID == 36){
									$clampcash7 = $clampcash7 + $clamp['parkingAmount'];
									}elseif($assignmentID == 37){
									$clampcash8 = $clampcash8 + $clamp['parkingAmount'];
									}elseif($assignmentID == 38){
									$clampcash9 = $clampcash9 + $clamp['parkingAmount'];
									}elseif($assignmentID == 39){
									$clampcash10 = $clampcash10 + $clamp['parkingAmount'];
									}elseif($assignmentID == 40){
									$clampcash11 = $clampcash11 + $clamp['parkingAmount'];
									}elseif($assignmentID == 41){
									$clampcash12 = $clampcash12 + $clamp['parkingAmount'];
									}elseif($assignmentID == 42){
									$clampcash13 = $clampcash13 + $clamp['parkingAmount'];
									}elseif($assignmentID == 43){
									$clampcash14 = $clampcash14 + $clamp['parkingAmount'];
									}elseif($assignmentID == 44){
									$clampcash15 = $clampcash15 + $clamp['parkingAmount'];
									}elseif($assignmentID == 45){
									$clampcash16 = $clampcash16 + $clamp['parkingAmount'];
									}elseif($assignmentID == 46){
									$clampcash17 = $clampcash17 + $clamp['parkingAmount'];
									}elseif($assignmentID == 47){
									$clampcash18 = $clampcash18 + $clamp['parkingAmount'];
									}elseif($assignmentID == 48){
									$clampcash19 = $clampcash19 + $clamp['parkingAmount'];
									}elseif($assignmentID == 49){
									$clampcash20 = $clampcash20 + $clamp['parkingAmount'];
									}elseif($assignmentID == 50){
									$clampcash21 = $clampcash21 + $clamp['parkingAmount'];
									}elseif($assignmentID == 51){
									$clampcash22 = $clampcash22 + $clamp['parkingAmount'];
									}elseif($assignmentID == 52){
									$clampcash23 = $clampcash23 + $clamp['parkingAmount'];
									}elseif($assignmentID == 53){
									$clampcash24 = $clampcash24 + $clamp['parkingAmount'];
									}elseif($assignmentID == 54){
									$clampcash25 = $clampcash25 + $clamp['parkingAmount'];
									}elseif($assignmentID == 55){
									$clampcash26 = $clampcash26 + $clamp['parkingAmount'];
									}elseif($assignmentID == 56){
									$clampcash27 = $clampcash27 + $clamp['parkingAmount'];
                                    }elseif($assignmentID == 57){
									$clampcash28 = $clampcash28 + $clamp['parkingAmount'];
				                    }elseif($assignmentID == 59){
									$clampcash29 = $clampcash29 + $clamp['parkingAmount'];
									}elseif($assignmentID == 60){
									$clampcash30 = $clampcash30 + $clamp['parkingAmount'];
                                    }elseif($assignmentID == 63){
									$clampcash31 = $clampcash31 + $clamp['parkingAmount'];
								    }elseif($assignmentID == 66){
									$clampcash34 = $clampcash34 + $clamp['parkingAmount'];
                                    }elseif($assignmentID == 68){
									$clampcash35 = $clampcash35 + $clamp['parkingAmount'];
                                    }elseif($assignmentID == 70){
									$clampcash36 = $clampcash36 + $clamp['parkingAmount'];
                                    }elseif($assignmentID == 71){
									$clampcash37 = $clampcash37 + $clamp['parkingAmount'];
                                    }elseif($assignmentID == 72){
									$clampcash38 = $clampcash38 + $clamp['parkingAmount'];
                                    }elseif($assignmentID == 73){
									$clampcash39 = $clampcash39 + $clamp['parkingAmount'];
                                    }
								}
				   endforeach;
				   
						
						?>		
							<td><?php
									if($assignmentID == 30 ){
								 echo $cashc = $clampcash1; 
								 }elseif($assignmentID == 31 ){
								 echo $cashc = $clampcash2; 
								 }elseif($assignmentID == 32 ){
								 echo $cashc = $clampcash3; 
								 }elseif($assignmentID == 33 ){
								 echo $cashc = $clampcash4; 
								 }elseif($assignmentID == 34 ){
								 echo $cashc = $clampcash5; 
								 }elseif($assignmentID == 35 ){
								 echo $cashc = $clampcash6; 
								 }elseif($assignmentID == 36 ){
								 echo $cashc = $clampcash7; 
								 }elseif($assignmentID == 37 ){
								 echo $cashc = $clampcash8; 
								 }elseif($assignmentID == 38 ){
								 echo $cashc = $clampcash9; 
								 }elseif($assignmentID == 39 ){
								 echo $cashc = $clampcash10; 
								 }elseif($assignmentID == 40 ){
								 echo $cashc = $clampcash11; 
								 }elseif($assignmentID == 41 ){
								 echo $cashc = $clampcash12; 
								 }elseif($assignmentID == 42 ){
								 echo $cashc = $clampcash13; 
								 }elseif($assignmentID == 43 ){
								 echo $cashc = $clampcash14; 
								 }elseif($assignmentID == 44 ){
								 echo $cashc = $clampcash15; 
								 }elseif($assignmentID == 45 ){
								 echo $cashc = $clampcash16; 
								 }elseif($assignmentID == 46 ){
								 echo $cashc = $clampcash17; 
								 }elseif($assignmentID == 47 ){
								 echo $cashc = $clampcash18; 
								 }elseif($assignmentID == 48 ){
								 echo $cashc = $clampcash19; 
								 }elseif($assignmentID == 49 ){
								 echo $cashc = $clampcash20; 
								 }elseif($assignmentID == 50 ){
								 echo $cashc = $clampcash21; 
								 }elseif($assignmentID == 51 ){
								 echo $cashc = $clampcash22; 
								 }elseif($assignmentID == 52 ){
								 echo $cashc = $clampcash23; 
								 }elseif($assignmentID == 53 ){
								 echo $cashc = $clampcash24; 
								 }elseif($assignmentID == 54 ){
								 echo $cashc = $clampcash25; 
								 }elseif($assignmentID == 55 ){
								 echo $cashc = $clampcash26; 
								 }elseif($assignmentID == 56 ){
								 echo $cashc = $clampcash27; 
								 }elseif($assignmentID == 57 ){
								 echo $cashc = $clampcash28; 
								 }elseif($assignmentID == 59 ){
								 echo $cashc = $clampcash29; 
								 }elseif($assignmentID == 60 ){
								 echo $cashc = $clampcash30; 
								 }elseif($assignmentID == 63 ){
								 echo $cashc = $clampcash31; 
								 }elseif($assignmentID == 66 ){
								 echo $cashc = $clampcash34; 
								 }elseif($assignmentID == 68 ){
								 echo $cashc = $clampcash35; 
								 }elseif($assignmentID == 70 ){
								 echo $cashc = $clampcash36; 
								 } elseif($assignmentID == 71 ){
								 echo $cashc = $clampcash37; 
								 }elseif($assignmentID == 72 ){
								 echo $cashc = $clampcash38; 
								 }elseif($assignmentID == 73 ){
								 echo $cashc = $clampcash39; 
								 }
								
																 
								 ?>
							
							</td>
							<td><?php
									if($assignmentID == 30 ){
								 echo $cashc + $cashs + $cash; 
								 }elseif($assignmentID == 31 ){
								  echo $cashc + $cashs + $cash; 
								 }elseif($assignmentID == 32 ){
								  echo $cashc + $cashs + $cash;  
								 }elseif($assignmentID == 33 ){
								  echo $cashc + $cashs + $cash; 
								 }elseif($assignmentID == 34 ){
								  echo $cashc + $cashs + $cash; 
								 }elseif($assignmentID == 35 ){
								 echo $cashc + $cashs + $cash; 
								 }elseif($assignmentID == 36 ){
								  echo $cashc + $cashs + $cash; 
								 }elseif($assignmentID == 37 ){
								  echo $cashc + $cashs + $cash; 
								 }elseif($assignmentID == 38 ){
								  echo $cashc + $cashs + $cash; 
								 }elseif($assignmentID == 39 ){
								  echo $cashc + $cashs + $cash; 
								 }elseif($assignmentID == 40 ){
								  echo $cashc + $cashs + $cash; 
								 }elseif($assignmentID == 41 ){
								  echo $cashc + $cashs + $cash;  
								 }elseif($assignmentID == 42 ){
								  echo $cashc + $cashs + $cash; 
								 }elseif($assignmentID == 43 ){
								  echo $cashc + $cashs + $cash;  
								 }elseif($assignmentID == 44 ){
								  echo $cashc + $cashs + $cash;  
								 }elseif($assignmentID == 45 ){
								  echo $cashc + $cashs + $cash; 
								 }elseif($assignmentID == 46 ){
								  echo $cashc + $cashs + $cash; 
								 }elseif($assignmentID == 47 ){
								  echo $cashc + $cashs + $cash; 
								 }elseif($assignmentID == 48 ){
								  echo $cashc + $cashs + $cash; 
								 }elseif($assignmentID == 49 ){
								  echo $cashc + $cashs + $cash; 
								 }elseif($assignmentID == 50 ){
								  echo $cashc + $cashs + $cash;  
								 }elseif($assignmentID == 51 ){
								  echo $cashc + $cashs + $cash; 
								 }elseif($assignmentID == 52 ){
								 echo $cashc + $cashs + $cash; 
								 }elseif($assignmentID == 53 ){
								  echo $cashc + $cashs + $cash; 
								 }elseif($assignmentID == 54 ){
								  echo $cashc + $cashs + $cash; 
								 }elseif($assignmentID == 55 ){
								 echo $cashc + $cashs + $cash; 
								 }elseif($assignmentID == 56 ){
								  echo $cashc + $cashs + $cash; 
								 }elseif($assignmentID == 57 ){
								 echo $cashc + $cashs + $cash; 
								 }elseif($assignmentID == 59 ){
								 echo $cashc + $cashs + $cash; 
								 }elseif($assignmentID == 60 ){
								  echo $cashc + $cashs + $cash; 
								 }elseif($assignmentID == 63 ){
								 echo $cashc + $cashs + $cash; 
								 }elseif($assignmentID == 66 ){
								  echo $cashc + $cashs + $cash; 
								 }elseif($assignmentID == 68 ){
								 echo $cashc + $cashs + $cash; 
								 }elseif($assignmentID == 70 ){
								 echo $cashc + $cashs + $cash; 
								 }elseif($assignmentID == 71 ){
								  echo $cashc + $cashs + $cash; 
								 }elseif($assignmentID == 72 ){
								 echo $cashc + $cashs + $cash; 
								 }elseif($assignmentID == 73 ){
								 echo $cashc + $cashs + $cash; 
								 }
								
																 
								 ?>
							
							</td>
							<td>
                             </td>
							<td></td>
							<td></td>
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</div>
			<!--TABLE LISTING ENDS-->
				<h4>
				<i class="fa fa-exchange"></i> 
					<?php echo get_phrase('recorded_amount');?>
					
					<?php 
  echo "E".$todayincome; ?>

						</h4>
		
   </div>
</div>

		<?php endforeach;?>
		<?php endif;?>
	</div>
</section>

<script type="text/javascript">
	function class_section( date ) {
		window.location.href = '<?php echo base_url(); ?>index.php?admin/bydate/' + date;
	}
</script>