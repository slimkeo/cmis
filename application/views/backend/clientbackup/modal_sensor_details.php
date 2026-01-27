<?php
$edit_data = $this->db->get_where( 'sensor', array( 'id' => $param2 ) )->result_array();


   $query = $this->db->get( 'bays' );
   $bays = $query->result_array();
   
   $querys = $this->db->get( 'street' );
   $streets = $querys->result_array();


foreach ( $edit_data as $row ):
	?>
	<div class="row">
		<div class="col-md-12">
			<section class="panel">
			
			
				
				<div class="panel-heading">
					<h4 class="panel-title">
            		<i class="fa fa-wifi"></i>
					<?php echo get_phrase('sensor_details');?>
            	</h4>
				
				</div>

				<div class="panel-body">
					
					

				<div class="table-responsive">
							<table class="table table-striped table-condensed mb-none">

							
							<tr>
								<td><?php echo get_phrase('wpsdid');?></td>
								<td align="right"><?php echo $row['wpsdid'];?></td>
							</tr>
						

							
							<tr>
								<td><?php echo get_phrase('hardver');?></td>
								<td align="right"><?php echo $row['hardver'];?></td>
							</tr>
						

							
							<tr>
								<td><?php echo get_phrase('softver');?></td>
								<td align="right"><?php echo $row['softver'];?></td>
							</tr>
						
							<tr>
								<td><?php echo get_phrase('voltage');?></td>
								<td align="right"><?php echo $row['voltage'];?></td>
							</tr>
							<tr>
								<td><?php echo get_phrase('bay');?></td>
								<td align="right"><?php echo $this->db->get_where('bays' , array('bay_id' => $row['bay_id']))->row()->bay_name;?></td>
							</tr>
							<tr>
								<td><?php echo get_phrase('street');?></td>
								<td align="right"><?php echo $this->db->get_where('street' , array('street_id' => $row['street_id']))->row()->street_name;?></td>
							</tr>
							
						</table>
					</div>	
					
					
				
			
					
					
					
					

				</div>
				
				
			</section>
		</div>
	</div>

<?php
endforeach;
?>