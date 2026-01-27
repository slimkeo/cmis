<?php 

	$sensordata		=	$this->db->get_where('street' , array('street_id' => $street_id) )->row()->street_id;

	$timenow = date("Y-m-d H:i:s");
	$time = date("Y-m-d h:i:s", time() + 600);
	$timebefore = date("Y-m-d h:i:s", time() - 600);
	
 

				$sensors = $this->db->get_where( 'sensor', array('street_id' => $sensordata))->result_array();
				foreach ( $sensors as $row ): 
				
				$wpsdid = $row['wpsdid'];
				$bay = $row['slot'];
				
				 $sql = $this->db->query("SELECT * FROM results WHERE timestamp BETWEEN '$timebefore' AND '$time'");
				
				 $sensorfeed = $sql->result_array();
			
				endforeach;
				
                
                
               
		
		            
				?>

<?php
$page = $_SERVER['PHP_SELF'];
$sec = "30";
?>		
 <meta http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo base_url(); ?>index.php?admin/streetfeed/<?php echo $street_id; ?>#status'">



<div class="row">

		<div class="col-md-6 col-lg-12">
			<section class="panel">
								
			<h2 class="panel-title"><?php echo $this->db->get_where('street' , array('street_id' =>  $street_id))->row()->street_name; 
				?> - <?php echo $timenow; ?></h2>	
									
			</section>
		</div>

	
		<div class="pricing-table" id="status" >
	        <?php $count = 1;
				foreach($sensorfeed as $row):
				    
				   $carstate = $row['carstate'];
				   $wpsdid = $row['wpsdid'];
				   
				  
					
					
				if($wpsdid = '16E25B71'){
				$slot = $bay;
				}elseif($wpsdid = '16E25C71'){
				$slot = $bay;
				}elseif($wpsdid = '16E25D71'){
				$slot = $bay;
				
				}elseif($wpsdid = '16E25E71'){
				$slot = $bay;
				
				}elseif($wpsdid = '16E25F71'){
				$slot = $bay;
				
				}elseif($wpsdid = '16E26071'){
				$slot = $bay;
				
				}elseif($wpsdid = '16E26171'){
				$slot = $bay;
				
				}elseif($wpsdid = '16E26271'){
				$slot = $bay;
				
				}elseif($wpsdid = '16E26371'){
				$slot = $bay;
				
				}elseif($wpsdid = '16E26471'){
				$slot = $bay;
				
				}
			
		  ?>	
		  <div class="col-lg-2">
		
		
		<?php
		
		      
		 	if($row['carstate'] =="Bay Occupied"){
					    
					    $text = "text-danger";
					    
					}elseif($row['carstate'] =="Bay Vacant"){
					    
					    $text = "text-success";
					}else{
					    
					    $text = "";
					}
		
		?>
		
		 
			<?php
			
			echo '<div class="plan">';
			echo '<h3>';
			echo 'MSA0';echo $count++;
			echo '<span>';
			echo '<i class="fa fa-car ' . $text . '"></i>';
			echo '</span>';
			echo '</h3>';
			echo '<ul>';
			echo '<li> On - <i class="fa fa-car text-danger"></i> &nbsp;&nbsp; <i class="fa fa-car text-success"></i> - Off </li>';
			echo '<li><h5 class="">';
			echo $row['carstate'];
			echo '</h5></li></ul>';
			echo '</div>';
			
			?>
						
			
		

			

		</div>
		<?php endforeach;?>
	</div>
   </div>
</div>
</div>
